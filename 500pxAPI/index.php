<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

$access_token = $_SESSION['access_token'];
$consumer_key = 'xHkW9aeTnoYk4k1lUYicCjbKY9VXjYOWxE3OsBt8';
$consumer_secret = 'SoxoUAwEOuV2lSQKLWRcj5Tm2LM4X1l4hMlr2Skc';

/* Create a TwitterOauth object with consumer/user tokens. */
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

echo "<img src='$img_url' />";
/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham'));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992)));
//$connection->post('friendships/destroy', array('id' => 9436992)));

/* Include HTML to display on the page */
//include('html.inc');
