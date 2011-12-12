<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class builder extends TweetBG_Controller 
{

    function __construct() 
    {
        parent::__construct();
        
        require_once('tmhOAuth.php');
        require_once('tmhUtilities.php');
        
        $this->load->library('session');
        $this->load->database();
        $this->load->model('imagebuilder');
        $this->load->model('tweet');      
        $this->load->model('authenticate');
    }

    function run($my_consumer, $my_secret) 
    {
        if($my_consumer == $this->getConsumer() && $my_secret == $this->getSecret()) 
        {
                    
            $sources =  $this->db->query("SELECT * FROM source_token WHERE authenticated NOT IN('reauthenticate', 'revoked')");
            
            foreach ($sources->result() as $row) 
            {             
                $name = $row->screen_name;    
                $tweets = $this->db->query("SELECT * FROM user_tweets WHERE screen_name='$name'");
                
                 foreach ($tweets->result() as $tweet) 
                 {
                    $oauth = new OAuth($this->getConsumer(), $this->getSecret(), OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
                    $oauth->enableDebug();
                    $oauth->setToken($row->access_token, $row->token_secret);
                    $last_id = $tweet->last_id;
                    
                    try 
                    {
                        $oauth->fetch("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=$name&since_id=$last_id&trim_user=true"); 
                        $json = json_decode($oauth->getLastResponse()); 

                        if(count($json)) 
                        {
                            $this->getTweets($name, $last_id, $json, $row, $tweet->last_keyword);
                        }
                        
                    } 
                    catch (Exception $e)
                    {
                        //TODO: update log table with message
                        print_r($row);
			            echo $e->getCode() . ' failed to retrieve tweets';
                        //if($e->getCode() == '401')
                            //$this->db->query("UPDATE source_token SET authenticated='reauthenticate' WHERE screen_name='$name'");   
                    }
                }
            }
        } 
        else 
        {
            $this->output->set_status_header('401');
        }
    }
    
    function sample($source, $keyword)
    {
        $img = $this->imagebuilder->build($source, $keyword);
        echo $img; 
    }
    
    function removeSample($path, $img) 
    {
        //unlink("$path/$img");
    }
	
    private function getTweets($name, $last_id, $json, $row, $last_keyword) 
    {
            if($row->search == 'keyword') 
            {
                foreach($json as $single) 
                {
                    preg_match('/([a-zA-Z0-9_-]+)\*/', $single->text, $matches);
                
                    if($matches) 
                    {
                        $keyword = str_replace('*', '', $matches[0]);
                        
                        if($keyword != $last_keyword) 
                        {
                            $code = $this->createImage($row, $keyword);                                                                        
                            if($code == 200) 
                            {
                                $this->db->query("UPDATE user_tweets SET last_keyword='$keyword', last_id=$single->id_str WHERE screen_name='$name'");
                                //unlink("$fullPath");                                             
                            }   
                            return;  
                        }
                    }
                }
            }
                
            if ($row->search == 'string') 
            {
                $tweet =  $json[0];
                //clean tweet                   
                $keywords = $this->tweet->cleanTweet($tweet->text);
         	//a method that returns strong with no prepositions
                if(count($keywords)) {
                    $code = $this->createImage($row, $keywords);
                } else {
                    $code == 201;
                }
                   
                if($code == 200 || $code == 201 || $code == 204) 
                {
                    $this->db->query("UPDATE user_tweets SET last_id=$tweet->id_str WHERE screen_name='$name'");
                    //unlink("$fullPath");
                    return;                                               
                }
            }
        
    }

    private function createImage($row, $keyword)
    {
        $fullPath = $this->imagebuilder->build($row->source, $keyword);
        return $fullPath ? $this->uploadBG($fullPath, $row) : 204;
    }

    private function uploadBG($fullPath, $row)
    {   
        $tmhOAuth = new tmhOAuth(array(
            'consumer_key'    => $this->getConsumer(),
            'consumer_secret' => $this->getSecret(),
            'user_token'      => $row->access_token,
            'user_secret'     => $row->token_secret,
        ));
                    
        $params = array(
            'image' => "@$fullPath",
            'tile' => true,
            'use'=> true
        );

        $code = null;
        
        try 
        {
            $code = $tmhOAuth->request('POST', $tmhOAuth->url("1/account/update_profile_background_image"),
                $params,
                true, // use auth
                true  // multipart
            );        
        } 
        catch (Exception $e)
        {
            //TODO: log message in log table
            //die(var_dump($e->getMessage()));
            print_r($e->getMessage());
        }    
echo $code;
        return $code;
    }   
}
