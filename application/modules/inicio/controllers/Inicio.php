<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de inicio
 * @author oagarzond
 * @since 2016-06-10
 */
class Inicio extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //$this->module = $this->uri->segment(1);
        //$this->module = (!empty($this->module)) ? $this->module: 'login';
    }

    public function index() {
        $data["msgError"] = $data["msgSuccess"] = '';
        $data["header"] = "/template/navbar";
        $data["module"] = $this->module;
        $data["view"] = "inicio";
        $this->load->view("layout", $data);
    }
    
    /**
     * Actualiza los controles del inicio del formulario de acuerdo al avance en el diligenciamiento del formulario
     * @author oagarzond
     * @since 2016-06-16
     */
    public function actualizarAvance() {
        $this->load->model("mod_inicio", "mi");
        header("Content-Type: text/plain; charset=utf-8");
        
        $idAC = $this->session->userdata("idAC");
        //$modulo["nombre"] = utf8_encode($this->session->userdata("nombre"));
        $modulo["avance"] = $this->mi->avance_formulario($idAC);
        for ($i = 1; $i <= 2; $i ++) {
            $modulo["campo" . $i] = $this->mi->estado_modulo($idAC, $i - 1);
        }
        echo json_encode($modulo);
    }
}
//EOC