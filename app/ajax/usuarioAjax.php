<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\userController;
use app\controllers\registrosController;
use app\controllers\facturasController;

if (isset($_POST['modulo_usuario'])) {

	$insUsuario = new userController();
	if ($_POST['modulo_usuario'] == "registrarCliente") {
		echo $insUsuario->registrarClienteControlador();
	}elseif ($_POST['modulo_usuario'] == "recuperarContraseña") {
		echo $insUsuario->recuperarContraseñaControlador();
	}elseif ($_POST['modulo_usuario'] == "registrarProveedor") {
		echo $insUsuario->registrarProveedorControlador();
	}elseif ($_POST['modulo_usuario'] == "registrarFactura") {
		echo $insUsuario->registrarFacturaControlador();
	}elseif ($_POST['modulo_usuario'] == "actualizarUsuario") {
		echo $insUsuario->actualizarUsuarioControlador();
	}
} else if (isset($_POST['modulo_registros'])){
	$insRegistros = new registrosController();
	echo $insRegistros->estadoSolicitudControlador($_POST['modulo_registros']);
}  else if (isset($_POST['modulo_facturas'])){
	$insFactura = new facturasController();
	echo $insFactura->actualizarFacturaControlador();
}
else {
	session_destroy();
	header("Location: " . APP_URL . "inicio/");
}