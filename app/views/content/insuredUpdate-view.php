<div class="container is-fluid mb-6">
<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		
	?>
	
	<h1 class="title">Asegurados</h1>
	<h2 class="subtitle">Actualizar asegurado</h2>
	
</div>
<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","asegurados","ID_Asegurado",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['Nombre']." ".$datos['Apellidos']; ?></h2>

	<p class="has-text-centered pb-6"><?php echo "<strong>Asegurado creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['Creado']))." &nbsp; <strong>Asegurado actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['Actualizado'])); ?></p>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/insuredAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_asegurado" value="actualizar">
		<input type="hidden" name="asegurado_id" value="<?php echo $datos['ID_Asegurado']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="asegurado_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" value="<?php echo $datos['Nombre']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos</label>
				  	<input class="input" type="text" name="asegurado_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" value="<?php echo $datos['Apellidos']; ?>" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
			<div class="column">
		    	<div class="control">
					<label>Dni</label>
				  	<input class="input" type="text" name="asegurado_dni" maxlength="9" value="<?php echo $datos['Dni']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Direccion</label>
				  	<input class="input" type="text" name="asegurado_direccion" maxlength="40" value="<?php echo $datos['Direccion']; ?>" required >
				</div>
		  	</div>
		</div>
        <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Telefono</label>
				  	<input class="input" type="tel" name="asegurado_telefono" pattern="[0-9]{9,100}" maxlength="100" value="<?php echo $datos['Telefono']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="asegurado_email" maxlength="70" value="<?php echo $datos['Email']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Domicilio de reparacion</label>
				  	<input class="input" type="text" name="asegurado_dom_reparacion" maxlength="100" value="<?php echo $datos['Dom_Reparacion']; ?>" required >
				</div>
		  	</div>
			  <div class="column">
		    	<div class="control">
				<label>Cliente</label>
				<select class="input" name="asegurado_cliente" id="cliente" value="<?php echo $datos['ID_Cliente']; ?>">
					<option selected disabled>Seleccione un cliente</option>
						<?php
						
						$conexion = new mysqli("localhost", "root", "", "solucionesIntegrales");
						if ($conexion->connect_error) {
							die("Error de conexión: " . $conexion->connect_error);
						}
						$query_cliente = "SELECT ID_Cliente, Nombre FROM cliente";
						$result_cliente = $conexion->query($query_cliente);
						if ($result_cliente->num_rows > 0) {
							while($row = $result_cliente->fetch_assoc()) {
								echo "<option value='" . $row['ID_Cliente'] . "'>" . $row['Nombre'] . "</option>";
							}
						}
						$conexion->close();
						?>
				</select>
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
