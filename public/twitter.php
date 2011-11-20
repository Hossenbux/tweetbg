<?php
	require_once('../auth/twitterAuth.php');
	$connection = new TwitterAuth();
	$connection->getAuth();
