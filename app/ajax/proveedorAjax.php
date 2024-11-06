<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\userController;

	if(isset($_POST['modulo_proveedor'])){

		$insProveedor = new userController();

		//Seleccion del controlador a utilizar
        if($_POST['modulo_proveedor'] == "registrar") {
            echo $insProveedor->registrarProveedorControlador();
        }
        	
	}else{
		session_destroy();
		header("Location: ".APP_URL."inicio/");
	}

?>
