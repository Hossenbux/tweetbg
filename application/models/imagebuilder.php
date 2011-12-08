<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ImageBuilder extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
        error_reporting (0);
    }
    
    function build($source, $keyword) 
    {
        $j_l =5;
        $i_l =5;
        $source = "pic".$source;
        $images = array();
        
        if(is_array($keyword))
        {
            foreach ($keyword as $word) 
            {
                $images = array_merge($images, $this->{$source}($word));
            }
        }
        else 
        {
            $images = $this->{$source}($keyword);
        }
        
        $tries = 0;
        $max = count($images);
        
        $new_image = imagecreatetruecolor(140*$i_l, 140*$j_l);
        for ($i = 0; $i < $i_l; $i++)
        {
            for ($j = 0; $j < $j_l; $j++)
            {
                $img = null;
                $rand = rand(0, count($images)-1);
                if( isset($images[$rand]) && $img = imagecreatefromjpeg($images[$rand]) )
                {
                    imagecopyresampled($new_image, $img, ($i)*140, ($j)*140, 0, 0, 140, 140, 140, 140);                    
                } 
                else if($tries <= $max) 
                {
                    $tries++;                  
                    $j--;
                } 
                          
            }
        }
    
        $imgid = uniqid();
        $path = "imgs/$imgid.jpg";
        
        try 
        {
            imagejpeg($new_image, $path);
        } 
        catch (Exception $e)
        {
            //TODO: log message in log table
            die($e->getMessage());
        }
        
        return $path;
    }
    
    function pic500px($keyword) 
    {
        try{
            $oauth = new OAuth('xHkW9aeTnoYk4k1lUYicCjbKY9VXjYOWxE3OsBt8', 'SoxoUAwEOuV2lSQKLWRcj5Tm2LM4X1l4hMlr2Skc', OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
            $oauth->enableDebug();
            $params = array(
                'rpp' => 100,
                'consumer_key' => 'xHkW9aeTnoYk4k1lUYicCjbKY9VXjYOWxE3OsBt8'
            );
            $oauth->fetch("https://api.500px.com/v1/photos/search?term=$keyword", $params, OAUTH_HTTP_METHOD_GET);
            $content = json_decode($oauth->getLastResponse());
        } catch (Exception $e) { 
            echo $e->getMessage();     
            return false;  
        }
        
        $c = 0;
        $images = array();
        foreach($content->photos as $photo)
        {            
            if ($photo->rating < 5) 
            { 
                unset($content->photos[$c]);
            } 
            else 
            {
                array_push($images, $photo->image_url);
            }
            $c++;
        }
        return $images;
        
    }
    
     function picFlickr($keyword) 
     {
        $oauth = new OAuth('6b7cf68c49a2240ea83f077f8a4640eb', 'f71ccb2b1b52a473', OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
        $oauth->enableDebug();
        $params = array(
            'method' => 'flickr.photos.search',
            'text' => $keyword,
            'extras' => 'url_s',
            'format' => 'json',
            'safe_search'=> '2',
            'sort' => 'interestingness-desc',
            'nojsoncallback' => true,
        );
        try
        {
            $oauth->fetch("http://api.flickr.com/services/rest/", $params, OAUTH_HTTP_METHOD_GET);
        } 
        catch (Exception $e)
        {
            //TODO: log error in log table
            echo $e->getMessage();
            return false;
        }
        $content = json_decode($oauth->getLastResponse());
        
        $images = array();
        foreach($content->photos->photo as $photo)
        {            
            array_push($images, $photo->url_s);
        }
        
        return $images;
        
    }
     
      function picGoogle($keyword) 
      {
        $count = 0;
        $images = array();
        $url = "https://ajax.googleapis.com/ajax/services/search/images?" .
           "v=1.0&q=$keyword&as_filetype=jpg&rsz=8&imgsz=medium";
        do 
        {
            // sendRequest
            // note how referer is set manually
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, "http://tweetbg.local");
            $body = curl_exec($ch);
            curl_close($ch);
            
            // now, process the JSON string
            $json = json_decode($body);
    
            foreach($json->responseData->results as $photo)
            {   
                array_push($images, $photo->url);
            }
            
            $count += 8;
            $url = $url = "https://ajax.googleapis.com/ajax/services/search/images?" .
                "v=1.0&q=$keyword&as_filetype=jpg&rsz=8&start=$count";  
                                      
        } while($count < 20);
        
        return $images;
              
    }
}
