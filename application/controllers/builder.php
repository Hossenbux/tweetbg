<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class builder extends TweetBG_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
        $this->load->model('imagebuilder');
        $this->load->model('authenticate');
    }

    function run($my_consumer, $my_secret) {
        if($my_consumer == $this->getConsumer() && $my_secret == $this->getSecret()) {
                    
            $sources =  $this->db->query("SELECT * FROM source_token WHERE authenticated NOT IN('reauthenticate', 'revoked')");
            
            foreach ($sources->result() as $row) {              
                $name = $row->screen_name;    
                $tweets = $this->db->query("SELECT * FROM user_tweets WHERE screen_name='$name'");
                
                 foreach ($tweets->result() as $tweet) {
                    
                    $oauth = new OAuth($this->getConsumer(), $this->getSecret(), OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
                    $oauth->enableDebug();
                    $oauth->setToken($row->access_token, $row->token_secret);
                    $last_id = $tweet->last_id;
                    
                    try {
                        echo 'gettings tweets';
                        $oauth->fetch("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=$name&since_id=$last_id&trim_user=true"); 
                        $json = json_decode($oauth->getLastResponse()); 
                        
                        var_dump($json);
                        if(count($json)) {
                            $this->getTweets($name, $last_id, $json, $row, $tweet->last_keyword);
                        }
                        
                    } catch (Exception $e){
                        echo var_dump($e->getCode());
                        if($e->getCode() == '401')
                            $this->db->query("UPDATE source_token SET authenticated='reauthenticate' WHERE screen_name='$name'");   
                    }
                }
            }
        } else {
            $this->output->set_status_header('401');
        }
    }
    
    function sample($source, $keyword){
        $img = $this->imagebuilder->build($source, $keyword);
        echo $img;
        //unlink("$img");   
    }
	
    function getTweets($name, $last_id, $json, $row, $last_keyword){

        foreach($json as $single){
            if($row->search = 'keyword') {
                preg_match('/([a-zA-Z0-9_-]+)\*/', $single->text, $matches);
            
                if($matches) {
                    $keyword = str_replace('*', '', $matches[0]);
                    if($keyword != $last_keyword) {
                        echo "gettings images\n";
                        
                        $tries = 0;
                        while($this->createImage($row, $keyword) == 500 && $tries < 5) {
                            $tries++;
                             echo "failed trying again\n";
                             echo "code: $code\n";
                            
                        }
                        $code = $this->createImage($row, $keyword);

                        if($code == 200) {
                            $this->db->query("UPDATE user_tweets SET last_keyword='$keyword', last_id=$single->id_str WHERE screen_name='$name'");
                            //unlink("$fullPath");                                             
                        }   
                        return;  
                    }
                }
            } else if($row->search == 'string') { //not a choice yet 
                   //remove prepositiongs
                   //a method that returns strong with no prepositions
                   $fullPath = $this->imagebuilder->build($row->source, $keyword);
                   $code = $this->uploadBG($fullPath, $row);
                        
                    echo "code: $code\n";
                    
                    //unlink($fullPath);
                    if($code == 200) {
                        $this->db->query("UPDATE user_tweets SET last_keyword='$keyword', last_id=$single->id_str WHERE screen_name='$name'");
                        //unlink("$fullPath");                   
                    }
                    if($code == 500)
                        echo "fail\n";
                            
                    return;
                   
            }
        }
    }

    function createImage($row, $keyword){
        $fullPath = $this->imagebuilder->build($row->source, $keyword);
        echo 'building image';
        return $this->uploadBG($fullPath, $row);
    }

    function uploadBG($fullPath, $row){
        require_once('tmhOAuth.php');
        require_once('tmhUtilities.php');
        
        $tmhOAuth = new tmhOAuth(array(
            'consumer_key'    => $this->getConsumer(),
            'consumer_secret' => $this->getSecret(),
            'user_token'      => $row->access_token,
            'user_secret'     => $row->token_secret,
        ));
                    
        $params = array(
            //'image' => "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",
            'image' => "@$fullPath",
            'tile' => true,
            'use'=> true
        );
        
        //echo "<img src='/$fullPath'>";
        
        try{
            $code = $tmhOAuth->request('POST', $tmhOAuth->url("1/account/update_profile_background_image"),
                $params,
                true, // use auth
                true  // multipart
            );
        
            // $oauth = new OAuth($this->conskey, $this->conssec, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
            // $oauth->enableDebug();
            // $oauth->setToken($row->access_token, $row->token_secret);
            // $oauth->fetch("https://api.twitter.com/1/account/update_profile_background_image.json", $params, OAUTH_HTTP_METHOD_POST);
        
        } catch (Exception $e){
            die(var_dump($e->getMessage()));
        }
        
         return $code;
    }   
}