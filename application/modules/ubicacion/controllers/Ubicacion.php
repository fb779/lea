<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de inicio
 * @author oagarzond
 * @since 2016-06-10
 */
class Ubicacion extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->module = (!empty($this->module)) ? $this->module: 'login';
    }

    public function index() {
        //pr($this->session->all_userdata()); exit;
        $this->load->model("mod_form", "mf");
        $this->load->model("mod_ubicacion", "mu");
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
        if($arrAC[0]["SEC_UBIC"] == "0") {
            // Se actualiza para que quede en estado 1
            $fechahoraactual = $this->mi->consultar_fecha_hora();
            $fechaactual = substr($fechahoraactual, 0, 10);
            $arrDatosAC["SEC_UBIC"] = 1;
            $arrDatosAC["PAG_UBIC"] = 1;
            $arrDatosAC["FECHA_INI_UBIC"] = $fechaactual;
            $arrWhereAC["ID_ADMIN_CONTROL"] = $idAC;
            if (!$this->mu->ejecutar_update('LEA_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
            }
            $this->mostrar_ubicacion(1);
        } else if($arrAC[0]["SEC_UBIC"] == "1") {
            $fechahoraactual = $this->mi->consultar_fecha_hora();
            $fechaactual = substr($fechahoraactual, 0, 10);
            if (!empty($postt) && count($postt) > 0) {
                if ($arrAC[0]["PAG_UBIC"] == "1") {
                    if ($ID_UBICACION > 0) {
                        foreach ($postt as $nombre_campo => $valor) {
                            $arrDatosUbi[$nombre_campo] = $valor;
                            $data[$nombre_campo] = $valor;
                        }
                        unset($arrDatosUbi['ID_UBICACION'], $arrDatosUbi['FK_ID_ADMIN_CONTROL']);
                        unset($arrDatosUbi['pagina'], $data['pagina']);
                        $arrWhereUbi["ID_UBICACION"] = $ID_UBICACION;
                        $arrWhereUbi["FK_ID_ADMIN_CONTROL"] = $FK_ID_ADMIN_CONTROL;
                        if (!$this->mu->ejecutar_update('LEA_FORM_UBICACIONES', $arrDatosUbi, $arrWhereUbi)) {
                            $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
                        } else {
                            $arrDatosAC["PAG_UBIC"] = 2;
                            $arrWhereAC["ID_ADMIN_CONTROL"] = $idAC;
                            if (!$this->mu->ejecutar_update('LEA_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                                $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
                            }
                        }
                    } else {
                        foreach ($postt as $nombre_campo => $valor) {
                            $arrDatosUbi[$nombre_campo] = $valor;
                            $data[$nombre_campo] = $valor;
                        }
                        unset($arrDatosUbi['pagina'], $data['pagina']);
                        $arrDatosUbi["ID_UBICACION"] = 'SEQ_LEA_FORM_UBICACIONES.Nextval';
                        if (!$this->mu->ejecutar_insert('LEA_FORM_UBICACIONES', $arrDatosUbi)) {
                            $data["msgError"] = "No se pudo guardar correctamente la ubicación. Error: " . $this->mu->get_sql();
                            $data["ID_UBICACION"] = $this->musua->obtener_ultimo_id('LEA_FORM_UBICACIONES', 'ID_UBICACION');
                        } else {
                            $arrDatosAC["PAG_UBIC"] = 2;
                            $arrWhereAC["ID_ADMIN_CONTROL"] = $idAC;
                            if (!$this->mu->ejecutar_update('LEA_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                                $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
                            }
                        }
                    }
                    
                    if (empty($data["msgError"])) {
                        $this->mostrar_ubicacion(2);
                    }
                } else if ($arrAC[0]["PAG_UBIC"] == "2") {
                    foreach ($postt as $nombre_campo => $valor) {
                        $arrDatosUbi[$nombre_campo] = $valor;
                        $data[$nombre_campo] = $valor;
                    }
                    unset($arrDatosUbi['ID_UBICACION'], $arrDatosUbi['FK_ID_ADMIN_CONTROL']);
                    unset($arrDatosUbi['pagina'], $data['pagina']);
                    $arrWhereUbi["ID_UBICACION"] = $ID_UBICACION;
                    $arrWhereUbi["FK_ID_ADMIN_CONTROL"] = $FK_ID_ADMIN_CONTROL;
                    if (!$this->mu->ejecutar_update('LEA_FORM_UBICACIONES', $arrDatosUbi, $arrWhereUbi)) {
                        $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
                    } else {
                        $arrDatosAC["SEC_UBIC"] = 2;
                        $arrDatosAC["FECHA_FIN_UBIC"] = $fechaactual;
                        $arrWhereAC["ID_ADMIN_CONTROL"] = $idAC;
                        if (!$this->mu->ejecutar_update('LEA_ADMIN_CONTROL', $arrDatosAC, $arrWhereAC)) {
                            $data["msgError"] = "No se pudo actualizar correctamente la ubicación. Error: " . $this->mu->get_sql();
                        }
                    }
                    
                    if (empty($data["msgError"])) {
                        redirect(base_url('personas'));
                    }
                }
            } else {
                if($arrAC[0]["PAG_UBIC"] == "1") {
                    $this->mostrar_ubicacion(1);
                } else if($arrAC[0]["PAG_UBIC"] == "2") {
                    $this->mostrar_ubicacion(2);
                }
            }
        } else if($arrAC[0]["SEC_UBIC"] == "2") {
            $this->mostrar_ubicacion(1);
            //redirect(base_url('inicio'));
        }
    }
    
    /**
     * Se muestra la pantalla de la ubicacion
     * @author oagarzond
     * @since 2016-06-16
     */
    private function mostrar_ubicacion($pagina) {
        $data["msgError"] = $data["msgSuccess"] = '';
        $idAC = $this->session->userdata("idAC");
        $arrUbi = $this->mu->consultar_ubicacion(array('idAC' => $idAC));
        //pr($arrUbi); exit;
        
        if ($pagina == 1) {
            $data["view"] = "ubicacion";
            $data["ID_UBICACION"] = 0;
            $data["FK_ID_ADMIN_CONTROL"] = $idAC;
            $arrUbi = $this->mu->consultar_ubicacion(array('idAC' => $idAC));
            //pr($arrUbi); exit;
            if(count($arrUbi) > 0) {
                $data["ID_UBICACION"] = $arrUbi[0]["ID_UBICACION"];
            }
            
            $arrVar = $this->mf->consultar_variables('LEA_FORM_UBICACION', 1);
            if (count($arrVar) > 0) {
                foreach ($arrVar as $kv => $vv) {
                    if(!empty($arrUbi[0][$vv["ID_VARIABLE"]])) {
                        $arrVar[$kv]["VALOR"] = $arrUbi[0][$vv["ID_VARIABLE"]];
                    }
                    if ($vv["ID_VARIABLE"] == "C1U2_DPTO") {
                        $arrDpto = $this->mf->consultar_departamentos();
                        if (count($arrDpto) > 0) {
                            foreach ($arrDpto as $kd => $vd) {
                                $arrDpto[$kd]["ID_VARIABLE"] = $vv["ID_VARIABLE"];
                            }
                            $arrVar[$kv]["OPCIONES"] = $arrDpto;
                        }
                    } else if ($vv["ID_VARIABLE"] == "C1U3_MPIO") {
                        $arrMpio = $this->mf->consultar_municipios();
                        if (count($arrMpio) > 0) {
                            foreach ($arrMpio as $km => $vm) {
                                $arrMpio[$km]["ID_VARIABLE"] = $vv["ID_VARIABLE"];
                            }
                            $arrVar[$kv]["OPCIONES"] = $arrMpio;
                        }
                    }
                }
            }
        } else if ($pagina == 2) {
            $data["view"] = "ubicacion2";
            if (count($arrUbi) > 0) {
                $data["ID_UBICACION"] = $arrUbi[0]["ID_UBICACION"];
                $data["FK_ID_ADMIN_CONTROL"] = $arrUbi[0]["FK_ID_ADMIN_CONTROL"];
            }
            $arrVar = $this->mf->consultar_variables('LEA_FORM_UBICACION', 2);
            //pr($arrVar); exit;
            if (count($arrVar) > 0) {
                foreach ($arrVar as $kv => $vv) {
                    if (!empty($arrUbi[0][$vv["ID_VARIABLE"]])) {
                        $arrVar[$kv]["VALOR"] = $arrUbi[0][$vv["ID_VARIABLE"]];
                    }
                }
            }
        }
        
        $data["var"] = $arrVar;
        $data["header"] = "/template/navbar";
        $data["module"] = $this->module;
        //pr($data); exit;
        $this->load->view("layout", $data);
    }
    
    /**
     * Se crea el HTML de las opciones de la lista desplegable
     * @author ogarzond
     * @since 2016-06-15
     */
    public function listaDesplegable() {
        $opc = $this->input->post('opc');
        $id = $this->input->post('id');
        $html = '';
        
        switch ($opc) {
            case 'mpio':
                $this->load->model("mod_form", "mf");
                
                $arrMpio = $this->mf->consultar_municipios($id);
                if(count($arrMpio) > 0) {
                    $html .= "<option value=''>Seleccione</option>";
                    foreach ($arrMpio as $km => $vm) {
                        $html .= "<option value='" . $vm['ID_VALOR'] . "'>" . $vm['ETIQUETA'] . "</option>";
                    }
                }
                echo $html;
                break;
            default:
                echo 'No se ha seleccionado una opción valida.';
                break;
        }
    }
}
//EOC