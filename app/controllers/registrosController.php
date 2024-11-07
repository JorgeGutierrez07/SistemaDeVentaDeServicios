<?php

namespace app\controllers;

use app\models\mainModel;

class registrosController extends mainModel 
{
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
                                <input type="hidden" name="modulo_registros" value="Aceptar">
                                <input type="hidden" name="usuario_id" value="'.$rows['ID_Usuario'].'">
								<input type="hidden" name="email_usuario" value="'.$rows['Correo'].'">
                                <button type="submit" class="btn btn-aceptar btn-sm" style="background-color: #28a745; color: white;">Aceptar</button>
                            </form>
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >
                                <input type="hidden" name="modulo_registros" value="Rechazar">
                                <input type="hidden" name="usuario_id" value="'.$rows['ID_Usuario'].'">
								<input type="hidden" name="email_usuario" value="'.$rows['Correo'].'">
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

	public function estadoSolicitudControlador($respuesta){

		$id=$this->limpiarCadena($_POST['usuario_id']);
		$correo=$this->limpiarCadena($_POST['email_usuario']);
		
		if($respuesta == "Aceptar"){
			$usuario_datos_up=[
				[
					"campo_nombre"=>"Estado",
					"campo_marcador"=>":Estado",
					"campo_valor"=>"aceptado"
				]
			];
			$envio_email = $this->enviarCorreo($correo, "Tu solicitud de registro al sistema de ventas ha sido aceptada");
		}elseif($respuesta == "Rechazar"){
			$usuario_datos_up=[
				[
					"campo_nombre"=>"Estado",
					"campo_marcador"=>":Estado",
					"campo_valor"=>"rechazado"
				]
			];
			$envio_email = $this->enviarCorreo($correo, "Tu solicitud de registro al sistema de ventas ha sido rechazada");
		}

		$condicion=[
			"condicion_campo"=>"ID_Usuario",
			"condicion_marcador"=>":ID",
			"condicion_valor"=>$id
		];

		if($this->actualizarDatos("estado_solicitud",$usuario_datos_up,$condicion) && $envio_email){

			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Solicitud de usuario actualizada",
				"text"=>"Cambios aceptados",
				"icono"=>"success"
			];
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"text"=>"No se pudieron realizar los cambios",
				"icono"=>"error"
			];
		}

		return json_encode($alerta);
	}
}