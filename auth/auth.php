<?php

class TwitterAuth {
	
	protected $req_url = 'https://api.twitter.com/oauth/request_token';
	protected $authurl = 'https://api.twitter.com/oauth/authorize';
	protected $acc_url = 'https://api.twitter.com/oauth/access_token';
	protected $api_url = 'https://api.twitter.com/';
	
	public function getAccessToken($conskey = 'WMlOe7DvrfnQo58lzOTDdQ', $conssec = 'YZ4Ie9JEZhwflbbbwTslwyL0G7ZK2A1S0S2cUMbo' ){
		if(!isset($_GET['oauth_token']) && $_SESSION['state']==1) $_SESSION['state'] = 0;
		try {
		  $oauth = new OAuth($conskey,$conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
		  $oauth->enableDebug();
		  if(!isset($_GET['oauth_token']) && !$_SESSION['state']) {
		    $request_token_info = $oauth->getRequestToken($this->req_url);
		    $_SESSION['secret'] = $request_token_info['oauth_token_secret'];
		    $_SESSION['state'] = 1;
		    header('Location: '.$this->authurl.'?oauth_token='.$request_token_info['oauth_token']);
		    exit;
		  } else if($_SESSION['state']==1) {
		    $oauth->setToken($_GET['oauth_token'],$_SESSION['secret']);
		    $access_token_info = $oauth->getAccessToken($this->acc_url);
		    $_SESSION['state'] = 2;
		    $_SESSION['token'] = $access_token_info['oauth_token'];
		    $_SESSION['secret'] = $access_token_info['oauth_token_secret'];
		  } 
		  $oauth->setToken($_SESSION['token'],$_SESSION['secret']);
		  $oauth->fetch("$this->api_url/user.json");
		  $json = json_decode($oauth->getLastResponse());
		  print_r($json);
		} catch(OAuthException $E) {
		  print_r($E);
		}	
	}
}

?>