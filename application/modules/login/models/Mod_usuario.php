<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para la validación de ingreso de usuarios a la aplicacion
 * @author oagarzond
 * @since  2016-06-10	 
 **/
class Mod_usuario extends My_model{
    /**
     * Valida que el usuario y clave de un usuario sea autentico y que se encuentre 
     * registrado en la base de datos
     * @author oagarzond
     * @param   String  $usuario    Login del usuario
     * @param   String  $clave      Clave del usuario
     * @return boolean
     */
    public function validar_usuario($usuario, $clave) {
        $result = false;
        
        $sql = "SELECT TO_CHAR(AU.FECHA_CREACION, 'DD/MM/YYYY') FECHAC, TO_CHAR(AU.FECHA_EXPIRACION, 'DD/MM/YYYY') FECHAE, AU.* 
            FROM LEA_ADMIN_USUARIOS AU 
            WHERE AU.ID_ESTADO_USUA = 1 ";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        while ($row = $query->unbuffered_row('array')) {
            if($row["USUARIO"] == $usuario && strcmp($row["CLAVE"], $clave) === 0) {
                $sessionData = array(
                    "auth" => "OK",
                    "id" => $row["ID_USUARIO"],
                    "usuario" => $row["USUARIO"],
                    //"clave" => $row["CLAVE"],
                    "tipo_usuario" => $row["ID_TIPO_USUARIO"],
                    "estado" => $row["ID_ESTADO_USUA"],
                    "fecha_creacion" => $row["FECHAC"],
                    "fecha_expiracion" => $row["FECHAE"]
                );
                $this->session->set_userdata($sessionData);
                $result = true;
                break;
            }
        }
        $this->db->close();
        return $result;
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
//EOC