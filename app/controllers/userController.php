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
			$password = $this->limpiarCadena($_POST['clave']);
			if ($nombre == "" || $apellido == "" || $email == "" || $usuario == "" || $password == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"text" => "No has llenado todos los campos obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
				
			}
			if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
				// Respuesta en caso de éxito
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Error",
					"text" => "El nombre no tiene formato valido",
					"icono" => "error"
				];
				return json_encode($alerta);
		
			}
			if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
				// Respuesta en caso de éxito
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Error",
					"text" => "El apellido no tiene formato valido",
					"icono" => "error"
				];
				return json_encode($alerta);

			}
			if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $usuario)){
				// Respuesta en caso de éxito
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Error",
					"text" => "El usuario no tiene formato valido",
					"icono" => "error"
				];
				return json_encode($alerta);

			}
			if ($email!=''){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email = $this->ejecutarConsulta("SELECT Correo FROM usuarios WHERE Correo='$email'");
					if($check_email->rowCount() > 0){
						$alerta = [
							"tipo" => "simple",
							"titulo" => "Error",
							"text" => "El correo ya existe en el sistema",
							"icono" => "error"
						];
						return json_encode($alerta);
	
					} 
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Error",
						"text" => "El correo no tiene formato valido",
						"icono" => "error"
					];
					return json_encode($alerta);
				}
			}
			if($password != ''){
				$clave=password_hash($password, PASSWORD_BCRYPT, ["cost"=>10]);
			}

			$check_usuario = $this->ejecutarConsulta("SELECT Usuario FROM usuarios WHERE Usuario='$usuario'");
			if($check_usuario->rowCount() > 0){
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Error",
					"text" => "El usuario ya existe en el sistema",
					"icono" => "error"
				];
				return json_encode($alerta);
			} 
		}
	}