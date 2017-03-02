<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/libraries/JSON_WebServer_Controller.php');

class Server extends JSON_WebServer_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->RegisterFunction('Total()', 'Devuelve el número de elementos que tenemos en la tienda');
        $this->RegisterFunction('Lista(offset, limit)', 
                'Devuelve una lista de productos de tamaño máximo [limit] comenzando desde la posición desde [offset]');
    }
    public function Total()
    {
        return $this->mproducto->numeroDestacados();
    }
    
    public function Lista($offset, $limit)
    {
        return $this->mproducto->productosAgregador($offset,$limit);
    }

    public function Prueba($offset, $limit)
    {
        echo "<pre>";
        print_r($this->tienda->Lista((int)$offset,(int) $limit));
        echo "</pre>";
    }
    
    public function Producto($producto_id)
    {
        echo "<h1>Compra de producto ....</h1><p>Ha decidido comprar el producto $producto_id</p>";
    }
}