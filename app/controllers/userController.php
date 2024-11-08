<?php

namespace app\controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use app\models\mainModel;

	class userController extends mainModel{ 

		#Controlador para registrar proveedor
		public function registrarProveedorControlador(){

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
			if($nombre == "" || $apellidos == "" || $email == "" ||
			 $nEmpresa == "" || $nUsuario == "" || $password == "" ||
			 $curp == "" || $rfc == "" || $acta == "") {
				$alerta = [
					"tipo"=>"simple",
					"titulo"=>"Ocurrio un error inesperado",
					"texto"=>"No has llenado todos los campos solicitados",
					"icono"=>"error"
				];
				return json_encode($alerta);
			 }

			 //Comprobacion del peso de archivos
			 $limite_tamano = 2 * 1024 * 1024;
			 if($_FILES['curp']['size'] > $limite_tamano || $_FILES['rfc']['size'] > $limite_tamano || $_FILES['acta']['size'] > $limite_tamano) {
				$alerta = [
					"tipo"=>"simple",
					"titulo"=>"Ocurrio un error inesperado",
					"texto"=>"Los archivos no deben pesar mas de 2 Mb",
					"icono"=>"error"
				];
				return json_encode($alerta);
			 }

			 $contenidoCURP = file_get_contents($curp);
			 $contenidoRFC = file_get_contents($rfc);
			 $contenidoACTA = file_get_contents($acta);

			if ($this->verificarDatos("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}$/", $apellidos)){
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Error",
					"texto" => "El apellido no tiene formato valido",
					"icono" => "error"
				];
				return json_encode($alerta);

			}
			if ($this->verificarDatos("/^[a-zA-Z0-9.]{3,40}$/", $nUsuario)){
    			$alerta = [
        		"tipo" => "simple",
        		"titulo" => "Error",
        		"texto" => "El usuario no tiene formato valido",
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
							"texto" => "El correo ya existe en el sistema",
							"icono" => "error"
						];
						return json_encode($alerta);
	
					}
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Error",
						"texto" => "El correo no tiene formato valido",
						"icono" => "error"
					];
					return json_encode($alerta);
				}
			}

			 if($password != ''){
				$clave=password_hash($password, PASSWORD_BCRYPT, ["cost"=>10]);
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
				[
					"campo_nombre" => "CURP",
					"campo_marcador" => ":curp",
					"campo_valor" => $contenidoCURP
				],
				[
					"campo_nombre" => "RFC",
					"campo_marcador" => ":rfc",
					"campo_valor" => $contenidoRFC
				],
				[
					"campo_nombre" => "Acta_Constitutiva",
					"campo_marcador" => ":acta",
					"campo_valor" => $contenidoACTA
				]
			 ];

			 if(($registrar_usuario !== false) ){
				$registrar_proveedor = $this->guardarDatosProveedor("proveedores", $proveedor_datos);
				$registrar_solicitud = $this->guardarDatosProveedor("estado_solicitud", $solicitud_datos);
				if($registrar_proveedor !==false && $registrar_solicitud !==false){
					$alerta = [
						"tipo"=>"success",
						"titulo"=>"Registro exitoso",
						"texto"=>"Tu solicitud se envio correctamente",
						"icono"=>"success",
						"url"=>"/SistemaDeVentaDeServicios/inicio"
					];
					return json_encode($alerta);
				} else {
					$alerta = [
						"tipo"=>"fail",
						"titulo"=>"Ocurrio un error inesperado",
						"texto"=>"La solicitud no se envio, intentelo de nuevo",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}
			 } else {
				$alerta = [
					"tipo"=>"fail",
					"titulo"=>"Ocurrio un error inesperado",
					"texto"=>"La solicitud no se envio, intentelo de nuevo",
					"icono"=>"error"
				];
				return json_encode($alerta);
			 }
		}
        
    }