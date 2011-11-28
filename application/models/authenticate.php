<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate extends CI_Model
{
        
    protected $req_url = 'https://api.twitter.com/oauth/request_token';
    protected $authurl = 'https://api.twitter.com/oauth/authorize';
    protected $acc_url = 'https://api.twitter.com/oauth/access_token';
    protected $api_url = 'https://api.twitter.com';
    public $conskey = '';
    public $conssec = '';

    function __construct() {
        parent::__construct();
        
        $this->load->database();
        
        $keys = $this->db->query("SELECT * FROM consumer")->result();

        $this->conskey = $keys[0]->consumer_key;
        $this->conssec = $keys[0]->consumer_secret;
    }
    
    private function getOAuth(){
        $oauth = new OAuth($this->conskey, $this->conssec, OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
        $oauth->enableDebug();
        return $oauth;
    }
    
    protected function getTokens(){
        return array(
            'consumer'  => $this->conskey,
            'secret'    => $this->conssec
        );
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
        $this->session->set_userdata('state', 0);
        $access_token_info = $oauth->getAccessToken($this->acc_url, null, $oauth_verifier);
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
        
        $this->session->set_userdata('screen_name', $json->screen_name);
        $this->session->set_userdata('avatar', $json->profile_image_url);
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
                $this->db->query("REPLACE INTO user_tweets (screen_name, last_id)
                VALUES ('$user->screen_name', '$user->last_id')");
            }
            
        } catch (Exception $e){
            die($e->getMessage());
        }
    }
}
