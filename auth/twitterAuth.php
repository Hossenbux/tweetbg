<?php

require_once('db.php');

class TwitterAuth {
	
	protected $req_url = 'https://api.twitter.com/oauth/request_token';
	protected $authurl = 'https://api.twitter.com/oauth/authorize';
	protected $acc_url = 'https://api.twitter.com/oauth/access_token';
	protected $api_url = 'https://api.twitter.com';
	protected $conskey = '';
	protected $conssec = '';
    
	
	function __construct(){
		
		$con = new DB();
		
		$keys = $con->query("SELECT * FROM consumer");
		$keys = mysql_fetch_array($keys);
		$this->conskey = $keys[0];
		$this->conssec = $keys[1];
		
		$con->close();
	}
	
	private function getOAuth(){
		$oauth = new OAuth($this->conskey,$this->conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
		$oauth->enableDebug();
		return $oauth;
	}
	
	public function getAuth(){
		$oauth = $this->getOAuth();
	   	$request_token_info = $this->getRequest();
        
        $_SESSION['oauth_token'] = $request_token_info['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token_info['oauth_token_secret'];
        
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
			'last_id'	=> $json->status->id
		);

		$this->saveUser( (object)$user );
	}

	private function saveUser($user){

		try{
			
			$con = new DB();

			$ret = $con->query("REPLACE INTO source_token (screen_name, access_token, token_secret)
			VALUES ('$user->screen_name', '$user->access_token', '$user->token_secret')");
			
			if($ret){
				$con->query("INSERT INTO user_tweets (screen_name, last_id)
				VALUES ('$user->screen_name', '$user->last_id')");
			}
			
			$con->close();
			
		} catch (Exception $e){
			die($e->getMessage());
		}
	}
}

?>