<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends TweetBG_Controller {
    
	function __construct() {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('session');
        if($this->session->userdata('screen_name'))
            header('Location: user');
    }

    function index() {  
        
        $platform = 'default';   
        $data = array(
            'title'  => 'hai'
        );
        
        $this->template->set_template($platform);
        $this->template->add_js('js/home.js');
        $this->template->parse_view('header', 'header', $data);
        $this->template->parse_view('content', 'home', $data);  
        $this->template->parse_view('footer', 'footer', $data);             
        $this->template->render();

    }
}
