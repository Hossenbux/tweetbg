<?php 

/*
 * 
 * 
 * 
 * TWEETBG.0BYTES.INFO
 * 
 * 
 * 
Database name :	db391902173
Host name :	db391902173.db.1and1.com
Port :	3306
User name :	dbo391902173
Description :	tweetbg: tweetbg
Version :	MySQL5.0
Status :	 setup started
 * 
 * 
 * 
 */


error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
 * Look for a picture from 500px based on a keyword
 */

require_once("500pxAPI/index.php");

$keyword = $_REQUEST['key'];


/*
 * Get a tile of pics from 500px
 */

$pic_url  = pix500tile($keyword);
echo "<img src='$pic_url' />";


/*  
 * Upload the pic to User's twitter BG 

 */
require_once 'TwitterAPI/tweetbg.php';

tweetbg($pic_url);

/* 
 * Relax
 */



/*
 * UTILS
 */



// Get image

function curlImg($img, $fullpath)
{
	$img = imagecreatefromjpeg($img);
	imagejpeg($img, $fullpath);
	
	$new_image = imagecreatetruecolor(1024, $height);
    imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
    $this->image = $new_image;
	
}





//Alternative Image Saving Using cURL
function save_image($img,$fullpath){
    $ch = curl_init ($img);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $rawdata=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($fullpath)){
        unlink($fullpath);
    }
    $fp = fopen($fullpath,'x');
    fwrite($fp, $rawdata);
    fclose($fp);
}


























?>