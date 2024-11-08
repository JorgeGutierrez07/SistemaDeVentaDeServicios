<?php

namespace app\models;

class viewsModel
{
    protected function obtenerVistasModelo($vista)
    {
        // Lista blanca de vistas permitidas
        $listaBlanca = ["cargarFactura", "inicioCliente", "inicioAdmin", "logOut", "validacionRegistros"];
        // Comprobación si la vista está en la lista blanca
        if (in_array($vista, $listaBlanca)) {
            // Verificar si el archivo de vista existe
            if (is_file("./app/views/content/" . $vista . "-view.php")) {
                // Si existe, asignar la ruta del archivo a $contenido
                $contenido = "./app/views/content/" . $vista . "-view.php";
            } else {
                // Si no existe, mostrar la página de error 404
                $contenido = "404";
            }
        } elseif ($vista == "inicio" || $vista == "index") {
            // Si la vista es 'login', asignar 'login' a $contenido
            $contenido = "inicio";
        } elseif ($vista == "registroCliente") {
            $contenido = "registroCliente";
        } elseif ($vista == "registroProveedor") {
            $contenido = "registroProveedor";
        } elseif ($vista == "login") {
            $contenido = "login";
        } elseif ($vista == "recuperarContraseña") {
            $contenido = "recuperarContraseña";
        } 
        else {
            // Si la vista no está en la lista blanca ni es 'login', mostrar la página de error 404
            $contenido = "404";
        }
        // Devolver el contenido de la vista
        return $contenido;
    }
}
