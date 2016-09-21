<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para el manejo de los formularios
 * @author oagarzond
 **/
class Mod_form extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    /**
     * Consulta las preguntas que hay en el pagina del modulo
     * @author oagarzond
     * @param   String  $seccion    Seccion de la pregunta
     * @param   String  $pagina     Pagina de la pregunta
     * @return boolean
     */
    public function consultar_variables($tabla = '', $pagina = '') {
        $data = array();
        $cond = '';
        $i = 0;
        
        if(!empty($tabla))
            $cond .= " AND TABLA_ASOCIADA = '" . $tabla . "'";
        if(!empty($pagina))
            $cond .= " AND PAGINA = '" . $pagina . "'";
        
        $sql = "SELECT * 
                FROM LEA_ADMIN_VARIABLES WHERE ID_VARIABLE IS NOT NULL " . $cond . 
                " ORDER BY ORDEN";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID_VARIABLE"] = $row["ID_VARIABLE"];
            $data[$i]["TABLA_ASOCIADA"] = $row["TABLA_ASOCIADA"];
            $data[$i]["ETIQUETA"] = $row["ETIQUETA"];
            $data[$i]["TEXTO_AUXILIAR"] = $row["TEXTO_AUXILIAR"];
            $data[$i]["DESCRIPCION"] = $row["DESCRIPCION"];
            $data[$i]["AYUDA"] = $row["AYUDA"];
            $data[$i]["TIPO_DATO"] = $row["TIPO_DATO"];
            $data[$i]["TIPO_CAMPO"] = $row["TIPO_CAMPO"];
            $data[$i]["LONGITUD"] = $row["LONGITUD"];
            $data[$i]["ORDEN"] = $row["ORDEN"];
            $data[$i]["ID_SECCION"] = $row["ID_SECCION"];
            $data[$i]["PAGINA"] = $row["PAGINA"];
            $data[$i]["VR_DEFECTO"] = $row["VR_DEFECTO"];
            $data[$i]["LONG_TEXTO"] = $row["LONG_TEXTO"];
            $data[$i]["VALOR"] = '';
            // Se consulta los posibles valores que tiene el campo
            $tempVal = $this->consultar_valores($row["ID_VARIABLE"]);
            if(count($tempVal) > 0) {
                $data[$i]["OPCIONES"] = $tempVal;
            }
            $i++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }
    
    /**
     * Consulta los posibles valores que tiene cada una de las preguntas
     * @author oagarzond
     * @param   String  $id_variable    ID de la variable de la pregunta
     * @param   String  $idValor        IDs de los valores a consultar
     * @return boolean
     */
    public function consultar_valores($idVariable = '', $idValor = '') {
        $data = array();
        $cond = '';
        $i = 0;
        
        
        if(!empty($idVariable)) {
            if (is_int($idVariable)) {
                $cond .= " AND ID_VARIABLE = " . $idVariable;
            } else if (is_string($idVariable)) {
                $cond .= " AND ID_VARIABLE = '" . $idVariable . "'";
            } else if (is_array($idVariable)) {
                $cond .= " AND ID_VARIABLE IN (" . implode(",", $idVariable) . ")";
            }
        }
        if(!empty($idValor)) {
            if (is_int($idValor)) {
                $cond .= " AND ID_VALOR = " . $idValor;
            } else if (is_string($idValor)) {
                $cond .= " AND ID_VALOR = '" . $idValor . "'";
            } else if (is_array($idValor)) {
                $cond .= " AND ID_VALOR IN (" . implode(",", $idValor) . ")";
            }
        }
        
        $sql = "SELECT * 
                FROM LEA_ADMIN_VALORES WHERE ID_VARIABLE IS NOT NULL " . $cond . 
                " ORDER BY ORDEN_VISUAL";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID_VARIABLE"] = $row["ID_VARIABLE"];
            $data[$i]["ID_VALOR"] = $row["ID_VALOR"];
            $data[$i]["ETIQUETA"] = $row["ETIQUETA"];
            $data[$i]["DESCRIPCION_OPCION"] = $row["DESCRIPCION_OPCION"];
            $data[$i]["ORDEN_VISUAL"] = $row["ORDEN_VISUAL"];
            $i++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }
    
    /**
     * Consulta las fechas festivos por anio
     * @access Public
     * @author oagarzond
     * @return  Array   $data   Registros devueltos por la consulta
     */
    public function consultar_festivos($anios) {
        $cond = "";
        $data = array();
        if (!empty($anios)) {
            if (is_int($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') = " . $anios;
            } else if (is_string($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') = '" . $anios . "'";
            } else if (is_array($anios)) {
                $cond .= " AND TO_CHAR(FECHA_FESTIVO, 'YYYY') IN ('" . implode("','", $anios) . "')";
            }
        }
        $sql = "SELECT TO_CHAR(FECHA_FESTIVO, 'YYYY-MM-DD') FECHA
                FROM RH.RH_CALENDARIO 
                WHERE 1 = 1 " . $cond;
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result('array') as $row) {
                $data[] = $row["FECHA"];
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }
    
    /**
     * Busca los departamento para los combos
     * @author alrodriguezm
     * @since 2016-01-20
     */
    function consultar_departamentos() {
        $data = array();
        $sql = "SELECT RDP.* FROM CNP_RESPUESTA_DOMINIO RDP WHERE RDP.ID_DOMINIO = 1";
        $query = $this->db->query($sql);
        $i = 0;
        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID_VALOR"] = $row["VALOR_MINIMO"];
            $data[$i]["ETIQUETA"] = $row["DESCRIPCION"];
            $i ++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }
    
    /**
     * Busca los departamento para los combos
     * @author alrodriguezm
     * @since 2016-01-20
     */
    function consultar_municipios($codiDpto = '') {
        $data = array();
        $cond = '';
        if(!empty($codiDpto)) {
            $cond .= " AND RD.ID_RESPUESTA_DOMINIO_PADRE = 
                (SELECT RDP.ID_RESPUESTA_DOMINIO FROM CNP_RESPUESTA_DOMINIO RDP WHERE RDP.ID_DOMINIO=1 AND RDP.VALOR_MINIMO='$codiDpto')";
        }
                 
        $sql = "SELECT *
            FROM CNP_RESPUESTA_DOMINIO RD 
            WHERE RD.ID_DOMINIO = 2 " . $cond . 
            " ORDER BY RD.DESCRIPCION ASC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        $i = 0;
        while ($row = $query->unbuffered_row('array')) {
            $data[$i]["ID_VALOR"] = $row["VALOR_MINIMO"];
            $data[$i]["ETIQUETA"] = $row["DESCRIPCION"];
            $i ++;
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }

}
// EOC