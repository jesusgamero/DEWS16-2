<div class="container">
		<br>
        <div class="panel panel-default">
			<div class="panel-body">				
				<div class="col-md-4">
				<br><br>
					<center><img id="imagen" height="130px" width="130px" class="img-circle" src="<?=base_url().'asset/'?>img/login.png" />
					<h3>Bienvenido</h3></center>
				
				</div>
				<div class="col-md-4">
						<?php if (isset($error)) :?>
							<center>
							<h5 style="color:red;"><B>Error de autenticacion:<br></B> Usuario o contraseña incorrectos</h5>
							</center>
						<?php endif;?>
						<h3>Iniciar sesión</h3></center>
						<div>
						<?php echo form_open('Inicio/verificarLogin'); ?>
							<label for="usuario">Usuario:</label>
							<input type="text" id="usuario" name="usuario" value="<?=set_value('usuario')?>" class="form-control" placeholder="Inserte el nombre de usuario" required autofocus><br>
							<label for="clave">Contraseña:</label>
							<input type="password" id="clave" name="clave" value="<?=set_value('clave')?>" class="form-control" placeholder="Inserte su clave de acceso" required><br>
							<button class="btn btn-default" type="submit">Iniciar sesión</button>
							<a style='margin-left: 2em' href="<?=site_url().'/Inicio/cargarVista/recuperar_clave'?>"></span><b>¿Olvidaste tu contraseña?</b></a></center>
						<?php echo form_close() ?>
						</div>
				</div>
				
				<div class="col-md-4">
				<br><br>
				<center><h4><b>¿No tienes cuenta?</b></h4>
				<h6>Resgistrarte es muy sencillo.</h4>
				<h6>Solo tienes que pulsar el botón inferior</h4>
				<h6>y rellenar los datos solicitados</h4><br>
				<a class="btn btn btn-warning" href="<?=site_url().'/Inicio/cargarVista/registro'?>"></span><b><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;&nbsp;Registrarse</b></a></center><br><br>
				</div>
        </div>
		</div>
</div>