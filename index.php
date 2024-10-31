<?php
/*Incluye los archivos de configuracion y el autoload para incluir las clases creadas en php */
require_once "./config/app.php";
require_once "./autoload.php";

/*---------- Iniciando sesion ----------*/
require_once "./app/views/inc/session_start.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
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

    $viewsController = new viewsController();
    $vista = $viewsController->obtenerVistasControlador($url[0]);

    if ($vista == "login" || $vista == "404") {
        require_once "./app/views/content/" . $vista . "-view.php";
    } else {

        require_once "./app/views/inc/navbar.php";

        require_once $vista;
    }

    require_once "./app/views/inc/script.php";
    ?>
</body>

</html>