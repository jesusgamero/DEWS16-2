<div class="container">
        <div class="panel panel-default">
			<div class="panel-body">
				<br><center>
				<h3 style='margin-left: 1em'><b>Detalle del pedido Nº <?=$this->uri->segment(3)?></b></h3></center>				
				<hr>
				<table class="table table-bordered">
				<tr>
				<td align="center"><b>#Refrencia</b></td>
				<td align="center"><b>Nombre del producto</b></td>
				<td align="center"><b>Precio</b></td>
				<td align="center"><b>Unidades</b></td>
				<td align="center"><b>Detalles</b></td>
				</tr>
				<?php foreach ($articulos as $articulo): ?>
				<tr>
				<td align="center"><b><?=$articulo->id?></b></td>
				<td align="center"><?=$this->mproducto->nombreProducto($articulo->producto_id)?></td>
				<td align="center"><?=$articulo->precio?></td>
				<td align="center"><?=$articulo->unidades?></td>
				<td align="center"><?=$articulo->detalle?></td>
				</tr>
				
				<?php endforeach; ?>
				
				</table>
				
				<table class="table table-striped">
				<tr>
				<td align="right"><b>Importe:</b> <?php echo ($this->mpedido->calculaTotal($this->uri->segment(3)))-($this->mpedido->calculaIVA($this->uri->segment(3)))?> €</td>
				</tr>
				<tr>
				<td align="right"><b>IVA:</b> <?=$this->mpedido->calculaIVA($this->uri->segment(3))?> €</td>
				</tr>
				<tr>
				<td align="right"><b>Total: <?=$this->mpedido->calculaTotal($this->uri->segment(3))?> €</b></td>
				</tr>
				</table>
				<br>
				<a class="btn btn btn-default" href="<?=site_url().'/Inicio/verPedidos/'.$this->session->userdata('id')?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Volver atrás</b></a></center><br><br>
			</div>
		</div>
</div>
