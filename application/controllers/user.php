<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends TweetBG_Controller {
    protected $user;
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->database();
        $this->load->library('Template');
        $this->load->model('authenticate');
        $this->load->database();
        
        $screen_name = $this->session->userdata('screen_name');
        $this->user = $this->db->query("SELECT * FROM source_token WHERE screen_name='$screen_name'")->result();
        $this->user = $this->user[0];
      
    }

    public function index() {
        $platform = 'default';   
        $data = array(
            'screen_name'  => $this->user->screen_name,
            'avatar' => $this->session->userdata('avatar'),
            'source' => $this->user->source,
            'search' => 'keyword'
        );
        
        $this->template->set_template($platform);
                $this->template->add_js('js/user.js');
        $this->template->parse_view('header', 'header', $data);
        $this->template->parse_view('content', 'user', $data);  
        $this->template->parse_view('footer', 'footer', $data);             
        $this->template->render();
    }
    
    public function saveSettings($source, $search){ //cause I am too fucking lazy to generate my own identification protocol.
       $screen_name = $this->session->userdata('screen_name');
       try{
            $this->db->query("UPDATE source_token SET source='$source', search='$search' WHERE screen_name='$screen_name'");
            echo '200';
       } catch (Exception $e){
           echo $e->getMessage();
       }       
    }
    
    public function logout(){
        $this->session->set_userdata('state', '2');
    }
    
    public function delete(){
        $screen_name = $this->session->userdata('screen_name');
        $this->db->query("DELETE from source_token where screen_name='$screen_name'");
        $this->session->sess_destroy();
    }
}