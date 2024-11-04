<?php

	namespace app\controllers;
	use app\models\mainModel;

	class userController extends mainModel{ 

		#Controlador para registrar proveedor
		public function registrarProveedorControlador(){

			$nombre = $this->limpiarCadena($_POST['nombre']);
			$apellidos = $this->limpiarCadena($_POST['apellidos']);
			$email = $this->limpiarCadena($_POST['email']);
			$nEmpresa = $this->limpiarCadena($_POST['nombre_empresa']);
			$nUsuario = $this->limpiarCadena($_POST['nombre_usuario']);
			$clave = $this->limpiarCadena($_POST['clave']);
			#La operacion limpiar afecta la ruta
			$curp = $_FILES['curp']['tmp_name'];
			$rfc = $_FILES['rfc']['tmp_name'];
			$acta = $_FILES['acta']['tmp_name'];

			if($nombre == "" || $apellidos == "" || $email == "" ||
			 $nEmpresa == "" || $nUsuario == "" || $clave == "" ||
			 $curp == "" || $rfc == "" || $acta == "") {
				$alerta = [
					"tipo"=>"simple",
					"titulo"=>"Ocurrio un error inesperado",
					"texto"=>"No has llenado todos los campos solicitados",
					"icono"=>"error"
				];
				return json_encode($alerta);
			 }

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

			 #Se cambio la linea (max_allowed_packet=16M) en my.ini de xampp para que acepte todos los archivos

			 $usuario_datos_reg = [
				[
					"campo_nombre" => "ID_Usuario ",
					"campo_marcador" => ":id", #Cambiar por el id recuperado de la nueva insercion 
					"campo_valor" => "1"
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

			 $regitrar_proveedor = $this->guardarDatosProveedor("proveedores", $usuario_datos_reg);

			 if($regitrar_proveedor->rowCount()==1){
				$alerta = [
					"tipo"=>"success",
					"titulo"=>"Registro exitoso",
					"texto"=>"Tu solicitud se envio correctamente",
					"icono"=>"success",
					"url"=>"inicio"
				];
			 } else {
				$alerta = [
					"tipo"=>"fail",
					"titulo"=>"Ocurrio un error inesperado",
					"texto"=>"La solicitud no se envio, intentelo de nuevo",
					"icono"=>"error"
				];
			 }
			 return json_encode($alerta);
		}
        
    }