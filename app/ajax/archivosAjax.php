<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\registrosController;

if(isset($_GET['tipo']) && isset($_GET['id'] )){
	$isnArchivos = new registrosController();
	echo $isnArchivos->verPdf();
}