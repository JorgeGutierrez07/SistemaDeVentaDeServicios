<?php

use app\models\mainModel;

require "./app/models/mainModel.php";

$model = new mainModel();
$correo = 'geo.hdez.and@gmail.com';
$id=2;

$response = $model->ejecutarConsulta("SELECT COUNT(*) AS total FROM usuarios WHERE Correo = '$correo' AND ID_Usuario != $id");
$resultado= $response->fetch();
echo $resultado['total'];
if ($resultado['total'] < 0) {
    echo 'es cero';
}else {
    echo 'puto';
}
