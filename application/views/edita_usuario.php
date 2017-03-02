<div class="container">
	<?php if (isset($error)) {?>
			<div class="alert alert-danger">
			<?php echo validation_errors('<div class="container"><b><ul><li>','</li></ul></b></div>') ?>
			</div>
	<?php }?>		
    <div class="panel panel-default">

        <div class="panel-body">
				<h3 style='margin-left: 4em'>Modifica tus datos personales</h3>
				<h6 style='margin-left: 8em'>Rellena los siguientes campos con tus datos personales y una vez termines pulsa el botón.</h6>
				<hr>
				<?php echo form_open('Inicio/verificarEdicion'); ?>
                <div class="row">

				<div style='margin-left: 6em' class="container">
								<div class="col-xs-3">
									<div class="form-group">
										<label for="user">Contraseña</label>
										<input type="password" maxlength="16" name="clave1" value="" class="form-control" id="pass" placeholder="Introduce la contraseña">
									</div>
								</div>
								<div class="col-xs-3">
									<div class="form-group">
										<label for="pass">Repetir contraseña</label>
										<input type="password" maxlength="16" name="clave2" value="" class="form-control" id="pass" placeholder="Vuelve a introducir la contraseña">
									</div>
								</div>
				</div></div><hr>
				
			<div style='margin-left: 6em' class="container">

                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="nombre" value="<?=$datos->nombre?>" class="form-control" id="name" placeholder="Nombre">
                        </div>
					</div>
                   <div class="col-xs-4">
                        <div class="form-group">
                            <label for="surname">Apellidos</label>
                            <input type="text" name="apellidos" value="<?=$datos->apellidos?>" class="form-control" id="surname" placeholder="Apellidos">
                        </div>
                    </div>
                </div>

				<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?=$datos->email?>" class="form-control" id="email" placeholder="Email">
                    </div>
				</div>
				<div class="col-xs-2">
				    <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" maxlength="9" value="<?=$datos->dni?>" class="form-control" id="dni" placeholder="DNI" readonly>
                </div>
				</div>
				</div>

                <div class="row">
                    <div class="col-xs-8"><hr>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" name="direccion" value="<?=$datos->direccion?>" class="form-control" id="address" placeholder="Dirección">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="provinces">Provincia</label>
                            <?=form_dropdown('provincia', $this->musuario->listaProvincias(), $datos->provincia_id, 'class="form-control"');?>
                        </div>
                    </div>
					<div class="col-xs-2">
                        <div class="form-group">
                            <label for="cp">C. Postal</label>
                            <input type="numeric" name="cp" maxlength="5" value="<?=$datos->cp?>" class="form-control" id="cp" placeholder="Código postal">
                        </div>
                    </div>
					
                </div>
				<h6 style='color: #2874A6;'>
        </div>	
		<hr>
		<a style='margin-left: 6em' class="btn btn btn-default" href="<?=site_url().'/Inicio/cargarVista/panel_usuario'?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Volver atrás</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="submit" name="bcontinuar" class="btn btn-success"><B><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Guardar cambios</B></button><br>
    </div>
	
    <?php echo form_close() ?>
</div>