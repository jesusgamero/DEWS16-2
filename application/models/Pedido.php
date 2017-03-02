<?php
/**
 * Modelo que realiza las llamadas a la base de datos.
 */
class Pedido extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	/**
     * Le pasamos una letra y devuelve el nombre del estado.
     * @param type $estado Letra del estado
     * @return type Nombre del estado
     */
    public function nombreEstado($estado)
    {
		switch (strtoupper($estado)) {
		case 'C':
			return 'Cancelado';
			break;
		case 'P':
			return 'Procesando';
			break;
		case 'E':
			return 'Enviado';
			break;
		case 'R':
			return 'Recibido';
			break;
		}
    }
	
	 /**
     * Obtener la lista de pedidos de un usuario
     * @param String $id ID de usuario
     */
    public function listarPedidos($id)
    {
        $query  = "select * from pedido where usuario_id1=" . $id . "";
		$query = $this->db->query($query);
        return $query->result();
    }
	
	/**
     * Obtener los datos de un pedido
     * @param String $id ID de usuario
     */
    public function datosPedido($id)
    {
        $query  = "select * from pedido where id=" . $id . "";
		$query = $this->db->query($query);
        return $query->row();
    }
	
	/**
     * Obtener la lista de articulos de un pedido
     * @param String $id ID del pedido
     */
    public function listarArticulos($id)
    {
        $query  = "select * from articulo where pedido_id=" . $id . "";
		$query = $this->db->query($query);
        return $query->result();
    }
	
	/**
     * Si el pedido está precesandose se puede cancelar.
     * @param String $id ID del pedido.
     */
    public function estadoCancelar($id)
    {
		 $this->db->query("UPDATE pedido SET estado='C' WHERE id='$id'");
    }
	
	/**
     * Calcular el IVA de un pedido
     * @param String $id ID del pedido
     */
    public function calculaIVA($id)
    {
        $query  = "select sum((precio*unidades)*0.10) as iva from articulo where pedido_id=" . $id . "";
		$query = $this->db->query($query);
        return $query->row()->iva;
    }
	
	/**
     * Calcular total de un pedido
     * @param String $id ID del pedido
     */
    public function calculaTotal($id)
    {
        $query  = "select sum(precio*unidades) as total from articulo where pedido_id=" . $id . "";
		$query = $this->db->query($query);
        return $query->row()->total;
    }
	
}

