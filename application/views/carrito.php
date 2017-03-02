<div class="container-fluid">
        <div class="panel panel-default">
			<div class="panel-body">
				<h2 style='margin-left: 1em'><img src="<?=base_url().'asset/'?>img/carrito_lleno.png" height="50px" width="50px" /><b>&nbsp;&nbsp;Tu Carrito</h2>
				<hr>
				<table class="table table-bordered">
				<tr>
				<td colspan="6"><h4>Aquí puedes ver los productos que actualmente tienes añadidos en tu carrito de la compra. Puedes vaciar el carrito con el botón que tienes a tu derecha.</h4></td>
				<td align="center"><h5><a style="color:#CB4335;" href="<?=site_url().'/Inicio/deleteCarrito/'?>"><b>ELIMINAR CARRITO</a></b></h5></td>
				</tr>
				<tr>
				<td align="center"><b>#</b></td>
				<td align="center"><b>Imágen</b></td>
				<td align="center"><b>Nombre</b></td>
				<td align="center"><b>Cantidad</b></td>
				<td align="center"><b>Descuento</b></td>
				<td align="center"><b>PVP</b></td>
				<td align="center"><b>Quitar</b></td>
				</tr>
				<?php if($carro)
					{
						foreach($carro as $producto)
						{ ?>
							<tr>
							<td style="vertical-align: middle;" align="center"><b><a href="<?=site_url()."/Inicio/muestraProducto/".$producto["id"]?>"><?=$producto["id"]?></a></b></td>
							<td style="vertical-align: middle;" align="center"><img src="<?=base_url()."asset/img/productos/".$producto["imagen"]?>" height="40px" width="40px"></td>
							<td style="vertical-align: middle;" align="center"><b><a href="<?=site_url()."/Inicio/muestraProducto/".$producto["id"]?>"><?=strtoupper($producto["nombre"])?></a></b></td>
							<td style="vertical-align: middle;" align="center">
							
								<?php if ($producto["cantidad"]>=2){?>
								<a href="<?=site_url().'/Inicio/deleteUnidad/'.$producto["id"]?>"><span class="glyphicon glyphicon-minus"></span></a>&nbsp;&nbsp;
								<?php }else{ ?>
								<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								<?php } ?>
							<?=$producto["cantidad"]?>&nbsp;&nbsp;
							
							<a href="<?=site_url().'/Inicio/addProducto/'.$producto["id"]?>"><span class="glyphicon glyphicon-plus"></span></a></td>
							<td style="vertical-align: middle;" align="center"><?php if ($producto["descuento"]==NULL){echo "NO";}else{echo ($producto["descuento"]." %");}?></td>
							<td style="vertical-align: middle;" align="center"><?=$producto["precio"]?> €</td>
							<td style="vertical-align: middle;" align="center"><a style="color:#CB4335;" href="<?=site_url().'/Inicio/deleteProducto/'.$producto["id"]?>"><span class="glyphicon glyphicon-remove"></span></a></td>
							</tr>
				
				<?php }}?>
				
				</table>
				
				<table class="table table-striped">
				<tr>
				<td align="right"><b>Importe: <?php echo ($precio=$_SESSION['carrito']["precio_total"])." €"; ?></b></td>
				</tr>
				<tr>
				<td align="right"><b>IVA:  <?php echo ($iva=($_SESSION['carrito']["precio_total"])*0.10)." €"; ?> </b></td>
				</tr>
				<tr>
				<td align="right"><b>Total: <?php echo ($precio)." €";?></b></td>
				</tr>
				</table>
				<br>
				<div class="row">
					<div class="col-xs-4">
					<a class="btn btn btn-default" href="<?=site_url().'/Inicio/index/'.$this->session->userdata('id')?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Continuar comprando</b></a>
					</div>
					<div class="col-xs-4">
					<p>
					</div>
					<div class="col-xs-4">
					<p align="right"><a class="btn btn btn-success" href="<?=site_url().'/Inicio/insertaPedido/'?>"><b><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Finalizar compra</b></a></p>
					</div>
				</div>
				<br><br>
			</div>
		</div>
</div>
