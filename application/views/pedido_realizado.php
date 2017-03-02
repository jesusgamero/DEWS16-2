<div class="container">
        <div class="panel panel-default">
			<div class="panel-body">
				<br>
				<center><img src="<?=base_url().'asset/'?>img/exito.png" height="130px" width="130px" />
				<h3>Pedido Nº <a href="<?=site_url().'/Inicio/detallePedido/'.$pedido_id?>"> <?php echo ($pedido_id); ?></a> realizado correctamente</h3>
				<br>
				<a class="btn btn btn-default" href="<?=site_url().'/Inicio/verPedidos/'.$this->session->userdata('id')?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Ver mis pedidos</b></a></center><br><br>
			</div>
		</div>
</div>
