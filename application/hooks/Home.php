<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home {

    private $ci;
    private $db;

    public function __construct() {
        $this->ci = & get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
        //$this->db = $this->ci->load->database("default", true);
    }

    public function check_login() {
        $error = FALSE;
        $arrModules = array("ieredirect", "login");
        if (!in_array($this->ci->uri->segment(1), $arrModules)) {
            if ($this->ci->session->userdata('id') == FALSE) {
                redirect(base_url('login'));
            }
        }
    }
}
//EOC