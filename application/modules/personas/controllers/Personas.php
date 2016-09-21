<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de personas
 * @author oagarzond
 * @since 2016-06-16
 */
class Personas extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->module = (!empty($this->module)) ? $this->module: 'login';
    }

    public function index() {
        //pr($this->session->all_userdata()); exit;
        $this->load->model("mod_form", "mf");
        $this->load->model("mod_personas", "mp");
        $this->load->model("inicio/mod_inicio", "mi");
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $idAC = $this->session->userdata("idAC");
        $arrAC = $this->mi->consultar_admin_control(array("idAC" => $idAC));
        //pr($arrAC); exit;
        if($arrAC[0]["SEC_PERS"] == "0") {
            // Se actualiza para que quede en estado 1
            $fechahoraactual = $this->mi->consultar_fecha_hora();
            $fechaactual = substr($fechahoraactual, 0, 10);
            $arrDatosAC["SEC_PERS"] = 1;
            $arrDatosAC["FECHA_INI_PERS"] = $fechaactual;
            $arrWhereAC["ID_ADMIN_CONTROL"] = $idAC;
            if (!$this->mp->ejecutar_update('LEA_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
            }
            $this->mostrar_personas();
        } else if($arrAC[0]["SEC_PERS"] == "1") {
            $this->mostrar_personas();
        } else if($arrAC[0]["SEC_PERS"] == "2") {
            redirect(base_url('inicio'));
        }
    }
    
    /**
     * Se muestra la pantalla de la ubicacion
     * @author oagarzond
     * @since 2016-06-16
     */
    private function mostrar_personas() {
        $data["msgError"] = $data["msgSuccess"] = '';
        $idAC = $this->session->userdata("idAC");
        //$arrPers = $this->mu->consultar_personas(array('idAC' => $idAC));
        //pr($arrPers); exit;
        $arrPers = array();
        $data["view"] = "personas";
        $data["FK_ID_ADMIN_CONTROL"] = $idAC;
        if (count($arrPers) > 0) {
            $data["ID_PERSONA"] = $arrPers[0]["ID_UBICACION"];
        }
        $arrVar = $this->mf->consultar_variables('LEA_FORM_PERSONAS', 2);
        //pr($arrVar); exit;
        if (count($arrVar) > 0) {
            foreach ($arrVar as $kv => $vv) {
                if (!empty($arrPers[0][$vv["ID_VARIABLE"]])) {
                    $arrVar[$kv]["VALOR"] = $arrPers[0][$vv["ID_VARIABLE"]];
                }
            }
        }

        $data["var"] = $arrVar;
        $data["header"] = "/template/navbar";
        $data["module"] = $this->module;
        //pr($data); exit;
        $this->load->view("layout", $data);
    }
    
    public function buscarPersonas() {
        $this->load->model("mod_personas", "mp");
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        $config["per_page"] = ($rows > 0) ? $rows: 50;
        $start = ($page > 0) ? (($config["per_page"] * $page) - $config["per_page"]): 0;
        $sidx = "INTERNO_PERSONA";
        $sord = (strlen($sord))? "DESC": "DESC";
        $arrParam = array();
        
        $datosPers = $this->cam->buscar_personas($arrParam);
        pr($datosPers); exit;
        if (count($datosPers) > 0) {
            
        }
    }
}
//EOC