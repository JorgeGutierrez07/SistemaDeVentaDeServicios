<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\userController;

if (isset($_POST['modulo_usuario'])) {

	$insUsuario = new userController();
	if ($_POST['modulo_usuario'] == "registrarCliente") {
		echo $insUsuario->registrarClienteControlador();
	}elseif ($_POST['modulo_usuario'] == "recuperarContraseña") {
		echo $insUsuario->recuperarContraseñaControlador();
	} elseif($_POST['modulo_usuario']=="aceptar" || $_POST['modulo_usuario']=="rechazar"){
        echo $insUsuario->actualizarUsuarioControlador();
    }
} else {
	session_destroy();
	header("Location: " . APP_URL . "inicio/");
}