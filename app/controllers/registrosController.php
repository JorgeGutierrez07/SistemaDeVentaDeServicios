<?php

namespace app\controllers;

use app\models\mainModel;
use PDO;
class registrosController extends mainModel 
{
	public function listarUsuarioControlador($registros){
 
        $registros=$this->limpiarCadena($registros);
        $tabla="";
 
        //SELECT u.ID_Usuario, u.Nombre, u.Apellidos, u.Correo, u.Tipo_Usuario, p.CURP, p.RFC, p.Acta_Constitutiva FROM usuarios u INNER JOIN estado_solicitud es ON u.ID_Usuario = es.ID_Usuario LEFT JOIN proveedores p ON u.ID_Usuario = p.ID_Usuario WHERE es.Estado = 'pendiente';
        $consulta_datos="SELECT u.ID_Usuario, u.Nombre, u.Apellidos, u.Correo, u.Tipo_Usuario, p.CURP, p.RFC, p.Acta_Constitutiva FROM usuarios u INNER JOIN estado_solicitud es ON u.ID_Usuario = es.ID_Usuario LEFT JOIN proveedores p ON u.ID_Usuario = p.ID_Usuario WHERE es.Estado = 'pendiente'";

        $consulta_total="SELECT COUNT(ID_Usuario) FROM usuarios
            WHERE ID_Usuario!='".$_SESSION['id']."'
            AND ID_Usuario!='1'";

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
                $tabla .= '
                <tr class="has-text-centered">
                    <td>' . $contador . '</td>
                    <td>' . $rows['Nombre'] . ' ' . $rows['Apellidos'] . '</td>
                    <td>' . $rows['Tipo_Usuario'] . '</td>
                    <td>' . $rows['Correo'] . '</td>
                    <td>';
            
                $archivos = [];
                if ($rows['CURP'] != null) {
                    $archivos[] = '<a href="'.APP_URL.'app/ajax/archivosAjax.php?tipo=curp&id='.$rows['ID_Usuario'].'" class="archivo-link"  >CURP</a>';
                }
                if ($rows['RFC'] != null) {
                    $archivos[] = '<a href="'.APP_URL.'app/ajax/archivosAjax.php?tipo=rfc&id='.$rows['ID_Usuario'].'" class="archivo-link" >RFC</a>';
                }
                if ($rows['Acta_Constitutiva'] != null) {
                    $archivos[] = '<a href="'.APP_URL.'app/ajax/archivosAjax.php?tipo=acta&id='.$rows['ID_Usuario'].'" class="archivo-link" >Acta Constitutiva</a>';
                }
            
            $tabla .= implode(', ', $archivos) ?: 'No tiene archivos cargados';
            
            $tabla .= '</td>
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
                </tr>';
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

    public function verPdf() {
        if (!isset($_GET['tipo']) || !isset($_GET['id'])) {
            die("Parámetros faltantes");
        }
    
        $userId = intval($_GET['id']); // Convierte `id` a entero para evitar inyecciones SQL
        $columna = "";
        $nombreArchivo = "";
    
        // Determinar qué columna consultar según el tipo
        switch ($_GET['tipo']) {
            case "curp":
                $columna = "CURP";
                $nombreArchivo = "CURP.pdf";
                break;
            case "rfc":
                $columna = "RFC";
                $nombreArchivo = "RFC.pdf";
                break;
            case "acta":
                $columna = "Acta_Constitutiva";
                $nombreArchivo = "Acta_Constitutiva.pdf";
                break;
            default:
                die("Tipo de documento no válido");
        }
    
        $servername = DB_SERVER;
        $username = DB_USER;
        $password = DB_PASS;
        $dbname = DB_NAME;
        $port = DB_PORT;

        // Crear conexión
        $conn = new \mysqli($servername, $username, $password, $dbname, $port);
        // Realizar la consulta en la base de datos
        $consulta_datos = "SELECT $columna FROM proveedores WHERE ID_Usuario = $userId";
        $stmt = $conn->prepare($consulta_datos);
        $stmt->execute();
        $stmt->bind_result($contenidoPDF);
        $stmt->fetch();
    
        if ($contenidoPDF) {
            // Configurar las cabeceras para mostrar el PDF en el navegador
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=$nombreArchivo");
    
            // Mostrar el contenido del PDF como binario
            echo $contenidoPDF;
        } else {
            echo "Archivo no encontrado.";
        }
    
        $stmt->close();
    }
    
    
}