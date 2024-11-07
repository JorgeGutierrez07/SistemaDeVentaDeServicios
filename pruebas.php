<?php

use app\models\mainModel;

require "./app/models/mainModel.php";

$model = new mainModel();

$response = $model->enviarCorreo("michel0810.ma@gmail.com",'Este es el <b>mensaje del correo</b>.');
echo $response;
