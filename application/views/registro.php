<div class="container">
	<?php if (isset($error)) {?>
			<div class="alert alert-danger">
			<?php echo validation_errors('<div class="container"><b><ul><li>','</li></ul></b></div>') ?>
			</div>
	<?php }?>		
    <div class="panel panel-default">

        <div class="panel-body">
				<h3 style='margin-left: 4em'>Crear nueva cuenta</h3>
				<h6 style='margin-left: 8em'>Rellena los siguientes campos con tus datos personales y una vez termines pulsa el botón.</h6>
				<hr>
				<?php echo form_open('Inicio/verificarRegistro'); ?>
                <div class="row">

				<div style='margin-left: 6em' class="container">
								<div class="col-xs-3">
									<div class="form-group">
										<label for="user">Usuario</label>
										<input type="text" name="usuario" maxlength="15" value="<?=set_value('usuario')?>" class="form-control" id="user" placeholder="Usuario">
									</div>
								</div>
								<div class="col-xs-3">
									<div class="form-group">
										<label for="pass">Contraseña</label>
										<input type="password" maxlength="16" name="clave" value="<?=set_value('clave')?>" class="form-control" id="pass" placeholder="Contraseña">
									</div>
								</div>
				</div></div><hr>
				
			<div style='margin-left: 6em' class="container">

                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="nombre" value="<?=set_value('nombre')?>" class="form-control" id="name" placeholder="Nombre">
                        </div>
					</div>
                   <div class="col-xs-4">
                        <div class="form-group">
                            <label for="surname">Apellidos</label>
                            <input type="text" name="apellidos" value="<?=set_value('apellidos')?>" class="form-control" id="surname" placeholder="Apellidos">
                        </div>
                    </div>
                </div>

				<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?=set_value('email')?>" class="form-control" id="email" placeholder="Email">
                    </div>
				</div>
				<div class="col-xs-2">
				    <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" maxlength="9" value="<?=set_value('dni')?>" class="form-control" id="dni" placeholder="DNI">
                </div>
				</div>
				</div><h6 style='color: #2874A6;'>*El DNI tiene que tener un formato válido y además la letra debe ser correcta ya que es calculada.</h6>

                <div class="row">
                    <div class="col-xs-8"><hr>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" name="direccion" value="<?=set_value('direccion')?>" class="form-control" id="address" placeholder="Dirección">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="provinces">Provincia</label>
                            <?=form_dropdown('provincia', $this->musuario->listaProvincias(), set_value('provincia_id'), 'class="form-control"');?>
                        </div>
                    </div>
					<div class="col-xs-2">
                        <div class="form-group">
                            <label for="cp">C. Postal</label>
                            <input type="numeric" name="cp" maxlength="5" value="<?=set_value('cp')?>" class="form-control" id="cp" placeholder="Código postal">
                        </div>
                    </div>
					
                </div>
				<h6 style='color: #2874A6;'>*Completa los campos de la dirección correctamente, ya que es donde vamos a realizar el envío.</h6>
        </div>	
		<hr><button style='margin-left: 7em' type="submit" name="bcontinuar" class="btn btn-success"><B>Finalizar</B>&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></button><br>
    </div>
	
    <?php echo form_close() ?>
</div>