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
        $pie        = $this->geolocalizacion();
        $categorias = $this->mproducto->verCategorias();
        $this->load->view('index', array(
            'encabezado' => $encabezado,
            'categorias' => $categorias,
            'cuerpo' => $cuerpo,
            'pie' => $pie
        ));
      }
	  
	  
	/**
     * Carga una vista pasada como parámetro
     */
     public function cargarVista($vista)
      {
        $cuerpo = $this->load->view($vista, "", TRUE);
        $this->cargaPlantilla($cuerpo, "");
      }
 

    //////////////////////////// PRODUCTOS /////////////////////////////////////////////
	
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
	 	  
	//////////////////////////// USUARIOS /////////////////////////////////////////////
	
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
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email|trim|is_unique[usuario.email]');
        $this->form_validation->set_rules('cp', 'CP', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('direccion', 'Direccion', 'required');
        
        $this->form_validation->set_message('required', 'Debe introducir el campo %s');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
        $this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
        $this->form_validation->set_message('valid_dni', 'El %s no es correcto');
        $this->form_validation->set_message('is_unique', 'El campo %s ya existe y no puede estar repetido');
        
        
        if ($this->form_validation->run() === true)
          {
            
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
          }
        else
          {
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
        
        if ($verifica == true)
          {
            $userdata = array(
                'usuario' => $this->input->post('usuario'),
                'logged_in' => TRUE,
                'id' => $this->musuario->obtenerDatoUsuario($usuario, 'id'),
                'nombre' => $this->musuario->obtenerDatoUsuario($usuario, 'nombre')
            );
            
            $this->session->set_userdata($userdata);
            $this->cargarVista('panel_usuario');
          }
        else
          {
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
        
        
        if ($this->form_validation->run() === true)
          {
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
          }
        else
          {
            $usuario = $this->session->userdata('usuario');
            $datos   = $this->musuario->obtenerDatosUsuario($usuario);
            $cuerpo  = $this->load->view("edita_usuario", array(
                'datos' => $datos,
                'error' => true
            ), TRUE);
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
    
    public function recuperarClave()
      {
        $nueva = substr( md5(microtime()), 1, 8);
        
        $datos = array(
            "clave" => password_hash($nueva, PASSWORD_DEFAULT)
        );
        $email=$this->musuario->obtenerDatoUsuario($this->input->post('usuario'),'email');
		
        $this->musuario->modificaUsuario($this->musuario->obtenerDatoUsuario($this->input->post('usuario'),'id'), $datos);
        $this->email->from('aula4@iessansebastian.com', 'El carrito de Santiago');
        $this->email->to($email);
        $this->email->subject('Nueva clave para "El carrito de Santiago"');
        $this->email->message('Hola '.$this->input->post('usuario').', tu nueva contraseña es: ' . $nueva);
        
		if($this->email->send()){
				$cuerpo = $this->load->view("recuperar_clave", array(
					'enviado' => ''
				), TRUE);
				$this->cargaPlantilla($cuerpo, "");
		}else{
				$cuerpo = $this->load->view("recuperar_clave", array(
					'no' => ''
				), TRUE);
				$this->cargaPlantilla($cuerpo, "");
		}
		

		
      }
    
	//////////////////////////// PEDIDOS /////////////////////////////////////////////
	
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
        $datos     = $this->mpedido->estadoCancelar($id);
        $articulos = $this->mpedido->listarArticulos($id);
        
        foreach ($articulos as $articulo)
          {
            //Recupera el stock que hay de ese producto
            $stock  = $this->mpedido->verStock($articulo->producto_id);
            //Controla el stock actual, en este caso suma las unidades del pedido que hemos cancelado.
            $numero = $stock + $articulo->unidades;
            $this->mpedido->controlStock($articulo->producto_id, $numero);
          }
        
        redirect('/Inicio/verPedidos/' . $this->session->userdata('id'));
        
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
    public function PDFPedido($id, $salida = 'I')
      {
        $pedido    = $this->mpedido->datosPedido($id);
        $articulos = $this->mpedido->listarArticulos($id);
        
        $this->load->library('PDF');
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30, 9, ' ID Pedido: ' . $pedido->id, 1, 1, 'C');
        $pdf->SetXY(40, 41);
        $pdf->Cell(75, 9, ' Fecha pedido: ' . $pedido->fecha_pedido, 1, 1, 'C');
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(10, 55);
        $pdf->Cell(105, 9, utf8_decode('    Dirección: ') . $pedido->direccion, 1, 1);
        $pdf->Cell(105, 9, '    Provincia: ' . $this->musuario->nombreProvincia($pedido->provincia), 1, 1);
        $pdf->Cell(105, 9, '    CP: ' . $pedido->cp, 1, 1);
        $pdf->Line(10, 90, 200, 90);
        $pdf->SetXY(10, 100);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(75, 9, utf8_decode('LISTA DE ARTÍCULOS'), 1, 1, 'C');
        
        $header = array(
            'Nombre',
            'Unidades',
            'Precio'
        );
        
        // Header
        foreach ($header as $col)
          {
            $pdf->Cell(60, 7, $col, 1, '', 'C');
          }
        
        $pdf->SetFont('Times', '', 12);
        $pdf->Ln();
        $cont = 116;
        foreach ($articulos as $articulo)
          {
            $pdf->SetXY(10, $cont);
            $pdf->Cell(60, 7, $this->mproducto->nombreProducto($articulo->producto_id), 1, 1, 'C');
            $pdf->SetXY(70, $cont);
            $pdf->Cell(60, 7, $articulo->precio, 1, 1, 'C');
            $pdf->SetXY(130, $cont);
            $pdf->Cell(60, 7, $articulo->unidades, 1, 1, 'C');
            $cont = $cont + 7;
          }
        
        
        $pdf->Line(10, 140, 200, 140);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetXY(10, 147);
        $pdf->Cell(75, 9, utf8_decode('IMPORTE DEL PEDIDO'), 1, 1, 'C');
        $pdf->SetXY(10, 156);
        $pdf->Cell(190, 7, 'Importe: ' . (($this->mpedido->calculaTotal($id)) - ($this->mpedido->calculaIVA($id))) . utf8_decode(' Euros'), 1, 1, 'R');
        $pdf->SetXY(10, 163);
        $pdf->Cell(190, 7, 'IVA: ' . ($this->mpedido->calculaIVA($id)) . utf8_decode(' Euros'), 1, 1, 'R');
        $pdf->SetXY(10, 170);
        $pdf->Cell(190, 7, 'TOTAL DEL PEDIDO: ' . (($this->mpedido->calculaTotal($id)) + ($this->mpedido->calculaIVA($id))) . utf8_decode(' Euros'), 1, 1, 'R');
        $fichero = tempnam('temp/', 'Factura-') . '.pdf';
        $pdf->Output($salida, $fichero);
        if ($salida == 'F')
          {
            return $fichero;
          }
      }

	//////////////////////////// MEJORAS /////////////////////////////////////////////
	
	 /**
     * Exporta los artículos y las categorias a XML.
     */
    function exportarXML()
      {
        $categorias = $this->mproducto->verCategorias();
        
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="elcarrito.xml"');
        
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('  ');
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('lista');
        
        foreach ($categorias as $categoria)
          {
            $xml->startElement('categoria');
            $xml->writeElement("id", $categoria->id);
            $xml->writeElement("nombre", $categoria->nombre);
            $xml->writeElement("descripcion", $categoria->descripcion);
            $xml->writeElement("anuncio", $categoria->anuncio);
            $xml->writeElement("mostrar", $categoria->mostrar);
            
            $lista_productos = $this->mproducto->verProductos($categoria->id);
            
            foreach ($lista_productos as $producto)
              {
                $xml->startElement('producto');
                $xml->writeElement("id", $producto->id);
                $xml->writeElement("categoria_id", $producto->categoria_id);
                $xml->writeElement("nombre", $producto->nombre);
                $xml->writeElement("marca", $producto->marca);
                $xml->writeElement("descripcion", $producto->descripcion);
                $xml->writeElement("descuento", $producto->descuento);
                $xml->writeElement("anuncio", $producto->anuncio);
                $xml->writeElement("imagen", $producto->imagen);
                $xml->writeElement("pvp", $producto->pvp);
                $xml->writeElement("iva", $producto->iva);
                $xml->writeElement("stock", $producto->stock);
                $xml->writeElement("mostrar", $producto->mostrar);
                $xml->writeElement("finicio_dest", $producto->finicio_dest);
                $xml->writeElement("ffin_dest", $producto->ffin_dest);
                $xml->writeElement("destacado", $producto->destacado);
                $xml->endElement();
              }
            $xml->endElement();
          }
        $xml->endDocument();
        echo $xml->outputMemory();
      }
    
    /**
     * Procesa el archivo XML subido para importar.
     */
    public function procesaXML()
      {
        $archivo = $_FILES['archivo'];
        if (file_exists($archivo['tmp_name']))
          {
            $contentXML = utf8_encode(file_get_contents($archivo['tmp_name']));
            $xml        = simplexml_load_string($contentXML);
            $this->insertaXML($xml);
			$this->cargarVista('importacion_exitosa');
          }
        else
          {
            exit('Los datos no han sido importados satisfactoriamente');
          }
      }
    
    /**
     * Inserta los datos del XML en la base de datos
     * @param XML $xml XML del archivo importado
     */
    function insertaXML($xml)
      {
        foreach ($xml as $categoria)
          {
            $cat['nombre']      = (string) $categoria->nombre;
            $cat['descripcion'] = (string) $categoria->descripcion;
            $cat['anuncio']     = (string) $categoria->anuncio;
            $cat['mostrar']     = (string) $categoria->mostrar;
            
            $categoria_id = $this->mproducto->insertaCategoria($cat);
            
            foreach ($categoria->producto as $articulo)
              {
                $pro['id']           = (string) $articulo->id;
                $pro['categoria_id'] = $categoria_id;
                $pro['nombre']       = (string) $articulo->nombre;
                $pro['marca']        = (string) $articulo->marca;
                $pro['descripcion']  = (string) $articulo->descripcion;
                $pro['descuento']    = (string) $articulo->descuento;
                $pro['anuncio']      = (string) $articulo->anuncio;
                $pro['imagen']       = (string) $articulo->imagen;
                $pro['pvp']          = (string) $articulo->pvp;
                $pro['iva']          = (string) $articulo->iva;
                $pro['stock']        = (string) $articulo->stock;
                $pro['mostrar']      = (string) $articulo->mostrar;
                $pro['finicio_dest'] = (string) $articulo->finicio_dest;
                $pro['ffin_dest']    = (string) $articulo->ffin_dest;
                $pro['destacado']    = (string) $articulo->destacado;
                
                $this->mproducto->insertaProducto($pro);
              }
          }
      }
    
    /**
     * Recoge el archivo subido y carga los datos en las posiciones que le indicamos
     */
    public function importarExcel()
      {
        $this->load->library('Excel');
        $archivo = $_FILES['archivo'];
        $Excel   = PHPExcel_IOFactory::load($archivo['tmp_name']);
        $Excel->setActiveSheetIndex(0);
        $worksheet = $Excel->getActiveSheet();
        
        $ncategoria['id']          = $worksheet->getCellByColumnAndRow(0, 3)->getValue();
        $ncategoria['nombre']      = $worksheet->getCellByColumnAndRow(1, 3)->getValue();
        $ncategoria['descripcion'] = $worksheet->getCellByColumnAndRow(2, 3)->getValue();
        $ncategoria['anuncio']     = $worksheet->getCellByColumnAndRow(3, 3)->getValue();
        $ncategoria['mostrar']     = $worksheet->getCellByColumnAndRow(4, 3)->getValue();
        
        $categoria_id = $this->mproducto->insertaCategoria($ncategoria);
        
        $cont_pro = $worksheet->getHighestRow();
        
        for ($fila = 7; $fila <= $cont_pro; ++$fila)
          {
            for ($col = 0; $col <= 14; ++$col)
              {
                
                switch ($col)
                {
                    case 0:
                        $pro['categoria_id'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 1:
                        $pro['nombre'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 2:
                        $pro['marca'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 3:
                        $pro['descripcion'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 4:
                        $pro['descuento'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 5:
                        $pro['anuncio'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 6:
                        $pro['imagen'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 7:
                        $pro['pvp'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 8:
                        $pro['iva'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 9:
                        $pro['stock'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 10:
                        $pro['mostrar'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 11:
                        $pro['finicio_dest'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 12:
                        $pro['ffin_dest'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                    case 13:
                        $pro['destacado'] = $worksheet->getCellByColumnAndRow($col, $fila)->getValue();
                        break;
                }
              }
            $this->mproducto->insertaProducto($pro);
          }
        
        $this->cargarVista('importacion_exitosa');
      }
  
	//////////////////////////// SOAP /////////////////////////////////////////////
	
    /**
     * Utiliza el servicio SOAP para la geolocalización
     */
    public function geolocalizacion()
      {
        $client = new SoapClient('http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl');
        $param  = array(
            'ipAddress' => $this->input->ip_address(),
            'licenseKey' => ''
        );
        $result = $client->ResolveIP($param);
        return $result;
      }
    
    //////////////////////////// CARRITO /////////////////////////////////////////////
    
    /**
     * Muestra la vista del carrito
     */
    public function verCarrito()
      {
        //Creamos un nuevo carrito
        $carrito = new Carrito();
        $carro   = $carrito->get_content();
        $cuerpo  = $this->load->view("carrito", array(
            'carro' => $carro
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "");
      }
    
    /**
     * Añade un producto al carrito
     * @param Int $id id del producto
     */
    public function addProducto($id)
      {
        $producto = $this->mproducto->detalleProducto($id);
        $stock    = $this->mproducto->verStock($id);
        $cantidad = 1;
        
        if ($stock >= $cantidad) //Comprueba el stock si hay disponible añade al carrito.
          {
            
            $articulo = array(
                "id" => $producto->id,
                "cantidad" => $cantidad,
                "precio" => $producto->pvp,
                "stock" => $producto->stock,
                "nombre" => $producto->nombre,
                "descripcion" => $producto->descripcion,
                "descuento" => $producto->descuento,
                "imagen" => $producto->imagen
            );
            $this->carrito->add($articulo);
            
            redirect('Inicio/verCarrito/', 'location', 301);
          }
        else //Si no hay stock no hace nada el botón de comprar
          {
            redirect('Inicio', 'location', 301);
          }
      }
    
    /**
     * Borra un producto del carrito
     * @param Int $id id del producto
     */
    public function deleteProducto($id)
      {
        foreach ($this->carrito->get_content() as $items)
          {
            if ($items['id'] == $id)
              {
                $this->carrito->remove_producto($items['unique_id']);
              }
          }
        redirect('Inicio/verCarrito/', 'location', 301);
      }
    
    /**
     * Borra un producto del carrito
     * @param Int $id id del producto
     */
    public function deleteUnidad($id)
      {
        $producto = $this->mproducto->detalleProducto($id);
        
        $articulo = array(
            "id" => $producto->id,
            "cantidad" => 1,
            "precio" => $producto->pvp,
            "stock" => $producto->stock,
            "nombre" => $producto->nombre,
            "descripcion" => $producto->descripcion,
            "descuento" => $producto->descuento,
            "imagen" => $producto->imagen
        );
        
        $this->carrito->remove($articulo);
        
        redirect('Inicio/verCarrito/', 'location', 301);
      }
    
    
    /**
     * Elimina todo el contenido del carrito
     */
    public function deleteCarrito()
      {
        $this->carrito->destroy();
        redirect('Inicio', 'location', 301);
      }
    
    /**
     * Insertar un pedido y sus respectivos articulos
     */
    public function insertaPedido()
      {
        $usuario = $this->musuario->obtenerDatosUsuario($this->session->userdata('usuario'));
        $carro   = $this->carrito->get_content();
        
        if ($this->session->userdata('usuario') != null)
          {
            $pedido = array(
                "estado" => 'P',
                "direccion" => $usuario->direccion,
                "cp" => $usuario->cp,
                "provincia" => $usuario->provincia_id,
                "usuario_id1" => $usuario->id
            );
            
            $pedido_id = $this->mpedido->insertaPedido($pedido);
            
            //Recorro el carrito y voy insertando los articulos
            foreach ($carro as $items)
              {
                $articulo = array(
                    "pedido_id" => $pedido_id,
                    "producto_id" => $items["id"],
                    "precio" => $items["precio"],
                    "unidades" => $items["cantidad"],
                    "detalle" => $items["descripcion"]
                );
                $this->mpedido->insertaArticulo($articulo);
                
                //Controla el stock actual, en este caso resta las unidades que hemos comprado.
                $numero = $items["stock"] - $items["cantidad"];
                $this->mpedido->controlStock($items["id"], $numero);
              }
            
            $cuerpo = $this->load->view("pedido_realizado", array(
                'pedido_id' => $pedido_id
            ), TRUE);
            
            $mensaje = $this->load->view('email', array(
                'articulos' => $carro,
                'datos_usuario' => $usuario,
                'pedido_id' => $pedido_id
            ), true);
            $this->enviarMail($mensaje, $usuario->email, $pedido_id);
            $this->cargaPlantilla($cuerpo, "");
            $this->carrito->destroy();
          }
        else
          {
            $cuerpo = $this->load->view("login", array(), TRUE);
            $this->cargaPlantilla($cuerpo, "");
          }
      }
    
    public function enviarMail($mensaje, $correo, $pedido_id)
      {
        $fichero = $this->PDFPedido($pedido_id, 'F');
        $this->load->library('email');
        $this->email->from('aula4@iessansebastian.com', 'El carrito de Santiago');
        $this->email->to($correo);
        $this->email->subject('Pedido realizado a "El carrito de Santiago"');
        $this->email->message($mensaje);
        $this->email->attach($fichero);
        $this->email->send();
      }
    
  }
