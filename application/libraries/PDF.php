<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
   class PDF extends FPDF
	{
		// Cabecera de página
		function Header()
		{	
			$this->Line(10,10,200,10);
			$this->Image('http://www.laspesaincampagna.it/html/eec/img/icons/cart.png',20,13,18);
            $this->SetFont('Arial','B',16);
            $this->Cell(30);
            $this->Cell(28,25,utf8_decode('El Carrito'),0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','B',8);
            $this->Cell(30);
            $this->Cell(28,25,utf8_decode('de Santiago'),0,0,'C');
            $this->Line(10,35,200,35);
			$this->Ln(26);
		}

		// Pie de página
		function Footer()
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		}
	}
?>