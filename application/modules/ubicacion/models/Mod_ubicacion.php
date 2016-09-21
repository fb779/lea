<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para manejo de datos del modulo de ubicacion
 * @author oagarzond
 * @since 2016-06-15
 **/

class Mod_ubicacion extends My_model {
    
    //private $sql;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Consulta los datos de los registros de las ubicaciones
     * @access Public
     * @author oagarzond
     * @param Array $arrDatos	Arreglo asociativo con los valores para hacer la consulta
     * @return Array Registros devueltos por la consulta
     */
    public function consultar_ubicacion($arrDatos) {
        $data = array();
        $cond = '';
        $i = 0;
        if (array_key_exists("id", $arrDatos)) {
            $cond .= " AND FU.ID_UBICACION = '" . $arrDatos["id"] . "'";
        }
        if (array_key_exists("idAC", $arrDatos)) {
            $cond .= " AND FU.FK_ID_ADMIN_CONTROL = '" . $arrDatos["idAC"] . "'";
        }
        if (array_key_exists("nombre", $arrDatos)) {
            $cond .= " AND FU.C1U1_NOMBRE = '" . $arrDatos["nombre"] . "'";
        }
        
        $sql = "SELECT FU.* 
                FROM LEA_FORM_UBICACIONES FU 
                WHERE FU.ID_UBICACION IS NOT NULL " . $cond .
                " ORDER BY FU.ID_UBICACION";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i] = $row;
            $i++;
        }
        return $data;
    }
}
