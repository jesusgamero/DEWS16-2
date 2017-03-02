<div class="container">
	<?php if (isset($enviado)) {?>
			<div class="alert alert-success">
			<?php echo "El email de recuperación ha sido enviado correctamente."; ?>
			</div>
	<?php }?>		
	
	<?php if (isset($no)) {?>
			<div class="alert alert-danger">
			<?php echo "No ha podido enviarse el email, vuelve a intentarlo."; ?>
			</div>
	<?php }?>		
	
    <div class="panel panel-default">

        <div class="panel-body">
				<h3 style='margin-left: 4em'>Recuperar clave</h3>
				<h6 style='margin-left: 8em'>Indicanos tu nombre de usuario y será enviado un correco de recuperación con una nueva clave para tu cuenta.</h6>
				<hr>
				<?php echo form_open('Inicio/recuperarClave'); ?>
				<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
                            <input style='margin-left: 7em' type="text" name="usuario" class="form-control" id="usuario" placeholder="Tu nombre de usuario">
                    </div>
									<?php if (!isset($enviado)){?>
										<button style='margin-left: 7em' type="submit" name="bcontinuar" class="btn btn-success"><B><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Enviar correo de recuperación</B></button>
									<?php } ?>
				</div>
        </div>	
		<hr>
			<a style='margin-left: 7em' class="btn btn btn-default" href="<?=site_url().'/Inicio/cargarVista/login'?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Volver atrás</b></a>	
    </div>
    <?php echo form_close() ?>
</div>