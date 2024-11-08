<?php

namespace app\models;

use \PDO;
use mysqli;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (file_exists(__DIR__ . "/../../config/server.php")) {
    require_once __DIR__ . "/../../config/server.php";
}
class mainModel
{
    private $server = DB_SERVER;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $conexion;
    /*----------  Funcion conectar a BD  ----------*/
    protected function conectar()
    {
        $dsn = "mysql:host=" . $this->server . ";dbname=" . $this->db;
        $this->conexion = new PDO($dsn, $this->user, $this->pass);
        $this->conexion->exec("SET CHARACTER SET utf8");
        return $this->conexion;
    }


    /*----------  Funcion ejecutar consultas  ----------*/
    protected function ejecutarConsulta($consulta)
    {
        $sql = $this->conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }

    protected function guardarDatosProveedor($tabla, $datos)
    {
        $query = "INSERT INTO $tabla (";

        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_nombre"];
            $C++;
        }

        $query .= ") VALUES(";
        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_marcador"];
            $C++;
        }

        $query .= ")";
        $sql = $this->conectar()->prepare($query);

        foreach ($datos as $clave) {
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        if ($sql->execute()) {
            // Obtener el último ID insertado
            return $this->conexion->lastInsertId();
        } else {
            return false;
        }
    }

    /*----------  Funcion limpiar cadenas  ----------*/
    public function limpiarCadena($cadena)
    {

        $palabras = ["<script>", "</script>", "<script src", "<script type=", "SELECT * FROM", "SELECT ", " SELECT ", "DELETE FROM", "INSERT INTO", "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES", "SHOW DATABASES", "<?php", "?>", "--", "^", "<", ">", "==", "=", ";", "::"];

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        foreach ($palabras as $palabra) {
            $cadena = str_ireplace($palabra, "", $cadena);
        }

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        return $cadena;
    }

    /*------ Seleccionar datos -------*/
    public function seleccionarDatos($tipo, $tabla, $campo, $id)
    {
        $tipo = $this->limpiarCadena($tipo);
        $tabla = $this->limpiarCadena($tabla);
        $campo = $this->limpiarCadena($campo);
        $id = $this->limpiarCadena($id);

        if ($tipo == "Unico") {
            $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Normal") {
            $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
        }
        $sql->execute();

        return $sql;
    }


    /*----- Actualizar datos ----*/
    protected function actualizarDatos($tabla, $datos, $condicion)
    {

        $query = "UPDATE $tabla SET ";

        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_nombre"] . "=" . $clave["campo_marcador"];
            $C++;
        }

        $query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];

        $sql = $this->conectar()->prepare($query);

        foreach ($datos as $clave) {
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

        $sql->execute();

        return $sql;
    }


    /*---------- Funcion verificar datos (expresion regular) ----------*/
    protected function verificarDatos($filtro, $cadena)
    {
        if (preg_match("/^" . $filtro . "$/", $cadena)) {
            return false;
        } else {
            return true;
        }
    }

    /*----------  Funcion para ejecutar una consulta INSERT preparada  ----------*/
    protected function guardarDatos($tabla, $datos)
    {

        $query = "INSERT INTO $tabla (";

        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_nombre"];
            $C++;
        }

        $query .= ") VALUES(";

        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_marcador"];
            $C++;
        }

        $query .= ")";
        $sql = $this->conectar()->prepare($query);

        foreach ($datos as $clave) {
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        $sql->execute();

        return $sql;
    }

    public function getLastInsertId()
    {
        return $this->conexion->lastInsertId(); // Devuelve el último ID insertado
    }
    protected function guardarArchivosProveedor($ACTA, $CURP, $RFC, $id)
    {
        $con = new mysqli($this->server, $this->user, $this->pass, $this->db);
        // Verificar la conexión
        if ($con->connect_error) {
            die("Conexión fallida: " . $con->connect_error);
        }

        // Preparar y ejecutar la consulta
        $stmt = $con->prepare("UPDATE proveedores SET CURP = ?, RFC = ?, Acta_Constitutiva = ? WHERE ID_Usuario = $id");
        // Usar las variables como parámetros pasados por referencia
        $stmt->bind_param("sss", $CURP, $RFC, $ACTA);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function enviarCorreo($destino, $mensaje, $subject)
    {
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ecom11.faustino.sanchez@gmail.com';
            $mail->Password   = 'nxzubbwuzxwtqmqr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('ecom11.faustino.sanchez@gmail.com', 'SistemaDeVenta');
            $mail->addAddress($destino);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $mensaje;
            $mail->AltBody = strip_tags($mensaje);
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return "El correo no pudo enviarse. Error: {$mail->ErrorInfo}";
        }
    }

    protected function guardarFactura($archivo, $id)
    {
        $con = new mysqli($this->server, $this->user, $this->pass, $this->db);
        // Verificar la conexión
        if ($con->connect_error) {
            die("Conexión fallida: " . $con->connect_error);
        }

        // Preparar y ejecutar la consulta
        $stmt = $con->prepare("UPDATE facturas SET Archivo_Factura= ? WHERE Id_Factura = $id");
        // Usar las variables como parámetros pasados por referencia
        $stmt->bind_param("s", $archivo);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
