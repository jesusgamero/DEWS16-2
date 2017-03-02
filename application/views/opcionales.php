<div class="container">	
        <div class="panel panel-default">
			<div class="panel-body">
					<div class="col-md-4">
					<br>
						<center><br><br><br><br><br><br>
						<img id="imagen" height="130px" width="130px" src="<?=base_url().'asset/'?>img/conf.png" />
						<h3>Opciones avanzadas</h3>
						</center><br><br>
					
					</div>
					<div class="col-md-5">			
				<h3><b>Importar de Excel</b></h3><hr>
					<form method="post" action="<?=site_url().'/Inicio/importarExcel'?>" enctype="multipart/form-data">
					<input type="file" name="archivo"/><br>
					<input type="submit" value="Enviar"/>
					</form><BR>
					
				<h3><b>Importar XML</b></h3><hr>	
				<form method="post" action="<?=  site_url().'/Inicio/procesaXML'?>" enctype="multipart/form-data">
                <input type="file" name="archivo"/><br>
                <input type="submit" value="Enviar"/>
				</form><BR>
				
				<h3><b>Exportar XML</b></h3></center>
				<a href="<?=site_url().'/Inicio/exportarXML/'?>"><b>Exportar artículos y categorías a XML</b></a><BR><BR>
			</div>			
			</div>
        </div>
		</div>
</div>