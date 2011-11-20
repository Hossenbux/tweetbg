<?php
require_once('db.php');

$con = new DB();

$sources = $con->query("SELECT * FROM source_token") or die(mysql_error());
$keys = $con->query("SELECT * FROM consumer");
$keys = mysql_fetch_array($keys);
$conskey = $keys[0];
$conssec = $keys[1];

while($row = mysql_fetch_array($sources))
{
	$name = $row['screen_name'];	
	
	$tweets = mysql_query("SELECT * FROM user_tweets WHERE screen_name='$name'");
	while($tweet = mysql_fetch_array($tweets)){
	
		$oauth = new OAuth($conskey, $conssec, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
		$oauth->enableDebug();
		$oauth->setToken($row['access_token'], $row['token_secret']);
		$last_id = $tweet['last_id'];
		
		try {
			$oauth->fetch("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=$name&since_id=$last_id&trim_user=true"); 
			$json = json_decode($oauth->getLastResponse());	
			getTweets($name, $last_id, $json, $row, $tweet['last_keyword'], $conskey, $conssec, $con);
		
		} catch (Exception $e){
			//remove user record
			mysql_query("DELETE FROM user_tweets WHERE screen_name='$name'");	
		}
	}

}

echo "done\n";
$con->close();

function getTweets($name, $last_id, $json, $row, $last_keyword, $conskey, $conssec, $con){
				
	foreach($json as $single){
		preg_match('/([a-zA-Z0-9_-]+)\*/', $single->text, $matches);
		
		if($matches){
			$keyword = str_replace('*', '', $matches[0]);
			
			if($keyword != $last_keyword) {
				
				require_once('500px.php');
				require_once('tmhOAuth.php');
				require_once('tmhUtilities.php');
		
				$fullPath = pix500tile($keyword);
				
				$tmhOAuth = new tmhOAuth(array(
				    'consumer_key'    => $conskey,
				    'consumer_secret' => $conssec,
				    'user_token'      => $row['access_token'],
				    'user_secret'     => $row['token_secret'],
			    ));
							
				$params = array(
				    //'image' => "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",
					'image' => "@$fullPath;type=JPEG",
					'tile' => true,
					'use'=> true
			  	);
				
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
				
				$con->query("UPDATE user_tweets SET last_keyword='$keyword', last_id=$single->id WHERE screen_name='$name'");
				
			   	// if ($code == 200) {
			    	 // tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
			   	// }
			   	// tmhUtilities::pr(htmlentities($tmhOAuth->response['response']));
						
				return;
			}
		}
	}
}
  
  
