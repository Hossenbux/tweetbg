<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
    
	function __construct() {
        parent::__construct();
        $this->load->library('Template');
    }

    function index() {  
        
        $platform = 'default';
        
        $data = array(
            'title'  => 'hai'
        );
        
        $this->template->set_template($platform);
        $this->template->parse_view('header', 'header', $data);
        $this->template->parse_view('content', 'home', $data);  
        $this->template->parse_view('footer', 'footer', $data);             
        $this->template->render();

    }
}
