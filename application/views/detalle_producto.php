<div class="container">

	<div class="row">
		<div class="col-md-7 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-body">
				<a href="<?=site_url()."/Inicio/mostrarCategoria/".$detalles->categoria_id?>" class="close"><span class="glyphicon glyphicon-remove"></a>
				<div class="col-md-6 col-xs-12">
					<center><img src="<?= base_url()."asset/img/productos/".$detalles->imagen?>" height="300px" width="300px"></center><br><br>
				</div>
				<div class="col-md-6 col-xs-12">
				<h3><b><?=strtoupper($detalles->nombre)?></b></h3><br>
					<b>Marca:</b><?=$detalles->marca?><br>
					<b>Drecipción:</b><br>
					<?=$detalles->descripcion?><br>
					<?=$detalles->anuncio?><br><br>
					<b>Stock: </b>
					
					<?php if ($detalles->stock==0){
							echo '<a style="color:#CB4335;"><b>No hay stock</b></a>';
							}
							else{
							echo $detalles->stock.' disponibles';
							}
							?>		
				</div>
				</div>
				<div class="panel-footer">
					<a class="btn btn-success" href="<?=site_url().'/Inicio/addProducto/'.$detalles->id?>"><span class="glyphicon glyphicon-shopping-cart"></span><b>&nbsp;&nbsp;Comprar</b></a>
					<div class="top-right"><h4>Precio: <b><?=$detalles->pvp?> €</h4></b></div>
				</div>
			</div>
		</div>
	</div>
</div>