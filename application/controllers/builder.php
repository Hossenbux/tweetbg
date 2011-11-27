<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class builder extends TweetBG_Controller {
        
    protected $conskey = '';
    protected $conssec = '';
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
        $this->load->model('ImageBuilder');
        $this->load->model('Authenticate');
        
        $keys = $this->db->query("SELECT * FROM consumer WHERE source='tweetbg'")->result();
        $this->conskey = $keys[0]->consumer_key;
        $this->conssec =  $keys[0]->consumer_secret;
    }

    function run() {        
        $sources =  $this->db->query("SELECT * FROM source_token");
        
        foreach ($sources->result() as $row)
        {
            print_r($row);
            $name = $row->screen_name;    
            
            $tweets = $this->db->query("SELECT * FROM user_tweets WHERE screen_name='$name'");
            
             foreach ($tweets->result() as $tweet) {
                $oauth = new OAuth($this->conskey, $this->conssec, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
                $oauth->enableDebug();
                $oauth->setToken($row->access_token, $row->token_secret);
                $last_id = $tweet->last_id;
                
                try {
                    $oauth->fetch("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=$name&since_id=$last_id&trim_user=true"); 
                    $json = json_decode($oauth->getLastResponse()); 
                    $this->getTweets($name, $last_id, $json, $row, $tweet->last_keyword, $this->conskey, $this->conssec);
                
                } catch (Exception $e){
                    //remove user record
                    $this->db->query("DELETE FROM user_tweets WHERE screen_name='$name'");   
                }
            }
        }
       
    }
    
    function sample($source, $keyword){
        $img = $this->ImageBuilder->build($source, $keyword);
        echo "<img src='/$img'>";
    }
    
    function getTweets($name, $last_id, $json, $row, $last_keyword, $conskey, $conssec){
                
        foreach($json as $single){
            preg_match('/([a-zA-Z0-9_-]+)\*/', $single->text, $matches);
            
            if($matches) {
                $keyword = str_replace('*', '', $matches[0]);
                if($keyword != $last_keyword) {
                    print_r($keyword);
                    require_once('tmhOAuth.php');
                    //require_once('tmhUtilities.php');
            
                    $fullPath = $this->ImageBuilder->build($row->source, $keyword);
                    
                    $tmhOAuth = new tmhOAuth(array(
                        'consumer_key'    => $conskey,
                        'consumer_secret' => $conssec,
                        'user_token'      => $row->access_token,
                        'user_secret'     => $row->token_secret,
                    ));
                                
                    $params = array(
                        //'image' => "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",
                        'image' => "/$fullPath;type=JPEG",
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
                    
                    } catch (Exception $e){
                        die($e->getMessage());
                    }
                    
                    echo "$code\n";
                    
                    //unlink($fullPath);
                    if($code == 200)
                        $this->db->query("UPDATE user_tweets SET last_keyword='$keyword', last_id=$single->id WHERE screen_name='$name'");
                    if($code == 500)
                        echo "fail\n";
                    // if ($code == 200) {
                         // tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
                    // }
                    // tmhUtilities::pr(htmlentities($tmhOAuth->response['response']));
                            
                    return;
                }
            }
        }
    }   
}