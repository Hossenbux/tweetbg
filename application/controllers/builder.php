<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends TweetBG_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Authenticate');
        
        $keys = $this->db->query("SELECT * FROM consumer")->result();

        $this->Authenticate->conskey = $keys[0]->consumer_key;
        $this->Authenticate->conssec = $keys[0]->consumer_secret;
    }
    
    function index() {
        die('nothing yet');
    }
}