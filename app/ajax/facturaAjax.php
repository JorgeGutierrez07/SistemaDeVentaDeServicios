<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\facturasController;

if(isset($_GET['id'] )){
	$isnFactura = new facturasController();
	echo $isnFactura->verPdf();
}