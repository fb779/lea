<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para manejo de datos del modulo de ubicacion
 * @author oagarzond
 * @since 2016-06-15
 **/

class Mod_inicio extends My_model {
    
    //private $sql;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Consulta el estado de avance del diligenciamiento de un formulario
     * @author dmdiazf
     * @since  2016-06-16
     */
    public function avance_formulario($idAC) {
        $avance = 0;
        $sql = "SELECT AC.ID_ADMIN_CONTROL, AC.SEC_UBIC, AC.SEC_PERS 
                FROM LEA_ADMIN_CONTROL AC 
                WHERE AC.ID_ADMIN_CONTROL = $idAC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($row->SEC_UBIC > 0) {
                $avance += ($row->SEC_UBIC > 1) ? 50 : 0;
                $avance += ($row->SEC_PERS > 1) ? 50 : 0;
            }
        }
        $this->db->close();
        return $avance;
    }
    
    /**
     * Consulta el estado de diligenciamiento de uno de los módulos de la encuesta
     * @author dmdiazf
     * @since 2016-06-16
     * @param   Int $idAC   ID de Admin Control
     * @param   Int $modulo Modulo que se quiere consultar
     * @return  Int $estado Estado del modulo
     */
    public function estado_modulo($idAC, $modulo) {
        $estado = 0;
        switch ($modulo) {
            case 0: $campo = "SEC_UBIC";
                break;
            case 1: $campo = "SEC_PERS";
                break;
        }
        $sql = "SELECT $campo 
            FROM LEA_ADMIN_CONTROL 
            WHERE ID_ADMIN_CONTROL = $idAC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $field = strtoupper($campo);
            $estado = $row[$field];
        }
        $this->db->close();
        return $estado;
    }

    /**
     * Consulta los datos de los registros del admin control
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_admin_control($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("idAC", $arrDatos)) {
            $cond .= " AND AC.ID_ADMIN_CONTROL = '" . $arrDatos["idAC"] . "'";
        }
        if (array_key_exists("fecha", $arrDatos)) {
            $cond .= " AND AC.FECHA_REGISTRO = '" . $arrDatos["fecha"] . "'";
        }
        if (array_key_exists("estado", $arrDatos)) {
            $cond .= " AND AC.ID_ESTADO_AC = '" . $arrDatos["estado"] . "'";
        }
        if (array_key_exists("usuario", $arrDatos)) {
            $cond .= " AND AC.FK_ID_USUARIO = '" . $arrDatos["usuario"] . "'";
        }
        
        $sql = "SELECT AC.* 
                FROM LEA_ADMIN_CONTROL AC 
                WHERE AC.ID_ADMIN_CONTROL IS NOT NULL " . $cond .
                " ORDER BY AC.ID_ADMIN_CONTROL";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        return $data;
    }
}
