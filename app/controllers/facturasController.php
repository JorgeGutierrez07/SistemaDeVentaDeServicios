<?php

namespace app\controllers;

use app\models\mainModel;
use PDO;
class facturasController extends mainModel 
{
	public function listarFacturasControlador($facturas){
 
        $facturas=$this->limpiarCadena($facturas);
        $tabla="";
 
        $consulta_datos="SELECT f.id_Factura, u.Nombre, f.Razon_de_Factura, f.Archivo_Factura, f.Estado  FROM usuarios u INNER JOIN facturas f ON u.ID_Usuario = f.ID_Usuario";

        $consulta_total="SELECT COUNT(id_Factura) FROM facturas";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $tabla.='
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-bordered" style="position: sticky; top: 0; background-color: white;">
                <thead>
                    <tr>
                        <th>N° FACTURA</th>
                        <th>ESTADO</th>
                        <th>RAZÓN DE LA FACTURA</th>
                        <th>PROVEEDOR</th>
                        <th>PDF FACTURA</th>
                        <th>ACTUALIZAR</th>
                    </tr>
                </thead>
                <tbody>
        ';
 
        if($total>=1){
            $contador=1;
            foreach($datos as $rows){
                $tabla .= '
                <tr class="has-text-centered">
                <form class="FormularioProveedor" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >
                    <td>' . $rows['id_Factura'] . '</td>
                    <td>
                    <select id="estado" name="estado">
                        <option value="" disabled selected>' . $rows['Estado'] . '</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="pagado">Pagado</option>
                        <option value="vencido">Vencido</option>
                    </select>
                    </td>
                    <td>' . $rows['Razon_de_Factura'] . '</td>
                    <td>' . $rows['Nombre'] . '</td>
                    <td>';
            
                $archivos = [];
                if ($rows['Archivo_Factura'] != null) {
                    $archivos[] = '<a href="'.APP_URL.'app/ajax/facturaAjax.php?id='.$rows['id_Factura'].'" class="archivo-link">FACTURA<i class="bi bi-file-pdf-fill text-danger"></i></a>';
                }
            
                $tabla .= implode(', ', $archivos) ?: 'No tiene archivos cargados';
                
                $tabla .= '</td>
                        <td class="d-flex justify-content-center gap-4">
                                <input type="hidden" name="modulo_facturas" value="Aceptar">
                                <input type="hidden" name="factura_id" value="'.$rows['id_Factura'].'">
                                <button type="submit" class="btn btn-aceptar btn-sm" style="background-color: #28a745; color: white;">Actualizar</button>
                        </td>
                    </form>
                </tr>';
            $contador++;
            }
        }else{
            if($total==0){
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

	public function actualizarFacturaControlador(){

		$id=$this->limpiarCadena($_POST['factura_id']);
        if(!isset($_POST['estado'])){
            $alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"text"=>"No selecionaste ningun valor",
				"icono"=>"error"
			];
        } else {
            $estado=$this->limpiarCadena($_POST['estado']);
            $factura_datos_up=[
                [
                    "campo_nombre"=>"Estado",
                    "campo_marcador"=>":estado",
                    "campo_valor"=>$estado
                ]
            ];

            $condicion=[
                "condicion_campo"=>"Id_Factura",
                "condicion_marcador"=>":id",
                "condicion_valor"=>$id
            ];

            if($this->actualizarDatos("facturas",$factura_datos_up,$condicion)){

                $alerta=[
                    "tipo"=>"recargar",
                    "titulo"=>"Estado de factura actualizado",
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
        }

		return json_encode($alerta);
	}

    public function verPdf() {
        if (!isset($_GET['id'])) {
            die("Parámetros faltantes");
        }
    
        $facturaId = intval($_GET['id']); // Convierte `id` a entero para evitar inyecciones SQL

        // Crear conexión
        $conn = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        // Realizar la consulta en la base de datos
        $consulta_datos = "SELECT Archivo_Factura  FROM facturas WHERE Id_Factura = $facturaId";
        $stmt = $conn->prepare($consulta_datos);
        $stmt->execute();
        $stmt->bind_result($contenidoPDF);
        $stmt->fetch();
    
        if ($contenidoPDF) {
            // Configurar las cabeceras para mostrar el PDF en el navegador
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=Factura");
    
            // Mostrar el contenido del PDF como binario
            echo $contenidoPDF;
        } else {
            echo "Archivo no encontrado.";
        }
    
        $stmt->close();
    }
}