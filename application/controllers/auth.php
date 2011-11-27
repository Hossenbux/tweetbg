<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends TweetBG_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
        $this->load->model('authenticate');
        
        $keys = $this->db->query("SELECT * FROM consumer")->result();

        $this->authenticate->conskey = $keys[0]->consumer_key;
        $this->authenticate->conssec = $keys[0]->consumer_secret;
    }

    public function index() {
        try{
            if(isset($_GET['oauth_verifier'])) {
                $this->session->set_userdata('oauth_verifier', $_GET['oauth_verifier']);
            }            
            if( !$this->session->userdata('oauth_token') || !$this->session->userdata('oauth_verifier') ) {
               $this->authenticate->getAuth();
            } else {
                $this->authenticate->getAccess($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'), $this->session->userdata('oauth_verifier'));    
                $this->load->view('auth');
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }


    }
}