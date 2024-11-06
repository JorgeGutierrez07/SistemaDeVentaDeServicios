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
			if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}
", $usuario)){
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

			$cliente_datos_reg = [
				[
					"campo_nombre" => "Nombre",
					"campo_marcador" => ":Nombre",
					"campo_valor" => $nombre
				],
				[
					"campo_nombre" => "Apellidos",
					"campo_marcador" => ":Apellidos",
					"campo_valor" => $apellido
				],
				[
					"campo_nombre" => "Usuario",
					"campo_marcador" => ":Usuario",
					"campo_valor" => $usuario
				],
				[
					"campo_nombre" => "Correo",
					"campo_marcador" => ":Email",
					"campo_valor" => $email
				],
				[
					"campo_nombre" => "Contraseña",
					"campo_marcador" => ":Clave",
					"campo_valor" => $clave
				],
				[
					"campo_nombre" => "Tipo_Usuario",
					"campo_marcador" => ":Cliente",
					"campo_valor" => "cliente"
				]
			];
			
			// Aquí va tu lógica de inserción a la base de datos
			$registrar_usuario = $this->guardarDatos("usuarios", $cliente_datos_reg);

		
			if ($registrar_usuario->rowCount() == 1) {
				// Obtiene el ID del usuario recién insertado
				$usuario_id = $this->getLastInsertId();

				// Prepara los datos para la inserción en estado_solicitud
				$estado_datos = [
					[
						"campo_nombre" => "ID_Usuario",
						"campo_marcador" => ":Usuario_id",
						"campo_valor" => $usuario_id // El ID del usuario recién registrado
					],
					[
						"campo_nombre" => "Estado",
						"campo_marcador" => ":Pendiente",
						"campo_valor" => 'pendiente'
					]
				];
				
				// Inserción del estado de solicitud
				$registrar_estado = $this->guardarDatos("estado_solicitud", $estado_datos);

				// Verifica si la solicitud se insertó correctamente
                if ($registrar_estado->rowCount() == 1) {
                    $alerta = [
                        "tipo" => "limpiar",
                        "titulo" => "Usuario registrado",
                        "texto" => "Usuario " . $nombre . " " . $apellido . " registrado correctamente",
                        "icono" => "success"
                    ];
                } else {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error al registrar el estado",
                        "texto" => "No se pudo registrar el estado de solicitud",
                        "icono" => "error"
                    ];
                }
				return json_encode($alerta);
	
			}  else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No se pudieron insertar los datos",
					"icono" => "error"
				];
			}
			return json_encode($alerta);
		} 
	}
	