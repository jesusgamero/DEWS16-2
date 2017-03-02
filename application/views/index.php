<html lang="es">
<head>

   <!--Cabecera-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="La mejor tienda de productos frescos de internet">
    <meta name="author" content="Jesús Gamero">
	<link rel="shortcut icon" href="<?=base_url().'asset/'?>img/favicon.png" />
	
	<!-- Custom CSS -->
    <link href="<?=base_url().'asset/'?>plantilla/css/style.css" rel="stylesheet">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?=base_url().'asset/'?>plantilla/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="<?=base_url().'asset/'?>plantilla/css/bootstrap-theme.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>El Carrito</title>
	</head>
<body style="background-color: #F8F9F9;">
	<!-- Encabezado -->
			<div class="header">
						<div class="header-top">
							<div class="container">
								 <div class="top-left">
									<p style="color:white;"><b>Contacto:<i class="glyphicon glyphicon-phone" aria-hidden="true"></i> +34 959-458-759</b></p>
								</div>
								<div class="top-right">
								<ul>
								
								<?php if ($this->session->has_userdata('usuario')):?>
											<li><a href="<?=site_url('Inicio/cargarVista/panel_usuario')?>">Bienvenido, <?=$this->session->userdata('nombre')?></a> </li>	
											<li><a href="#" data-toggle="modal" data-target="#cerrar"><b>Cerrar sesión</a></b></li>

											  <!-- Modal -->
											  <div class="modal fade" id="cerrar" role="dialog">
												<div class="modal-dialog modal-sm">
												  <div class="modal-content">
													<div class="modal-header">
													  <button type="button" class="close" data-dismiss="modal">&times;</button>
													  <h4 class="modal-title"><b>Cerrar sesión</b></h4>
													</div>
													<div class="modal-body">
													  <p>¿Estás seguro que quieres salir?</p>
													</div>
													<div class="modal-footer">
													  <a class="btn btn-success" href="<?=site_url('Inicio/cerrarSesion');?>">&nbsp;&nbsp;Si&nbsp;&nbsp;</a>
													  <button type="button" class="btn btn-danger" data-dismiss="modal">&nbsp;&nbsp;No&nbsp;&nbsp;</button>
													</div>
												  </div>
												</div>
											  </div>
	
											
								<?php else:?>
										<li><?php echo anchor('Inicio//cargarVista/login','Acceder');?></li>
										<li><?php echo anchor('Inicio/cargarVista/registro','Registrarse');?></li>         
								 <?php endif?>
								
								</ul>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="heder-bottom">
							<div class="container">
								<div class="logo-nav">
										<div class="logo-nav-left">
										<h1><img src="<?=base_url().'asset/'?>img/logo.png" alt="Smiley face" height="75" width="75">&nbsp;&nbsp;
										<a href="<?=site_url()?>">El Carrito<span>de Santiago</span></a></h1>
										<br>
										</div>
										<div class="top-right"><br><br><center>
										<a href="<?=site_url('Inicio/verCarrito');?>" style="color:white;" href="<?=site_url()?>"><img src="<?=base_url().'asset/'?>img/carrito.png" height="50" width="50">
										<b>Hay <?php echo ($this->carrito->articulos_total());?> artículos</a></b>
										<br><br><br>
										</center></div>
								</div>
							</div>
						</div>
			</div>
			
	<!-- Menú Categorías -->
			<div class="header">
							<div class="container">
							<CENTER><ul class="nav navbar-nav">
								<li>
								   <?php echo anchor('Inicio','Destacados');?>
								</li>
								<?php foreach ($categorias as $cat): ?>
								
									<li> <?php echo anchor("Inicio/mostrarCategoria/{$cat->id}", $cat->nombre) ?></li>
								<?php endforeach; ?>
							</ul></CENTER>
							</div>
			</div>
			
	<!-- Cuerpo -->
	<div class="container"><h2><?php echo $encabezado;?></h2></div>
    <?php echo $cuerpo; ?>
	
	<!-- Pie de página -->
	<div class="container">
        <hr>
			<footer><div id="footer"><br>
			<center>
			 Localización: <b><?php echo ($pie->ResolveIPResult->City).", ".($pie->ResolveIPResult->Country);?></b><br><br>
			<p>&copy; Práctica CodeIgniter DWES 2017: <B>Jesús Gamero Méndez</B><br>
			<img src="<?=base_url().'asset/'?>img/github.png" alt="Smiley face" height="42" width="42">&nbsp;&nbsp;<b>Repositorio GitHub: <a href="https://github.com/jesusgamero/Tienda-CodeIgniter">https://github.com/jesusgamero/Tienda-CodeIgniter</a></b><br><br>
			</div></footer>
    </div>
