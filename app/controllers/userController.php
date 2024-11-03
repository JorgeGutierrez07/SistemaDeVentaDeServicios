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
			$curp = $this->limpiarCadena($_FILES['curp']['tmp_name']);
			$rfc = $this->limpiarCadena($_FILES['rfc']['tmp_name']);
			$acta = $this->limpiarCadena($_FILES['acta']['tmp_name']);

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

		}
        
    }