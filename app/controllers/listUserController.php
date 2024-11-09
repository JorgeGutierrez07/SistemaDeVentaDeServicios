<?php

namespace app\controllers;

use app\models\mainModel;

class listUserController extends mainModel
{
    public function listarControlador($registros)
    {
        $registros = $this->limpiarCadena($registros);
        $tabla = "";

        // Consultas para obtener los datos de los usuarios
        $consulta_datos = "SELECT usuarios.ID_Usuario, usuarios.Nombre, usuarios.Apellidos, usuarios.Correo, usuarios.Tipo_Usuario FROM usuarios JOIN estado_solicitud ON usuarios.ID_Usuario = estado_solicitud.ID_Usuario WHERE estado_solicitud.Estado = 'aceptado' AND usuarios.ID_Usuario != '" . $_SESSION['id'] . "' AND usuarios.ID_Usuario != '1' ORDER BY Nombre ASC LIMIT $registros";
        $consulta_total = "SELECT COUNT(ID_Usuario) FROM usuarios WHERE ID_Usuario != '" . $_SESSION['id'] . "' AND ID_Usuario != '1'";

        $datos = $this->ejecutarConsulta($consulta_datos)->fetchAll();
        $total = (int) $this->ejecutarConsulta($consulta_total)->fetchColumn();

        // Construir la tabla con los registros de usuarios
        $tabla .= '
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>N° Registro</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Correo Electrónico</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        if ($total >= 1) {
            $contador = 1;
            foreach ($datos as $rows) {
                $tabla .= '
                    <tr class="text-center">
                     <form class="usuarioActualizar-form" method="POST" action="' . APP_URL . 'app/ajax/usuarioAjax.php">
                        <td>' . $contador . '</td>
                        <td>
                            <input type="text" class="form-control" name="nombre_usuario" value="' . $rows['Nombre'] . '">
                        </td>
                        <td>' . $rows['Tipo_Usuario'] . '</td>
                        <td>
                            <input type="email" class="form-control" name="correo_usuario" value="' . $rows['Correo'] . '">
                        </td>
                        <td>
                            <input type="hidden" name="modulo_usuario" value="actualizarUsuario">
                            <input type="hidden" name="usuario_id" value="' . $rows['ID_Usuario'] . '">
                            <button type="submit" class="btn fw-bold rounded-pill py-2 w-100" style="background-color: #2ABFBF; color: white;">
                                Guardar Cambios
                            </button>
                        </td>
                     </form>
                    </tr>
                ';
                $contador++;
            }
        } else {
            $tabla .= '
                <tr class="text-center">
                    <td colspan="5">No hay registros en el sistema</td>
                </tr>
            ';
        }

        $tabla .= '
                    </tbody>
                </table>
            </div>
        ';

        return $tabla;
    }
}
