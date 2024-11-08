<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\userController;
use app\controllers\registrosController;
use app\controllers\listarUsuarioControlador;

if (isset($_POST['modulo_usuario'])) {

	$insUsuario = new userController();
	if ($_POST['modulo_usuario'] == "registrarCliente") {
		echo $insUsuario->registrarClienteControlador();
	}elseif ($_POST['modulo_usuario'] == "recuperarContraseña") {
		echo $insUsuario->recuperarContraseñaControlador();
	} 
} else if (isset($_POST['modulo_registros'])){
	$insRegistros = new registrosController();
	echo $insRegistros->estadoSolicitudControlador($_POST['modulo_registros']);
} else if (isset($_POST['modulo_listarUsuario'])){
	$insListar = new listarUsuarioControlador();
	echo $insListar->estadoSolicitudControlador($_POST['modulo_listarUsuario']);
}
else {
	session_destroy();
	header("Location: " . APP_URL . "inicio/");
}