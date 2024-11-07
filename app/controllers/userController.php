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
	public function listarUsuarioControlador($registros){
 
        $registros=$this->limpiarCadena($registros);
        $tabla="";
 
        //SELECT usuarios.ID_Usuario, usuarios.Nombre, usuarios.Apellido, usuarios.Correo, usuarios.Tipo_Usuario FROM usuarios JOIN estado_solicitud ON usuarios.ID_Usuario = estado_solicitud.ID_Usuario WHERE estado_solicitud.Estado = 1;
        $consulta_datos="SELECT usuarios.ID_Usuario, usuarios.Nombre, usuarios.Apellidos, usuarios.Correo, usuarios.Tipo_Usuario FROM usuarios JOIN estado_solicitud ON usuarios.ID_Usuario = estado_solicitud.ID_Usuario WHERE  estado_solicitud.Estado = 'pendiente' AND usuarios.ID_Usuario!='".$_SESSION['id']."' AND usuarios.ID_Usuario!='1' ORDER BY Nombre ASC LIMIT $registros";
        $consulta_total="SELECT COUNT(ID_Usuario) FROM usuarios WHERE ID_Usuario!='".$_SESSION['id']."' AND ID_Usuario!='1'";
 
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();
 
        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();
 
        $tabla.='
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-bordered" style="position: sticky; top: 0; background-color: white;">
                <thead>
                    <tr>
                        <th>N° Registro</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Correo Electrónico</th>
                        <th>PDF</th>
                        <th>Validar solicitud</th>
                    </tr>
                </thead>
                <tbody>
        ';
 
        if($total>=1){
            $contador=1;
            foreach($datos as $rows){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td>'.$contador.'</td>
                        <td>'.$rows['Nombre'].' '.$rows['Apellidos'].'</td>
                        <td>'.$rows['Tipo_Usuario'].'</td>
                        <td>'.$rows['Correo'].'</td>
                        <td>
                            <i class="bi bi-file-pdf-fill text-danger"></i>
                            <i class="bi bi-file-pdf-fill text-danger"></i>
                            <i class="bi bi-file-pdf-fill text-danger"></i>
                        </td>
                        <td class="d-flex justify-content-center gap-4">
                            <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >
                                <input type="hidden" name="modulo_usuario" value="Aceptar">
                                <input type="hidden" name="usuario_id" value="'.$rows['ID_Usuario'].'">
                                <button type="submit" class="btn btn-aceptar btn-sm" style="background-color: #28a745; color: white;">Aceptar</button>
                            </form>
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >
                                <input type="hidden" name="modulo_usuario" value="Rechazar">
                                <input type="hidden" name="usuario_id" value="'.$rows['ID_Usuario'].'">
                                <button type="submit" class="btn btn-rechazar btn-sm" style="background-color: #d9534f; color: white;">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                ';
                $contador++;
            }
        }else{
            if($total>=0){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td colspan="7">
                            No hay registros en el sistema
                        </td>
                    </tr>
                ';
            }
        }
 
        $tabla.='</tbody></table></div>';
        return $tabla;
    }

	public function actualizarUsuarioControlador(){

		$id=$this->limpiarCadena($_POST['usuario_id']);

		# Verificando usuario #
		$datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		if($datos->rowCount()<=0){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos encontrado el usuario en el sistema",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}else{
			$datos=$datos->fetch();
		}

		$admin_usuario=$this->limpiarCadena($_POST['administrador_usuario']);
		$admin_clave=$this->limpiarCadena($_POST['administrador_clave']);

		# Verificando campos obligatorios admin #
		if($admin_usuario=="" || $admin_clave==""){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No ha llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"Su USUARIO no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"Su CLAVE no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando administrador #
		$check_admin=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_id='".$_SESSION['id']."'");
		if($check_admin->rowCount()==1){

			$check_admin=$check_admin->fetch();

			if($check_admin['usuario_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['usuario_clave'])){

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"USUARIO o CLAVE de administrador incorrectos",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"USUARIO o CLAVE de administrador incorrectos",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}


		# Almacenando datos#
		$nombre=$this->limpiarCadena($_POST['usuario_nombre']);
		$apellido=$this->limpiarCadena($_POST['usuario_apellido']);

		$usuario=$this->limpiarCadena($_POST['usuario_usuario']);
		$email=$this->limpiarCadena($_POST['usuario_email']);
		$clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
		$clave2=$this->limpiarCadena($_POST['usuario_clave_2']);

		# Verificando campos obligatorios #
		if($nombre=="" || $apellido=="" || $usuario==""){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No has llenado todos los campos que son obligatorios",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando integridad de los datos #
		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El NOMBRE no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El APELLIDO no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El USUARIO no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando email #
		if($email!="" && $datos['usuario_email']!=$email){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$check_email=$this->ejecutarConsulta("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
				if($check_email->rowCount()>0){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}

		# Verificando claves #
		if($clave1!="" || $clave2!=""){
			if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las CLAVES no coinciden con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
				if($clave1!=$clave2){

					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Las nuevas CLAVES que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}else{
					$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
				}
			}
		}else{
			$clave=$datos['usuario_clave'];
		}

		# Verificando usuario #
		if($datos['usuario_usuario']!=$usuario){
			$check_usuario=$this->ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			if($check_usuario->rowCount()>0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}

		$usuario_datos_up=[
			[
				"campo_nombre"=>"usuario_nombre",
				"campo_marcador"=>":Nombre",
				"campo_valor"=>$nombre
			],
			[
				"campo_nombre"=>"usuario_apellido",
				"campo_marcador"=>":Apellido",
				"campo_valor"=>$apellido
			],
			[
				"campo_nombre"=>"usuario_usuario",
				"campo_marcador"=>":Usuario",
				"campo_valor"=>$usuario
			],
			[
				"campo_nombre"=>"usuario_email",
				"campo_marcador"=>":Email",
				"campo_valor"=>$email
			],
			[
				"campo_nombre"=>"usuario_clave",
				"campo_marcador"=>":Clave",
				"campo_valor"=>$clave
			],
			[
				"campo_nombre"=>"usuario_actualizado",
				"campo_marcador"=>":Actualizado",
				"campo_valor"=>date("Y-m-d H:i:s")
			]
		];

		$condicion=[
			"condicion_campo"=>"usuario_id",
			"condicion_marcador"=>":ID",
			"condicion_valor"=>$id
		];

		if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

			if($id==$_SESSION['id']){
				$_SESSION['nombre']=$nombre;
				$_SESSION['apellido']=$apellido;
				$_SESSION['usuario']=$usuario;
			}

			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Usuario actualizado",
				"texto"=>"Los datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." se actualizaron correctamente",
				"icono"=>"success"
			];
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido'].", por favor intente nuevamente",
				"icono"=>"error"
			];
		}

		return json_encode($alerta);
	}

}
