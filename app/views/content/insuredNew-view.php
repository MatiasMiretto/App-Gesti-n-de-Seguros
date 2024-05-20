<div class="container is-fluid mb-6">
	<h1 class="title">Asegurados</h1>
	<h2 class="subtitle">Nuevo asegurado</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/insuredAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="modulo_asegurado" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="asegurado_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos</label>
				  	<input class="input" type="text" name="asegurado_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Dni</label>
				  	<input class="input" type="text" name="asegurado_dni" maxlength="9" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
                    <label>Direccion</label>
				  	<input class="input" type="text" name="asegurado_direccion" maxlength="50" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
                    <label>Email</label>
				  	<input class="input" type="email" name="asegurado_email" maxlength="70" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
                    <label>Telefono</label>
				  	<input class="input" type="tel" name="asegurado_telefono" pattern="[0-9]{7,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>
        <div class="columns">
            <div class="column">
		    	<div class="control">
					<label>Domicilio de reparacion</label>
				  	<input class="input" type="text" name="asegurado_dom_reparacion" maxlength="50" required >
				</div>
		  	</div>
			  <div class="column">
		    	<div class="control">
				<label>Cliente</label>
				<select class="input" name="asegurado_cliente" id="cliente">
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
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>