<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de login
 * @author oagarzond
 * @since 2016-06-10
 */
class Login extends MX_Controller {

    private $module;
    
    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        //$this->module = (!empty($this->module)) ? $this->module: 'login';
    }

    /**
     * Muestra la pagina login
     * @author oagarzond
     * @since 2016-06-10
     */
    public function index() {
        $data["msgError"] = $data["msgSuccess"] = '';
        $data["header"] = "/template/header";
        $data["module"] = $this->module;
        $data["view"] = "login";
        $this->load->view("layout", $data);
    }
    
    /**
     * Validacion y autenticacion de usuarios
     * @author dmdiazf
     * @since 2015-11-10
     */
    public function userAuth() {
        $this->load->library("danecrypt");
        $this->load->model("mod_usuario", "musua");
        $this->load->model("mod_form", "mf");
        header("Content-Type: application/json; charset=utf-8");
        
        $data["result"] = false;
        $data["url"] = base_url('login');
        
        $usuario = str_replace(array("<", ">", "[", "]", "^", "'"), "", $this->input->post("usuario"));
        $clave = str_replace(array("<", ">", "[", "]", "^", "'"), "", $this->input->post("clave"));
        $encrypt = $this->danecrypt->encode($clave);
        if ($this->musua->validar_usuario($usuario, $encrypt)) {
            // Se registra el primer ingreso a la aplicacion
            
            $fechahoraactual = $this->musua->consultar_fecha_hora();
            $fechaactual = substr($fechahoraactual, 0, 10);
            $idUsua = $this->session->userdata("id");
            $arrAC = $this->musua->consultar_admin_control(array("usuario" => $idUsua));
            if(count($arrAC) == 0) {
                $arrDatosAC = array(
                    "ID_ADMIN_CONTROL" => 'SEQ_LEA_ADMIN_CONTROL.Nextval',
                    "FECHA_REGISTRO" => $fechaactual,
                    "ID_ESTADO_AC" => 0,
                    "FK_ID_USUARIO" => $idUsua
                );
                if(!$this->musua->ejecutar_insert('LEA_ADMIN_CONTROL', $arrDatosAC)) {
                    $data["message"] = "No se pudo insertar el control de registro.";
                } else {
                    $iddd = $this->musua->obtener_ultimo_id('LEA_ADMIN_CONTROL', 'ID_ADMIN_CONTROL');
                    if($iddd != false) {
                        $this->session->set_userdata(array('idAC' => $iddd));
                    }
                    $data["result"] = true;
                }
            } else {
                $this->session->set_userdata(array('idAC' => $arrAC[0]["ID_ADMIN_CONTROL"]));
                $data["result"] = true;
            }
            
            if($data["result"]) {
                $data["url"] = base_url('inicio');
            }
        } else {
            $data["result"] = false;
            $data["message"] = utf8_encode("<strong>Usuario y/o contrase&ntilde;a errados.</strong> Intente nuevamente.");
        }
        //pr($data); exit;
        echo json_encode($data);
    }
    
    /**
     * Cierra la sesion y sale del aplicativo
     * @author dmdiazf
     * @since  22/10/2015
     */
    public function salir() {
        $this->session->unset_userdata("auth");
        $this->session->sess_destroy();
        redirect(base_url(), "location", 301);
    }
}
//EOC