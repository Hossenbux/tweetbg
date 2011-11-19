<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

function pic500($keyword, $consumer_key="xHkW9aeTnoYk4k1lUYicCjbKY9VXjYOWxE3OsBt8", $consumer_secret="SoxoUAwEOuV2lSQKLWRcj5Tm2LM4X1l4hMlr2Skc" )
{
	
	session_start();
	//require_once('twitteroauth/twitteroauth.php');
	require_once('config.php');

	$access_token = $_SESSION['access_token'];
	die($access_token);
	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	/* If method is set change API call made. Test is called by default. */
	$content  = $connection->get('photos/search', array('term' => 'baseball', 'rpp' => '99'));
	
	$rate = 0;
	$rate_k = 0;
	$k = 0;
	
	$rated_arr = array();
	
	foreach($content->photos as $photo)
	{
		
		if ($photo->rating > 1) { 
			$rated_arr[] = $k; 
		}
		$k++;
	}
	
	$img_url_ = $content->photos[array_rand($rated_arr)]->image_url;
	$img_url = str_replace("2.jpg", "4.jpg", $img_url_);
	
	return $img_url;
	
}




