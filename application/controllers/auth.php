<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends TweetBG_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('authenticate');
    }

    public function index() {
        try{
            if(isset($_GET['oauth_verifier'])) {
                $this->session->set_userdata('oauth_verifier', $_GET['oauth_verifier']);
                $this->session->set_userdata('state', 1);
            }            
            if ($this->session->userdata('state') == 1) {
                $this->authenticate->getAccess($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'), $this->session->userdata('oauth_verifier'));    
                $this->load->view('auth');                
            } else {
               $this->authenticate->getAuth();
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }


    }
}