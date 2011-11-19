<?php 
require_once('twitterAuth.php');

$twitter = new TwitterAuth();
$twitter->getAccess();


die();
$con = $link = mysql_connect('localhost', 'root', 'alpha123');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("tweetbg", $con);
mysql_query("INSERT INTO source_tokens (FirstName, LastName, Age)
VALUES ('Peter', 'Griffin', '35')");

mysql_close($link);