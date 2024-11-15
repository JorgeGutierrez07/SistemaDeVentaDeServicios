<?php
/*Incluye los archivos de configuracion y el autoload para incluir las clases creadas en php */
require_once "./config/app.php";
require_once "./autoload.php";

/*---------- Iniciando sesion ----------*/
require_once "./app/views/inc/session_start.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["inicio"];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "./app/views/inc/head.php"; ?>
</head>

<body>
    <?php

    use app\controllers\viewsController;
    use app\controllers\loginController;

    $insLogin = new loginController();

    $viewsController = new viewsController();
    $vista = $viewsController->obtenerVistasControlador($url[0]);

    if ($vista == "inicio" || $vista == "404" || $vista == "registroCliente" || $vista == "registroProveedor" || $vista == "login" || $vista == "recuperarContraseña") {
        require_once "./app/views/content/" . $vista . "-view.php";
    } else {
        if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
            $insLogin->cerrarSesionControlador();
            exit();
        }
        require_once $vista;
    }

    require_once "./app/views/inc/script.php";
    ?>
</body>

</html>