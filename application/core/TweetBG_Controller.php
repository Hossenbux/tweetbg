<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TweetBG_Controller extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
        
        $keys = $this->db->query("SELECT * FROM consumer WHERE source='tweetbg'")->row();
        $this->conskey = $keys->consumer_key;
        $this->conssec =  $keys->consumer_secret;
    }
    
    protected function getConsumer(){
        return $this->conskey;
    }
    
    protected function getSecret() {
        return $this->conssec;
    }
}