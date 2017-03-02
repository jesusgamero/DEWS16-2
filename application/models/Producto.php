<?php
/**
 * Modelo que realiza las llamadas a la base de datos.
 */
class Producto extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Saca los nombres de todas las categorias
     * @return type
     */
    public function verCategorias()
    {
        $query = $this->db->query('select * from categoria where mostrar=1');
        return $query->result();
    }
    
    /**
     * Recibe una id de categoria y devuelve el nombre de dicha categoria
     * @param type $id
     * @return type
     */
    public function nombreCategoria($id)
    {
        $query  = "select nombre from categoria where id=" . $id . "";
        $catnom = $this->db->query($query);
        return $catnom->row()->nombre;
    }
    
    /**
     * Recibe una id de un producto y devuelve el nombre de dicho producto
     * @param type $id
     * @return type
     */
    public function nombreProducto($id)
    {
        $query  = "select nombre from producto where id=" . $id . "";
        $pronom = $this->db->query($query);
        return $pronom->row()->nombre;
    }
    
    /**
     * Recibe una id de un producto y saca todos sus datos
     * @param type $id_pro
     * @return type
     */
    public function detalleProducto($id)
    {
        $query = ("select * from producto where id='$id' and mostrar=1");
        $dtpro = $this->db->query($query);
        return $dtpro->row();
    }
    
    /**
     * Recibe una id de categoria y devuelve un array con todos los productos de esa categoria
     * @param type $categoria_id
     * @return type
     */
    public function productosCategoria($id)
    {
        $query  = "select * from producto where categoria_id= " . $id . " and mostrar=1";
        $procat = $this->db->query($query);
        return $procat->result_array();
    }
    
    
    /**
     * Devuelve los productos detacados siempre y cuando las fechas coincidan
     * @return type
     */
    public function productosDestacados($desde, $por_pagina)
    {
        $query  = ("select * from producto where destacado=1 and mostrar=1 and finicio_dest<=CURDATE() and ffin_dest>=CURDATE() LIMIT $desde,$por_pagina");
        $prodes = $this->db->query($query);
        return $prodes->result_array();
    }
    
    /**
     * Calcula el número de productos destacados que hay.
     * @param type $id
     * @return type
     */
    public function numeroDestacados()
    {
        $query = "select * from producto where destacado=1 and mostrar=1 and finicio_dest<=CURDATE() and ffin_dest>=CURDATE()";
        $npro  = $this->db->query($query);
        return $npro->num_rows();
    }
    
    /**
     * Añade un producto a la base de datos con los datos recibidos
     * @param type $datos
     */
    public function insertaProducto($datos)
    {
        $this->db->insert('producto', $datos);
    }
    
    /**
     * Recibe una id de categoria y devuelve un array con todos los productos de esa categoria
     * @param type $categoria_id
     * @return type
     */
    public function verProductos($id)
    {
        $query  = "select * from producto where categoria_id= " . $id . " and mostrar=1";
        $procat = $this->db->query($query);
        return $procat->result();
    }
    
    /**
     * Recibe un array con los datos de una categoria, los inserta y devuelve la id que se ha autogenerado
     * @param type $cat
     * @return type id de la categoria que se ha generado
     */
    public function insertaCategoria($cat)
    {
        $this->db->insert('categoria', $cat);
        return $this->db->insert_id();
    }
    
    /**
     * Devuelve el stock de un producto
     * @param Int $id ID del producto
     * @return Int Número del stock
     */
    public function verStock($id)
    {
        $query = $this->db->query("SELECT stock FROM producto WHERE id = $id; ");
        
        return $query->row()->stock;
        
    }
	
	public function Total()
	{
		return $this->db->count_all('producto');
	}
	
	public function Lista($offset, $limit)
	{
		$this->db->limit($limit, $offset);
		return $this->db->get('producto')->result_array();
	}
}
