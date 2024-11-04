<?php

	namespace app\controllers;
	use app\models\mainModel;

	class userController extends mainModel{ 
		# Controlador para registrar el cliente
        public function registrarClienteControlador(){
			$nombre = $this->limpiarCadena($_POST['nombre']);
			$apellido = $this->limpiarCadena($_POST['apellido']);
			$email = $this->limpiarCadena($_POST['email']);
			$usuario = $this->limpiarCadena($_POST['usuario']);
			$contraseña = $this->limpiarCadena($_POST['clave']);

			# Verificar campos obligatorios
			if ($nombre == "" || $apellido == "" || $email == "" || $usuario == "" || $contraseña == "") {
				header('Content-Type: application/json');
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos obligatorios",
					"icono" => "error"
				];
				
				echo json_encode($alerta);
				exit();
			} else {
				header('Content-Type: application/json');
				// Respuesta en caso de éxito
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Registro exitoso",
					"texto" => "El cliente ha sido registrado correctamente",
					"icono" => "success"
				];
				
				echo json_encode($alerta);
				exit();
			}
			
			// Enviar la respuesta JSON
			
		}
    }