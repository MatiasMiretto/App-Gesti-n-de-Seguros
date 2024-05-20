<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\insuredController;

	if(isset($_POST['modulo_asegurado'])){

		$insAsegurado = new insuredController();

		if($_POST['modulo_asegurado']=="registrar"){
			echo $insAsegurado->registrarAseguradoControlador();
		}
		
		if($_POST['modulo_asegurado']=="eliminar"){
			echo $insAsegurado->eliminarAseguradoControlador();
		}

		if($_POST['modulo_asegurado']=="actualizar"){
			echo $insAsegurado->actualizarAseguradoControlador();
		}
		
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}