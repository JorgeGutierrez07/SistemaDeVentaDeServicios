<?php
namespace app\controllers;

use app\models\mainModel;

try {
    // Cargar el modelo correctamente
    require_once __DIR__ . '/../models/mainModel.php';

    // Verificar que la clase existe
    if (!class_exists('app\models\mainModel')) {
        throw new Exception("Clase mainModel no encontrada");
    }

    // Crear una instancia del modelo
    $modelo = new mainModel();

    // Comprobar si es una solicitud POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido");
    }

    // Obtener los datos JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }

    // Verificar si se tienen todos los datos
    if (!isset($data['id'], $data['nombre'], $data['correo'])) {
        throw new Exception("Faltan datos requeridos");
    }

    // Limpiar los datos
    $id = $modelo->limpiarCadena($data['id']);
    $nombre = $modelo->limpiarCadena($data['nombre']);
    $correo = $modelo->limpiarCadena($data['correo']);

    // Preparar los datos para la actualización
    $datos_actualizar = [
        [
            "campo_nombre" => "Nombre",
            "campo_marcador" => ":Nombre",
            "campo_valor" => $nombre
        ],
        [
            "campo_nombre" => "Correo",
            "campo_marcador" => ":Correo",
            "campo_valor" => $correo
        ]
    ];

    $condicion = [
        "condicion_campo" => "ID_Usuario",
        "condicion_marcador" => ":ID_Usuario",
        "condicion_valor" => $id
    ];

    // Ejecutar la actualización
    $resultado = $modelo->actualizarDatos("usuarios", $datos_actualizar, $condicion);

    if (!$resultado) {
        throw new Exception("Error al actualizar el usuario");
    }

    // Devolver respuesta exitosa
    echo json_encode([
        "success" => true,
        "message" => "Usuario actualizado correctamente"
    ]);

} catch (Exception $e) {
    // Log del error para debugging
    error_log("Error en actualizarUsuariosController: " . $e->getMessage(), 3, __DIR__ . "/../logs/error.log");

    // Devolver respuesta de error
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}

