<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

function pic500($keyword)
{
	$oauth = new OAuth('xHkW9aeTnoYk4k1lUYicCjbKY9VXjYOWxE3OsBt8', 'SoxoUAwEOuV2lSQKLWRcj5Tm2LM4X1l4hMlr2Skc', OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
	$oauth->enableDebug();
	$oauth->fetch("https://api.500px.com/v1/photos/search?term=$keyword&rpp=100");
	$content = json_decode($oauth->getLastResponse());	
	
	$rate = 0;
	$rate_k = 0;
	$k = 0;
	
	$rated_arr = array();
	
	foreach($content->photos as $photo)
	{
		
		if ($photo->rating > 5) { 
			$rated_arr[] = $k; 
		}
		$k++;
	}
	
	$img_url = $content->photos[array_rand($rated_arr)]->image_url;
	//$img_url = str_replace("2.jpg", "4.jpg", $img_url_);
	
	return $img_url;
	
}

function pix500tile($keyword)
{
	$j_l =3;
	$i_l =3;
	
	$new_image = imagecreatetruecolor(140*$i_l, 140*$j_l);
	for ($i = 0; $i < $i_l; $i++)
	{
		for ($j = 0; $j < $j_l; $j++)
		{
				$img = null;
			$img = imagecreatefromjpeg(pic500($keyword));
			
			imagecopyresampled($new_image, $img, ($i)*140, ($j)*140, 0, 0, 140, 140, 140, 140);
		}
	}

    $imgid = uniqid();
    $path = "imgs/$imgid.jpg";
	
	echo "$path\n";
	
	try {
		imagepng($new_image, $path);
	} catch (Exception $e){
		die($e->getMessage());
	}
	
	return $path;
}


