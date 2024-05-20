<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\breakdownController;

	if(isset($_POST['modulo_averia'])){

		$insAveria = new breakdownController();

		if($_POST['modulo_averia']=="registrar"){
			echo $insAveria->registrarAveriaControlador();
		}
		
		if($_POST['modulo_averia']=="eliminar"){
			echo $insAveria->eliminarAveriaControlador();
		}
		
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}