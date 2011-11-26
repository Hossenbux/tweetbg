<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends TweetBG_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('Template');
        $this->load->database();
    }

    public function index() {
        die('nothing here yet');
    }
}