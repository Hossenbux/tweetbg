<?php

class TwitterAuth {
	
	protected $req_url = 'https://api.twitter.com/oauth/request_token';
	protected $authurl = 'https://api.twitter.com/oauth/authorize';
	protected $acc_url = 'https://api.twitter.com/oauth/access_token';
	protected $api_url = 'https://api.twitter.com';
	protected $conskey = 'WMlOe7DvrfnQo58lzOTDdQ';
	protected $conssec = 'YZ4Ie9JEZhwflbbbwTslwyL0G7ZK2A1S0S2cUMbo';
	
	private function getOAuth(){
		$oauth = new OAuth($this->conskey,$this->conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
		$oauth->enableDebug();
		return $oauth;
	}
	
	public function getAuth(){
		$oauth = $this->getOAuth();
		
	   	$request_token_info = $oauth->getRequestToken($this->req_url);
	    header('Location: '.$this->authurl.'?oauth_token='.$request_token_info['oauth_token']);
	}

	public function getAccess(){
		$oauth = $this->getOAuth();
		
		$request_token_info = $oauth->getRequestToken($this->req_url);
		$oauth->setToken($_GET['oauth_token'], $request_token_info['oauth_token_secret']);
		$access_token_info = $oauth->getAccessToken($this->acc_url);
		$this->getSource($access_token_info['oauth_token'], $access_token_info['oauth_token_secret']);		
	}
	
	private function getSource($access_token, $token_secret){
		$oauth = $this->getOAuth();
		
		$oauth->setToken($access_token, $token_secret);
		
		// print_r($access_token);
		// echo "\n";
		// die($token_secret);
// 		
		try {
	    	$oauth->fetch("$this->api_url/1/account/verify_credentials.json"); 
		} catch(Exception $e){
			die($e->getMessage());
		}
	    $json = json_decode($oauth->getLastResponse());	
		
		$user = array(
			'screen_name' => $json->screen_name,
			'access_token'=> $access_token,
			'token_secret'=> $token_secret
		);

		$this->saveUser((object)$user);
	}

	private function saveUser($user){
		//die(var_dump($user));
		try{
			$con = $link = mysql_connect('localhost', 'root', 'alpha123');
			if (!$con) {
			    die('Could not connect: ' . mysql_error());
			}
			mysql_select_db("tweetbg", $con);
			
			mysql_query("REPLACE INTO source_token (screen_name, access_token, token_secret)
			VALUES ('$user->screen_name', '$user->access_token', '$user->token_secret')");
			
			mysql_close($con);
		} catch (Exception $e){
			die($e->getMessage());
		}
	}
}

?>