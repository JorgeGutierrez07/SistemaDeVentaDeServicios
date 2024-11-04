<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\userController;

	if(isset($_POST['modulo_cliente'])){

		$insUsuario = new userController();
		if($_POST['modulo_cliente'] == "registrarCliente"){
			echo $insUsuario->registrarClienteControlador();
		}  
	}

	else{
		session_destroy();
		header("Location: ".APP_URL."inicio/");
	}