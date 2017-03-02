<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/libraries/JSON_WebServer_Controller.php');

class Agregador extends JSON_WebServer_Controller {
    public function __construct() {
        parent::__construct();
        
        // Registramos las funciones
        $this->RegisterFunction('Total()', 'Devuelve el número de productos que tenemos en la tienda');
        $this->RegisterFunction('Lista(offset, limit)', 
                'Devuelve una lista de productos de tamaño máximo [limit] comenzando desde la posición desde [offset]');
    }
    public function Total()
    {
        return $this->mproducto->Total();
    }
    
    public function Lista($offset, $limit)
    {
        $lista_productos = [];
        $productos = $this->mproducto->Lista($offset, $limit);
        foreach ($productos as $lista)
        {
            $lista_productos[] = array(
                'nombre' => $lista['nombre'],
                'descripcion' => $lista['descripcion'],
                'precio' => $lista['pvp'],
                'img' => base_url("asset/img/productos/$lista[imagen]"),
                'url' => base_url("index.php/Inicio/addProducto/$lista[id]")
                );
        }
        return $lista_productos;
    }
}