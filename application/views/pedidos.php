<div class="container-fluid">
        <div class="panel panel-default">
			<div class="panel-body">
				<br><center>
				<h3 style='margin-left: 1em'><b>Ver mis pedidos</b></h3>
				<h6 style='margin-left: 2em'>En esta sección puedes visualizar todos los pedidos que has realizado en esta tienda.</h6></center>
				<hr>
				<table class="table table-bordered">
				<tr>
				<td align="center"><b>#ID</b></td>
				<td align="center"><b>Pedido detallado</b></td>
				<td align="center"><b>Estado</b></td>
				<td align="center"><b>Dirección de envio</b></td>
				<td align="center"><b>Provincia</b></td>
				<td align="center"><b>C.Postal</b></td>
				<td align="center"><b>Fecha de compra</b></td>
				<td align="center"><b>Cancelar</b></td>
				<td align="center"><b>Factura</b></td>
				</tr>
				<?php foreach ($pedidos as $pedido): ?>
				<tr>
				<td style="vertical-align: middle;" align="center"><b><?=$pedido->id?></b></td>
				<td style="vertical-align: middle;" align="center"><b><a href="<?=site_url().'/Inicio/detallePedido/'.$pedido->id?>"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;&nbsp;Ver detalles</b></a></td>
				<td style="vertical-align: middle;" align="center"><?=$this->mpedido->nombreEstado($pedido->estado)?></td>
				<td style="vertical-align: middle;" align="center"><?=$pedido->direccion?></td>
				<td style="vertical-align: middle;" align="center"><?=$this->musuario->nombreProvincia($pedido->provincia)?></td>
				<td style="vertical-align: middle;" align="center"><?=$pedido->cp?></td>
				<td style="vertical-align: middle;" align="center"><?=$pedido->fecha_pedido?></td>
				<td style="vertical-align: middle;" align="center">

				<?php if ($pedido->estado == 'P'):?>
				
					 <a style="color:red;" href="#" data-toggle="modal" data-target="#bpedido"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;Cancelar pedido</a>

					  <!-- Modal -->
					  <div class="modal fade" id="bpedido" role="dialog">
						<div class="modal-dialog modal-lg">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title"><b>Confirmación de cancelación</b></h4>
							</div>
							<div class="modal-body">
							  <p>¿Estás seguro que quieres canecelar el pedido <?=$pedido->id?>?</p>
							</div>
							<div class="modal-footer">
							  <a class="btn btn-success" href="<?=site_url().'/Inicio/cancelarPedido/'.$pedido->id?>">&nbsp;&nbsp;Si&nbsp;&nbsp;</a>
							  <button type="button" class="btn btn-danger" data-dismiss="modal">&nbsp;&nbsp;No&nbsp;&nbsp;</button>
							</div>
						  </div>
						</div>
					  </div>
								        
				<?php else:?>
				Ya no puedes cancelar el pedido
				<?php endif?>
				
				</td>
				
				<td style="vertical-align: middle;" align="center"><a href="<?=site_url().'/Inicio/PDFPedido/'.$pedido->id?>"><span style="color:red;" class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;<b>Ver PDF</b></a></td>
				</tr>
				
				<?php endforeach; ?>
				
				</table>
				<br>
				<a class="btn btn btn-default" href="<?=site_url().'/Inicio/cargarVista/panel_usuario'?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Volver atrás</b></a></center><br><br>
			</div>
		</div>
</div>
