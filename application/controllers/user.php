<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends TweetBG_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('Template');
        $this->load->database();
      
    }

    public function index() {
        $platform = 'default';   
        $data = array(
            'screen_name'  => $this->session->userdata('screen_name'),
            'source' => "500px",
            'search' => 'keyword'
        );
        
        $this->template->set_template($platform);
                $this->template->add_js('js/user.js');
        $this->template->parse_view('header', 'header', $data);
        $this->template->parse_view('content', 'user', $data);  
        $this->template->parse_view('footer', 'footer', $data);             
        $this->template->render();
    }
    
    public function saveSettings($screen_name, $access_token){ //cause I am too fucking lazy to generate my own identification protocol.
        
    }
}