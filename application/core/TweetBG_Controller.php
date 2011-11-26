<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TweetBG_Controller extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    private function getOAuth(){
            $oauth = new OAuth($this->conskey,$this->conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
            $oauth->enableDebug();
            return $oauth;
        }
        
    public function getAuth(){
        $oauth = $this->getOAuth();
        $request_token_info = $this->getRequest();
        
        $this->session->set_userdata('oauth_token', $request_token_info['oauth_token']);
        $this->session->set_userdata('oauth_token_secret', $request_token_info['oauth_token_secret']);
        
        header('Location: '.$this->authurl.'?oauth_token='.$request_token_info['oauth_token']);
    }
    
    public function getRequest(){
        $oauth = $this->getOAuth(); 
        return $oauth->getRequestToken($this->req_url);
    }

    public function getAccess($oauth_token, $oauth_token_secret, $oauth_verifier){
        $oauth = $this->getOAuth();     
        $oauth->setToken($oauth_token, $oauth_token_secret);
        $access_token_info = $oauth->getAccessToken($this->acc_url, null, $oauth_verifier);
        $this->session->unset_userdata('oauth_token');
        $this->session->unset_userdata('oauth_token_secret');
        $this->session->unset_userdata('oauth_verifier');
        $this->getSource($access_token_info['oauth_token'], $access_token_info['oauth_token_secret']);      
    }
    
    private function getSource($access_token, $token_secret){
        $oauth = $this->getOAuth();
        
        $oauth->setToken($access_token, $token_secret);

        try {
            $oauth->fetch("$this->api_url/1/account/verify_credentials.json?include_entities=true"); 
        } catch(Exception $e){
            die($e->getMessage());
        }
        $json = json_decode($oauth->getLastResponse()); 

        $user = array(
            'screen_name' => $json->screen_name,
            'access_token'=> $access_token,
            'token_secret'=> $token_secret,
            'last_id'   => $json->status->id
        );

        $this->saveUser( (object)$user );
    }

    private function saveUser($user){

        try{
            $ret = $this->db->query("REPLACE INTO source_token (screen_name, access_token, token_secret)
            VALUES ('$user->screen_name', '$user->access_token', '$user->token_secret')");
            
            if($ret){
                $this->db->query("INSERT INTO user_tweets (screen_name, last_id)
                VALUES ('$user->screen_name', '$user->last_id')");
            }
            
        } catch (Exception $e){
            die($e->getMessage());
        }
    }
}