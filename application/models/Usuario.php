<?php
/**
 * Modelo que realiza las llamadas a la base de datos.
 */
class Usuario extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Devuelve la lista de las provincias
     * @return type Array de provincias
     */
    public function listaProvincias()
    {
        $query      = $this->db->query("SELECT * FROM provincia ORDER BY nombre ASC");
        $result     = $query->result_array();
        $provincias = array();
        for ($i = 0; $i < count($result); $i++) {
            $provincias[$result[$i]["id"]] = $result[$i]["nombre"];
        }
        return $provincias;
    }
    
    /**
     * Le pasamos el id y devuelve el nombre
     * @param type $id id de provincia
     * @return type Nombre de la provincia
     */
    public function nombreProvincia($id)
    {
        $query = $this->db->query("SELECT * FROM provincia WHERE id = $id");
        $row   = $query->row();
        return $row->nombre;
    }
    
    /**
     * Inserta un nuevo usuario en la bd
     * @param type $datos datos a introducir
     */
    public function insertarUsuario($datos)
    {
        $this->db->insert("usuario", $datos);
    }
    
    /**
     * Actualiza los datos del usuario en la bd
     * @param type $datos datos a introducir
     */
    public function modificaUsuario($id, $datos)
    {
        $this->db->where('id', $id);
        $this->db->update("usuario", $datos);
    }
    
    /**
     * Establece que un usuario se ha dado de baja
     * @param String $id ID de usuario
     */
    public function bajaUsuario($id)
    {
        $this->db->query("UPDATE usuario SET baja=1 WHERE id='$id'");
    }
    
    /**
     * Obtiene cualquier dato del usuario que le indiquemos
     * @param type $usuario usuario que le indicamos
     * @param type $dato dato que queremos sacar
     * @return type el dato que sacamos
     */
    public function obtenerDatoUsuario($usuario, $dato)
    {
        $query = $this->db->query("SELECT $dato FROM usuario WHERE usuario = '$usuario'");
        $row   = $query->row();
        return $row->$dato;
    }
    
    /**
     * Obtiene todos los datos de un usuario
     * @param type $usuarios usuario
     * @return type datos del usuario en forma de array
     */
    public function obtenerDatosUsuario($usuario)
    {
        $query = $this->db->query("SELECT * FROM usuario WHERE usuario = '$usuario'");
        $row   = $query->row();
        return $row;
    }
    
    /**
     * Verifica si el usuario y contraseña coinciden con los almacenados en la base de datos
     * @param type $usuario usuario en forma de String
     * @param type $clave contraseña en forma de String
     * @return boolean devuelve true si es correcto y false si es incorrecto
     */
    public function loginCorrecto($usuario, $clave)
    {
        $query = $this->db->query("SELECT usuario,clave FROM usuario WHERE usuario = '$usuario' AND baja = 0");
        $row   = $query->row();
        
        if ($query->num_rows() == 0) //Si el numero de filas que devuelve es 0 ...
            {
            return false;
        } else {
            if (!password_verify($clave, $row->clave)) {
                return false;
            }
        }
        return true;
    }
}
