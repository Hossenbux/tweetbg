<?php

$conskey = 'WMlOe7DvrfnQo58lzOTDdQ';
$conssec = 'YZ4Ie9JEZhwflbbbwTslwyL0G7ZK2A1S0S2cUMbo';

$con = mysql_connect('localhost', 'root', 'alpha123');
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("tweetbg", $con);

$sources = mysql_query("SELECT * FROM source_token") or die(mysql_error());


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
			getTweets($name, $last_id, $json, $row);
		
		} catch (Exception $e){
			//remove user record
			die($e->getMessage());
			
		}
	}

}

echo 'done';

function getTweets($name, $last_id, $json, $row){
				
	foreach($json as $single){
		preg_match('/([a-zA-Z0-9_-]+)\*/', $single->text, $matches);
		if($matches){
			$keyword = str_replace('*', '', $matches[0]);
			echo $keyword;
			require_once('500pxAPI/index.php');
			require_once('tmhOAuth.php');
			require_once('tmhUtilities.php');
			$fullPath = pix500tile($keyword);
			
			var_dump($row);
			var_dump($fullPath);
			var_dump($keyword);
			
			$tmhOAuth = new tmhOAuth(array(
			    'consumer_key'    => 'WMlOe7DvrfnQo58lzOTDdQ',
			    'consumer_secret' => 'YZ4Ie9JEZhwflbbbwTslwyL0G7ZK2A1S0S2cUMbo',
			    'user_token'      => $row['access_token'],
			    'user_secret'     => $row['token_secret'],
		    ));
						
			$params = array(
			    //'image' => "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",
				'image' => "@$fullPath;type=JPEG",
				'tile' => true,
				'use'=> true
		  	);

			$code = $tmhOAuth->request('POST', $tmhOAuth->url("1/account/update_profile_background_image"),
			    $params,
			    true, // use auth
			    true  // multipart
		  	);

		   	// if ($code == 200) {
		    	 // tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
		   	// }
		   	// tmhUtilities::pr(htmlentities($tmhOAuth->response['response']));
					
			return;
		}
	}
}
  
  
