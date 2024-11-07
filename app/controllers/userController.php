<?php

namespace app\controllers;

use app\models\mainModel;

class userController extends mainModel
{
	public function registrarClienteControlador()
	{
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
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
			// Respuesta en caso de éxito
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Error",
				"text" => "El nombre no tiene formato valido",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
			// Respuesta en caso de éxito
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Error",
				"text" => "El apellido no tiene formato valido",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
		if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,40}", $usuario)) {
			// Respuesta en caso de éxito
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Error",
				"text" => "El usuario no tiene formato valido",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
		if ($email != '') {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$check_email = $this->ejecutarConsulta("SELECT Correo FROM usuarios WHERE Correo='$email'");
				if ($check_email->rowCount() > 0) {
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
		if ($password != '') {
			$clave = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
		}

		$check_usuario = $this->ejecutarConsulta("SELECT Usuario FROM usuarios WHERE Usuario='$usuario'");
		if ($check_usuario->rowCount() > 0) {
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
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No se pudieron insertar los datos",
				"icono" => "error"
			];
		}
		return json_encode($alerta);
	}

	public function recuperarContraseñaControlador()
	{
		$email = $this->limpiarCadena($_POST['email']);

		if ($email == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"text" => "No has llenado todos los campos obligatorios",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		if ($email != '') {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$check_email = $this->ejecutarConsulta("SELECT Correo FROM usuarios WHERE Correo='$email'");
				if ($check_email->rowCount() == 1) {
					$check_email = $check_email->fetch();
					$correo = $check_email['Correo'];
					//Se Genera la nueva contraseña
					// Define el conjunto de caracteres que se usarán para la contraseña sencilla
					$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					// Baraja los caracteres de manera aleatoria y toma un subconjunto de la longitud deseada
					$nuevaContraseña = substr(str_shuffle(str_repeat($caracteres, ceil(8 / strlen($caracteres)))), 0, 8);
					//Se Hashea la Nueva Contraseña 
					$nuevaClave = password_hash($nuevaContraseña, PASSWORD_BCRYPT, ["cost" => 10]);
					//Se inserta en la Base de datos
					$check_contraseña = $this->ejecutarConsulta("UPDATE usuarios SET Contraseña = '$nuevaClave' WHERE Correo = '$correo'");
					if ($check_contraseña->rowCount() == 1) {
						$envio_email = $this->enviarCorreo($correo, "Tu nueva contraseña es <b>$nuevaContraseña</b>");
						if ($envio_email) {
							$alerta = [
								"tipo" => "simple",
								"titulo" => "Correo Enviado",
								"text" => "La recuperacion de contraseña se ha enviado a " . $correo,
								"icono" => "success"
							];
							return json_encode($alerta);
						} else {
							$alerta = [
								"tipo" => "simple",
								"titulo" => "Algo Salio mal",
								"text" => "No se pudo enviar la nueva contraseña al correo",
								"icono" => "error"
							];
							return json_encode($alerta);
						}
					} else {
						$alerta = [
							"tipo" => "simple",
							"titulo" => "Algo Salio mal",
							"text" => "No se pudo enviar la nueva contraseña",
							"icono" => "error"
						];
						return json_encode($alerta);
					}
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Error",
						"text" => "El correo no se encuentra en la base de datos",
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
	}
	

}
