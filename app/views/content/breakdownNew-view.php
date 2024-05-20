<div class="container is-fluid mb-6">
	<h1 class="title">Averias</h1>
	<h2 class="subtitle">Nueva averia</h2>
</div>

<div class="container pb-6 pt-6">

<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/breakdownAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

	<input type="hidden" name="modulo_averia" value="registrar">

<div class="columns">
	<div class="column">
		<div class="control">
    	<label>Cliente:</label>
    	<select class="input" name="averia_cliente" id="cliente">
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
                echo "<option value='" . $row['Nombre'] . "'>" . $row['Nombre'] . "</option>";
            }
        }
        $conexion->close();
        ?>
    	</select>
		</div>
	</div>

    
    <div class="column">
		<div class="control">
    
    	<label>Asegurado:</label>
    	<select class="input" name="averia_asegurado" id="asegurado">
			<option selected disabled>Seleccione un asegurado</option>
        <?php
        
        $conexion = new mysqli("localhost", "root", "", "solucionesIntegrales");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        $query_asegurado = "SELECT ID_Asegurado, Nombre, Apellidos FROM asegurados";
        $result_asegurado = $conexion->query($query_asegurado);
        if ($result_asegurado->num_rows > 0) {
            while($row = $result_asegurado->fetch_assoc()) {
                echo "<option value='" . $row['Nombre'] ." ". $row['Apellidos'] . "'>" . $row['Nombre'] ." ". $row['Apellidos'] ."</option>";
            }
        }
        $conexion->close();
        ?>
    	</select>
    
    	</div>
	</div>
</div>
<div class="columns">
	<div class="column">
		<div class="control">   
			<label>Fecha:</label>
			<input class="input" type="date" id="fecha" name="averia_fecha">
		</div>
	</div>

	<div class="column">
		<div class="control">	
    		<label>Descripción:</label><br>
    		<textarea class="input" id="descripcion" name="averia_descripcion" rows="10" cols="50" required></textarea>
    
		</div>
	</div>
</div>
	<p class="has-text-centered">
		<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
		<button type="submit" class="button is-info is-rounded">Guardar</button>
	</p>
	</form>
</div>