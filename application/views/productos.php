<div class="container">
	<div class="row">
	<?php foreach ($productos as $producto) : ?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
				
					<div class="panel panel-default">
						<div class="panel-body">
							<center><img src="<?= base_url()."asset/img/productos/".$producto['imagen']?>" height="180px" width="180px"></center><br>
							<b><?php echo anchor("Inicio/muestraProducto/{$producto['id']}",strtoupper($producto['nombre']));?></b>
						</div>
					</div>
					
							<b>Drecipción:</b><br>
							<?=$producto['descripcion']?><br><br>
							<b>Stock:</b>
							<?php if ($producto['stock']==0){
							echo '<a style="color:#CB4335;"><b>No hay stock</b></a>';
							}
							else{
							echo $producto['stock'].' disponibles';
							}
							?>			
				</div>
				<div class="panel-footer">
					<a class="btn btn-success" href="<?=site_url().'/Inicio/addProducto/'.$producto['id']?>"><span class="glyphicon glyphicon-shopping-cart"></span><b>&nbsp;&nbsp;Comprar</b></a>
					<div class="top-right"><h4>Precio: <b><?=$producto['pvp']?> €</h4></b></div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
	<center><b><?php echo $this->pagination->create_links() ?></b></center>
</div>