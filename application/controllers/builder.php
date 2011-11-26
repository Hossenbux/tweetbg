<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends TweetBG_Controller {
    
    protected $req_url = 'https://api.twitter.com/oauth/request_token';
    protected $authurl = 'https://api.twitter.com/oauth/authorize';
    protected $acc_url = 'https://api.twitter.com/oauth/access_token';
    protected $api_url = 'https://api.twitter.com';
    protected $conskey = '';
    protected $conssec = '';
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
        
        $keys = $this->db->query("SELECT * FROM consumer")->result();

        $this->conskey = $keys[0]->consumer_key;
        $this->conssec = $keys[0]->consumer_secret;
    }
    
    function index() {
        
    }
