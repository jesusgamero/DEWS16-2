<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
	<h4>Información del pedido <?php echo $pedido_id; ?></h4><hr>
	<p>Nombre completo: <?php echo $datos_usuario->nombre . ' ' . $datos_usuario->apellidos; ?> </p>
	<p>Dirección: <?php echo $datos_usuario->direccion; ?></p>
	<p>Provincia: <?php echo $this->musuario->nombreProvincia($datos_usuario->provincia_id); ?></p>
	<p>Fecha: <?php echo date("Y-m-d H:i:s");?></p>
	<table>
		<tr class="header">
			<th class="text-md-center">Nombre</th>
			<th class="text-md-center">Precio</th>
			<th class="text-md-center">Cantidad</th>
			<th class="text-md-center">Total</th>
		</tr>
		<?php $final = 0; ?>
		<?php foreach ($articulos as $linea): ?>
			<?php $final += $linea['precio'] * $linea['cantidad']; ?>
			<tr>
				<td><?php echo $linea['nombre'] ?></td>
				<td><?php echo $linea['precio'] ?></td>
				<td><?php echo $linea['cantidad'] ?></td>
				<td><?php echo ($linea['precio'] * $linea['cantidad']); ?></td>
			</tr>
		<?php endforeach ?>
		<tr class="footer">
			<th colspan="4">TOTAL: <?php echo $final; ?>€</th>
		</tr>
	</table>
</body>
</html>