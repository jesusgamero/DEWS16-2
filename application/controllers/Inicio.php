<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{
		
    /**
     * Muestra la pagina principal de la página, con los destacados y su paginación
     */
    public function index()
    {
		
        /* URL a la que se desea agregar la paginación*/
        $config['base_url'] = base_url() . 'index.php/Inicio/index';
        
        /*Obtiene el total de registros a paginar */
        $config['total_rows'] = $this->mproducto->numeroDestacados();
        
        /*Obtiene el numero de registros a mostrar por pagina */
        $config['per_page'] = '6';
        
        /*Indica que segmento de la URL tiene la paginación, por default es 3*/
        $config['uri_segment'] = '3';
        
        /* Se inicializa la paginacion*/
        $this->pagination->initialize($config);
        $desde    = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $producto = $this->mproducto->productosDestacados($desde, $config['per_page']);
        $cuerpo   = $this->load->view('productos', array(
            'productos' => $producto
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "Productos destacados");
    }
    
    /**
     * Carga la plantilla con los datos pasados
     * @param type $cuerpo cuerpo principal de la pagina
     * @param type $encabezado encabezado de la pagina
     */
    public function cargaPlantilla($cuerpo = '', $encabezado = "")
    {
        $categorias = $this->mproducto->verCategorias();
        $this->load->view('index', array(
            'encabezado' => $encabezado,
            'categorias' => $categorias,
            'cuerpo' => $cuerpo
        ));
    }
    
    /**
     * Muestra todos los productos que hay de una categoria pasada como parámetro.
     * @param type $id ID de la categoria
     */
    public function mostrarCategoria($id)
    {
        $producto = $this->mproducto->productosCategoria($id);
        $cuerpo   = $this->load->view('productos', array(
            'productos' => $producto
        ), TRUE);
        $this->cargaPlantilla($cuerpo, $this->mproducto->nombreCategoria($id));
    }
    
    /**
     * Muestra los detalles de un producto pasado como parametro
     * @param type $id ID del producto
     */
    public function muestraProducto($id)
    {
        $producto = $this->mproducto->detalleProducto($id);
        $cuerpo   = $this->load->view('detalle_producto', array(
            'detalles' => $producto
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
    
    /**
     * Muestra la vista de registro de usuarios
     */
    public function verRegistro()
    {
        $cuerpo = $this->load->view("registro", "", TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
    
    /**
     * Muestra la vista del panel de usuarios
     */
    public function panelUsuario()
    {
        $cuerpo = $this->load->view("panel_usuario", "", TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
    
    /**
     * Muestra la vista del login
     */
    public function verLogin()
    {
        $cuerpo = $this->load->view("login", "", TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
	
    /**
     * Verifica que los datos del formulario cumple con las reglas de validacion e inserta el usuario
     */
    public function verificarRegistro()
    {
        $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim|is_unique[usuario.usuario]');
        $this->form_validation->set_rules('clave', 'Contraseña', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
        $this->form_validation->set_rules('dni', 'DNI', 'required|trim|valid_dni|is_unique[usuario.dni]');
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email|trim');
        $this->form_validation->set_rules('cp', 'CP', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('direccion', 'Direccion', 'required');
        
        $this->form_validation->set_message('required', 'Debe introducir el campo %s');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
        $this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
        $this->form_validation->set_message('valid_dni', 'El %s no es correcto');
        $this->form_validation->set_message('is_unique', 'El campo %s ya existe y no puede estar repetido');
        
        
        if ($this->form_validation->run() === true) {
            
            $datos = array(
                'usuario' => $this->input->post('usuario'),
                'clave' => password_hash($this->input->post('clave'), PASSWORD_DEFAULT),
                'nombre' => $this->input->post('nombre'),
                'apellidos' => $this->input->post('apellidos'),
                'dni' => $this->input->post('dni'),
                'email' => $this->input->post('email'),
                'direccion' => $this->input->post('direccion'),
                'cp' => $this->input->post('cp'),
                'provincia_id' => $this->input->post('provincia')
            );
            
            
            $this->musuario->insertarUsuario($datos);
            $cuerpo = $this->load->view("usuario_creado", "", TRUE);
            $this->cargaPlantilla($cuerpo, "");
        } else {
            $cuerpo = $this->load->view("registro", array(
                'error' => ""
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
        }
        
    }
    
    /**
     * Verifica que el login es correcto y carga el panel de usuarios
     */
    public function verificarLogin()
    {
        
        $usuario  = $this->input->post('usuario');
        $clave    = $this->input->post('clave');
        $verifica = $this->musuario->loginCorrecto($usuario, $clave);
        
        if ($verifica == true) {
            $userdata = array(
                'usuario' => $this->input->post('usuario'),
                'logged_in' => TRUE,
                'id' => $this->musuario->obtenerDatoUsuario($usuario, 'id'),
                'nombre' => $this->musuario->obtenerDatoUsuario($usuario, 'nombre')
            );
            
            $this->session->set_userdata($userdata);
            
            $cuerpo = $this->load->view("panel_usuario", "", TRUE);
            $this->cargaPlantilla($cuerpo, "");
        } else {
            $cuerpo = $this->load->view("login", array(
                'error' => true
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
        }
        
    }
    
    /**
     * Carga la vista editar usuario con los datos que ese usuario tiene guardados actualmente
     * @param type $usuario Nombre de usuario
     */
    public function editaUsuario($usuario)
    {
        
        $datos  = $this->musuario->obtenerDatosUsuario($usuario);
        $cuerpo = $this->load->view("edita_usuario", array(
            'datos' => $datos
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
    
    /**
     * Verifica que los datos del formulario cumple con las reglas de validacion y modifica el usuario existente
     */
    public function verificarEdicion()
    {
        $this->form_validation->set_rules('clave1', 'Contraseña 1', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('clave2', 'Contraseña 2', 'required|trim|min_length[5]|matches[clave1]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email|trim');
        $this->form_validation->set_rules('cp', 'CP', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('direccion', 'Direccion', 'required');
        
        $this->form_validation->set_message('required', 'Debe introducir el campo %s');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
        $this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
        $this->form_validation->set_message('matches', 'Los campos %s y %s no coinciden');
        
        
        if ($this->form_validation->run() === true) {
            $id = $this->session->userdata('id');
            
            $datos = array(
                'clave' => password_hash($this->input->post('clave1'), PASSWORD_DEFAULT),
                'nombre' => $this->input->post('nombre'),
                'apellidos' => $this->input->post('apellidos'),
                'email' => $this->input->post('email'),
                'direccion' => $this->input->post('direccion'),
                'cp' => $this->input->post('cp'),
                'provincia_id' => $this->input->post('provincia')
            );
            
            
            $this->musuario->modificaUsuario($id, $datos);
            $cuerpo = $this->load->view("panel_usuario", array(
                'modificado' => true
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
        } else {
            $usuario = $this->session->userdata('usuario');
            $datos   = $this->musuario->obtenerDatosUsuario($usuario);
            $cuerpo  = $this->load->view("edita_usuario", array('datos' => $datos,'error' => true), TRUE);
            $this->cargaPlantilla($cuerpo, "");
        }
        
    }
    
    /**
     * Pone el campo baja como 1 y destruye la sesion
     * @param type $id ID del usuario
     */
    public function eliminaUsuario($id)
    {
        $this->musuario->bajaUsuario($id);
        $this->session->sess_destroy();
        redirect('Inicio');
    }
	
	/**
     * Devuelve una vista con la lista de los pedidos que tiene el usuario.
     * @param type $id ID del usuario
     */
    public function verPedidos($id)
    {
		$datos  = $this->mpedido->listarPedidos($id);
        $cuerpo = $this->load->view("pedidos", array(
            'pedidos' => $datos
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
	
	/**
     * Devuelve una vista con la lista de los articulos que tiene un pedido.
     * @param type $id ID del usuario
     */
    public function detallePedido($id)
    {
		$datos  = $this->mpedido->listarArticulos($id);
        $cuerpo = $this->load->view("detalle_pedido", array(
            'articulos' => $datos
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
	
    /**
     * Cambia el estado de un pedido a cancelado y vuelve al panel de usuario
	 * @param type $id ID del pedido
     */
    public function cancelarPedido($id)
    {
		$datos  = $this->mpedido->estadoCancelar($id);
		  redirect('/Inicio/verPedidos/'.$this->session->userdata('id'));
    }
	
    /**
     * Cierra la sesion y vuelve a la pagina principal
     */
    public function cerrarSesion()
    {
        $this->session->sess_destroy();
        redirect('Inicio');
    }
	
    /**
     * Genera el PDF de la factura
     * @param type $id ID del pedido
     */
	public function PDFPedido($id)
    {
		$pedido  = $this->mpedido->datosPedido($id);
		$articulos  = $this->mpedido->listarArticulos($id);
		
		$this->load->library('PDF');
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(30,9,' ID Pedido: '.$pedido->id,1,1,'C');
		$pdf->SetXY(40, 41);
		$pdf->Cell(75,9,' Fecha pedido: '.$pedido->fecha_pedido,1,1,'C');
		$pdf->SetFont('Times','',12);
		$pdf->SetXY(10, 55);
		$pdf->Cell(105,9,utf8_decode('    Dirección: ').$pedido->direccion,1,1);
		$pdf->Cell(105,9,'    Provincia: '.$this->musuario->nombreProvincia($pedido->provincia),1,1);
		$pdf->Cell(105,9,'    CP: '.$pedido->cp,1,1);
		$pdf->Line(10,90,200,90);
		$pdf->SetXY(10, 100);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(75,9,utf8_decode('LISTA DE ARTÍCULOS'),1,1,'C');
		
		$header = array(utf8_decode('ID Artículo'), 'Nombre', 'Unidades', 'Precio');

		// Header
		foreach($header as $col) {
			$pdf->Cell(40,7,$col,1,'','C');
		}
		
		$pdf->SetFont('Times','',12);	
		$pdf->Ln();
		$cont=116;
		foreach ($articulos as $articulo){
			$pdf->SetXY(10,$cont);
			$pdf->Cell(40,7,$articulo->id,1,1,'C');
			$pdf->SetXY(50,$cont);
			$pdf->Cell(40,7,$this->mproducto->nombreProducto($articulo->producto_id),1,1,'C');
			$pdf->SetXY(90,$cont);
			$pdf->Cell(40,7,$articulo->precio,1,1,'C');
			$pdf->SetXY(130,$cont);
			$pdf->Cell(40,7,$articulo->unidades,1,1,'C');
			$cont=$cont+7;
		}

		
		$pdf->Line(10,140,200,140);
		$pdf->SetFont('Times','B',12);
		$pdf->SetXY(10,147);
		$pdf->Cell(75,9,utf8_decode('IMPORTE DEL PEDIDO'),1,1,'C');
		$pdf->SetXY(10,156);
		$pdf->Cell(190,7,'Importe: '.(($this->mpedido->calculaTotal($id))-($this->mpedido->calculaIVA($id))).utf8_decode(' Euros'),1,1,'R');
		$pdf->SetXY(10,163);
		$pdf->Cell(190,7,'IVA: '.($this->mpedido->calculaIVA($id)).utf8_decode(' Euros'),1,1,'R');
		$pdf->SetXY(10,170);
		$pdf->Cell(190,7,'TOTAL DEL PEDIDO: '.(($this->mpedido->calculaTotal($id))+($this->mpedido->calculaIVA($id))).utf8_decode(' Euros'),1,1,'R');
		$pdf->Output();
    }
	
	/**
     * Carga la vista de para I/E XML y Excel
     */
	public function cargarMejoras()
    {
        $cuerpo = $this->load->view("opcionales", "", TRUE);
        $this->cargaPlantilla($cuerpo, "");
    }
	
	/**
    * Crea y descarga un fichero XML con las categorías y las articulos guardados en la base de datos
    */
    public function exportarXML() {
		$categorias = $this->mproducto->listaCategorias();	
        $xml = new SimpleXMLElement('<productos_por_categorias/>'); 
		
        foreach ($categorias as $categoria) {
            $xml_cat = $xml->addChild('categoria');
            foreach ($categoria as $clave => $valor) {
                if ($clave != 'id') {
                    $xml_cat->addChild($clave, utf8_encode($valor));
                }
            }
            $this->XMLArticulos($xml_cat, $categoria['id']);
        }
        
		header('Content-Type: text/html; charset=utf-8');
        Header('Content-type: octec/stream');
        Header('Content-disposition: filename="elcarrito.xml"');
        print($xml->asXML());
    }
	
	
    /**
     * Crea los articulos de cada categoria
     * @param XML $xmlcat XML de la categoría correspondiente
     * @param Int $idcat ID de la categoría correspondiente
     */
    protected function XMLArticulos($xmlcat, $idcat) {
        $lista = $this->mproducto->productosCategoria($idcat);
        $xml_articulos = $xmlcat->addChild('articulos');
		
        foreach ($lista as $articulo) {
            $xml_articulo = $xml_articulos->addChild('articulo');
			
            foreach ($articulo as $clave => $valor) {
                $xml_articulo->addChild($clave, utf8_encode($valor));
				
            }
        }
    }
	
	 /**
     * Procesa el archivo XML subido para importar.
     */
	 public function procesaXML() {
        $archivo = $_FILES['archivo'];
        if (file_exists($archivo['tmp_name'])) {
            $contentXML = utf8_encode(file_get_contents($archivo['tmp_name']));
            $xml = simplexml_load_string($contentXML);
            $this->insertaXML($xml);
			$cuerpo = $this->load->view("importacion_exitosa", "", TRUE);
            $this->CargaPlantilla($cuerpo,"Has importado los datos con exito");
        } else {
            exit('Los datos no han sido importados satisfactoriamente');
        }
    }
	
	 /**
     * Inserta los datos del XML en la base de datos
     * @param XML $xml XML del archivo importado
     */
	 function insertaXML($xml) {
        foreach ($xml as $categoria) {
            $cat['id'] = (string) $categoria->id;
            $cat['nombre'] = (string) $categoria->utf8_encode(nombre);
            $cat['descripcion'] = (string) $categoria->utf8_encode(descripcion);
			
            $categoria_id = $this->mproducto->insertaCategoria($cat);
			
            foreach ($categoria->articulos->articulo as $articulo) {
				$pro['id'] = (string) $articulo->id;
                $pro['categoria_id'] = $categoria_id;
                $pro['nombre'] = (string) $articulo->utf8_encode(nombre);
                $pro['marca'] = (string) $articulo->utf8_encode(marca);
                $pro['descripcion'] = (string) $articulo->utf8_encode(descripcion);
                $pro['descuento'] = (string) $articulo->descuento;
                $pro['anuncio'] = (string) $articulo->anuncio;
				$pro['imagen'] = (string) $articulo->imagen;
				$pro['pvp'] = (string) $articulo->pvp;
				$pro['iva'] = (string) $articulo->iva;
                $pro['stock'] = (string) $articulo->stock;
                $pro['mostrar'] = (string) $articulo->mostrar;
                $pro['finicio_dest'] = (string) $articulo->finicio_dest;
                $pro['ffin_dest'] = (string) $articulo->ffin_dest;
				$pro['destacado'] = (string) $articulo->destacado;
				
                $this->mproducto->insertaProducto($pro);
            }
        }
    }
	
	 /**
     * Recoge el archivo subido y carga los datos en las posiciones que le indicamos
     */
    public function importarExcel() {
		$this->load->library('Excel');
        $archivo = $_FILES['archivo'];
        $Excel = PHPExcel_IOFactory::load($archivo['tmp_name']);
        $Excel->setActiveSheetIndex(0);
        $worksheet = $Excel->getActiveSheet();
		
        $cat['id'] = $worksheet->getCellByColumnAndRow(4,3)->getValue();
        $cat['nombre'] = $worksheet->getCellByColumnAndRow(5,3)->getValue();
        $cat['descripcion'] = $worksheet->getCellByColumnAndRow(6,3)->getValue();
               
        $categoria_id = $this->mproducto->insertaCategoria($cat);
            
        $cont_pro = $worksheet->getHighestRow();
 
            $pro['categoria_id'] = $categoria_id;
            
            for ($fila = 7; $fila <= $cont_pro; ++$fila) {
                for ($col = 0; $col <= 12; ++$col) {
                
                switch ($col) {
                    case 0:$pro['id'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 1:$pro['nombre'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 2:$pro['marca'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 3:$pro['descripcion'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 4:$pro['descuento'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 5:$pro['anuncio'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 6:$pro['imagen'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 7:$pro['pvp'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 8:$pro['iva'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 9:$pro['stock'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 10:$pro['mostrar'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 11:$pro['finicio_dest'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    case 12:$pro['ffin_dest'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
					case 13:$pro['destacado'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();break;
                    }
                }
                    $this->mproducto->insertaProducto($pro);                  
            }
			
		$cuerpo = $this->load->view("importacion_exitosa", "", TRUE);
        $this->CargaPlantilla($cuerpo,"Excel importado con exito");
        }
}
