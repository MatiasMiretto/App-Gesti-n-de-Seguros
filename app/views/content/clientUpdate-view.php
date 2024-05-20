<div class="container is-fluid mb-6">
<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		
	?>
	
	<h1 class="title">Clientes</h1>
	<h2 class="subtitle">Actualizar cliente</h2>
	
</div>
<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","cliente","ID_Cliente",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['Nombre']; ?></h2>

	<p class="has-text-centered pb-6"><?php echo "<strong>Cliente creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['Creado']))." &nbsp; <strong>Cliente actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['Actualizado'])); ?></p>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_cliente" value="actualizar">
		<input type="hidden" name="cliente_id" value="<?php echo $datos['ID_Cliente']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="cliente_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" value="<?php echo $datos['Nombre']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Direccion</label>
				  	<input class="input" type="text" name="cliente_direccion" maxlength="40" value="<?php echo $datos['Direccion']; ?>" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>CIF</label>
				  	<input class="input" type="text" name="cliente_cif" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" value="<?php echo $datos['Cif']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="cliente_email" maxlength="70" value="<?php echo $datos['Email']; ?>" >
				</div>
		  	</div>
		</div>
        <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Telefono</label>
				  	<input class="input" type="tel" name="cliente_telefono" pattern="[0-9]{9,100}" maxlength="100" value="<?php echo $datos['Telefono']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Persona de contacto</label>
				  	<input class="input" type="text" name="cliente_contacto" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" value="<?php echo $datos['Persona_Contacto']; ?>" >
				</div>
		  	</div>
		</div>
		
		
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>
