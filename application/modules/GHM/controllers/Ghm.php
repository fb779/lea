<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de inicio
 * @author oagarzond
 * @since 2016-06-10
 */
class Ghm extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->module = (!empty($this->module)) ? $this->module: 'login';
    }

    public function index() {
        echo 'hadasd';
    }
}