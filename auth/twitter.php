<?php
	require_once('twitterAuth.php');
	$connection = new TwitterAuth();
	$connection->getAuth();
