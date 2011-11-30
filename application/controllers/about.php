<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends TweetBG_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('session');
    }

    function index() {  
        
        $platform = 'default';   
        $data = array(
            'title'  => 'About'
        );
        
        $this->template->set_template($platform);
        $this->template->add_js('js/about.js');
        $this->template->parse_view('header', 'header', $data);
        $this->template->parse_view('content', 'about', $data);  
        $this->template->parse_view('footer', 'footer', $data);             
        $this->template->render();

    }
}
