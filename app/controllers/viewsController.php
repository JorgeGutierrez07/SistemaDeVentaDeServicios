<?php
namespace app\controllers;
use app\models\viewsModel;

class viewsController extends viewsModel
{
    public function obtenerVistasControlador($vista)
    {
        // Verificar si la vista no está vacía
        if ($vista != "") {
            // Llamar al método para obtener la vista correspondiente del modelo
            $respuesta = $this->obtenerVistasModelo($vista);
        } else {
            // Si la vista está vacía, establecer la vista predeterminada como 'login'
            $respuesta = "login";
        }
        // Devolver la vista obtenida
        return $respuesta;
    }
}
