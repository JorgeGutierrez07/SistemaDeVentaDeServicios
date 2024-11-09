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
						$envio_email = $this->enviarCorreo($correo, "Tu nueva contraseña es <b>$nuevaContraseña</b>", "Recuperacion de Contraseña");
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

	public function registrarProveedorControlador()
	{

		$nombre = $this->limpiarCadena($_POST['nombre']);
		$apellidos = $this->limpiarCadena($_POST['apellidos']);
		$email = $this->limpiarCadena($_POST['email']);
		$nEmpresa = $this->limpiarCadena($_POST['nombre_empresa']);
		$nUsuario = $this->limpiarCadena($_POST['nombre_usuario']);
		$password = $this->limpiarCadena($_POST['clave']);
		#La operacion limpiar afecta la ruta
		$curp = $_FILES['curp']['tmp_name'];
		$rfc = $_FILES['rfc']['tmp_name'];
		$acta = $_FILES['acta']['tmp_name'];

		//Comprobacion que no esten vacios
		if (
			$nombre == "" || $apellidos == "" || $email == "" ||
			$nEmpresa == "" || $nUsuario == "" || $password == "" ||
			$curp == "" || $rfc == "" || $acta == ""
		) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "No has llenado todos los campos solicitados",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		//Comprobacion del peso de archivos
		$limite_tamano = 2 * 1024 * 1024;
		if ($_FILES['curp']['size'] > $limite_tamano || $_FILES['rfc']['size'] > $limite_tamano || $_FILES['acta']['size'] > $limite_tamano) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "Los archivos no deben pesar mas de 2 Mb",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		$contenidoCURP = file_get_contents($curp);
		$contenidoRFC = file_get_contents($rfc);
		$contenidoACTA = file_get_contents($acta);

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
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidos)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Error",
				"text" => "El apellido no tiene formato valido",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nUsuario)) {
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

		//Se cambio la linea (max_allowed_packet=16M) en my.ini de xampp para que acepte todos los archivos

		//Arreglo para insertar en usuario
		$usuario_datos = [
			[
				"campo_nombre" => "Usuario ",
				"campo_marcador" => ":usuario", #Cambiar por el id recuperado de la nueva insercion 
				"campo_valor" => $nUsuario
			],
			[
				"campo_nombre" => "Nombre",
				"campo_marcador" => ":nombre",
				"campo_valor" => $nombre
			],
			[
				"campo_nombre" => "Apellidos",
				"campo_marcador" => ":apellidos",
				"campo_valor" => $apellidos
			],
			[
				"campo_nombre" => "Correo",
				"campo_marcador" => ":correo",
				"campo_valor" => $email
			],
			[
				"campo_nombre" => "Contraseña",
				"campo_marcador" => ":pass",
				"campo_valor" => $clave
			],
			[
				"campo_nombre" => "Tipo_Usuario",
				"campo_marcador" => ":tusuario",
				"campo_valor" => "proveedor"
			]
		];
		$registrar_usuario = $this->guardarDatosProveedor("usuarios", $usuario_datos);
		//Arreglo para insertar en solicitud
		$solicitud_datos = [
			[
				"campo_nombre" => "ID_Usuario",
				"campo_marcador" => ":idUsuario",
				"campo_valor" => $registrar_usuario
			],
			[
				"campo_nombre" => "Estado",
				"campo_marcador" => ":estado",
				"campo_valor" => "pendiente"
			]
		];
		//Arreglo para insertar en proveedor
		$proveedor_datos = [
			[
				"campo_nombre" => "ID_Usuario ",
				"campo_marcador" => ":id",
				"campo_valor" => $registrar_usuario
			],
			[
				"campo_nombre" => "Nombre_de_Empresa",
				"campo_marcador" => ":nEmpresa",
				"campo_valor" => $nEmpresa
			],
		];

		if (($registrar_usuario !== false)) {
			$registrar_proveedor = $this->guardarDatosProveedor("proveedores", $proveedor_datos);
			$registrar_pdf = $this->guardarArchivosProveedor($contenidoACTA, $contenidoCURP, $contenidoRFC, $registrar_usuario);
			$registrar_solicitud = $this->guardarDatosProveedor("estado_solicitud", $solicitud_datos);
			if ($registrar_proveedor !== false && $registrar_solicitud !== false) {
				$alerta = [
					"tipo" => "redireccionar",
					"titulo" => "Registro exitoso",
					"text" => "Tu solicitud se envio correctamente",
					"icono" => "success",
					"url" => "/SistemaDeVentaDeServicios/inicio"
				];
				return json_encode($alerta);
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrio un error inesperado",
					"text" => "La solicitud no se envio, intentelo de nuevo",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "La solicitud no se envio, intentelo de nuevo",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
	}
	public function registrarFacturaControlador()
	{
		$razon = $this->limpiarCadena($_POST['razon_factura']);
		$fecha = $this->limpiarCadena($_POST['fecha_limite_factura']);
		#La operacion limpiar afecta la ruta
		$archivo = $_FILES['archivo_factura']['tmp_name'];

		//Comprobacion que no esten vacios
		if ($razon == "" || $fecha == "" || $archivo == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "No has llenado todos los campos solicitados",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		//Comprobacion del peso de archivos
		$limite_tamano = 2 * 1024 * 1024;
		if ($_FILES['archivo_factura']['size'] > $limite_tamano) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "Los archivos no deben pesar mas de 2 Mb",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		$contenidoArchivo = file_get_contents($archivo);

		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $razon)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Error",
				"text" => "La razon no tiene formato valido",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
		$factura_datos = [
			[
				"campo_nombre" => "ID_Usuario",
				"campo_marcador" => ":idUsuario",
				"campo_valor" => $_SESSION['id']
			],
			[
				"campo_nombre" => "Razon_de_Factura",
				"campo_marcador" => ":razon",
				"campo_valor" => $razon
			],
			[
				"campo_nombre" => "Fecha_limite_de_pago",
				"campo_marcador" => ":fecha",
				"campo_valor" => $fecha
			],
			[
				"campo_nombre" => "Estado",
				"campo_marcador" => ":estado",
				"campo_valor" => "pendiente"
			]
		];

		$registrar_factura = $this->guardarDatosProveedor("facturas", $factura_datos);
		$registrar_archivo = $this->guardarFactura($contenidoArchivo, $registrar_factura);

		if ($registrar_factura !== false) {
			$alerta = [
				"tipo" => "recargar",
				"titulo" => "Registro exitoso",
				"text" => "Tu factura se envio correctamente",
				"icono" => "success",
			];
			return json_encode($alerta);
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "La solicitud no se envio, intentelo de nuevo",
				"icono" => "error"
			];
			return json_encode($alerta);
		}
	}
	public function actualizarUsuarioControlador()
	{
		$id_usuario = $this->limpiarCadena($_POST['usuario_id']);
		$nombre = $this->limpiarCadena($_POST['nombre_usuario']);
		$correo = $this->limpiarCadena($_POST['correo_usuario']);

		//Comprobacion que no esten vacios
		if ($nombre == "" || $correo == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrio un error inesperado",
				"text" => "No has llenado todos los campos solicitados",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		if ($correo != '') {
			if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
				$check_email = $this->ejecutarConsulta("SELECT COUNT(*) AS total FROM usuarios WHERE Correo = '$correo' AND ID_Usuario != $id_usuario");
				$resultado = $check_email->fetch();
				if ($resultado['total'] > 0) {
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
			"condicion_valor" => $id_usuario
		];

		// Ejecutar la actualización
		$resultado = $this->actualizarDatos("usuarios", $datos_actualizar, $condicion);
		if ($resultado) {
			$alerta = [
				"tipo" => "recargar",
				"titulo" => "Datos de usuario actualizados",
				"text" => "Cambios aceptados",
				"icono" => "success"
			];
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"text" => "No se pudieron realizar los cambios",
				"icono" => "error"
			];
		}
		return json_encode($alerta);
	}
}
