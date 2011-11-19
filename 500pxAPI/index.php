<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

function pic500($keyword)
{
	/* If method is set change API call made. Test is called by default. */
	$content  = $connection->get('photos/search', array('term' => $keyword, 'rpp' => '99'));
	
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
	imagepng($new_image, $path);
	
	return $path;
}


