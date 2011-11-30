<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TweetBG_Controller extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
        
        $keys = $this->db->query("SELECT * FROM consumer WHERE source='tweetbg'")->result();
        $this->conskey = $keys[0]->consumer_key;
        $this->conssec =  $keys[0]->consumer_secret;
    }
    
    protected function getConsumer(){
        return $this->conssec;
    }
    
    protected function getSecret() {
        return $this->conssec;
    }
}