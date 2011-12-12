<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tweet extends CI_Model
{
    function __construct() 
    {
        parent::__construct();
    }
    
    public function cleanTweet($tweet) 
    {
        $tweet = strtolower ( $tweet );
        $tweet = $this->clearTwitter($tweet);
        return $this->extractTerms($tweet);
    }
    
    private function clearTwitter($tweet) 
    {
        $tweet = preg_replace('/@([A-Za-z0-9_]+)/', '', $tweet);
        $tweet = preg_replace('/#([A-Za-z0-9_]+)/', '', $tweet);
        return $tweet;
    }
    
    private function extractTerms($tweet) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, "http://search.yahooapis.com/ContentAnalysisService/V1/termExtraction/");

        $data = array(
            'output' => 'json', 
            'appid' => 'GVCMRy5a', 
            'context' => $tweet
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = json_decode(curl_exec($ch));    
        return $result->ResultSet->Result;
    }
    
}
