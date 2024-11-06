<?php

namespace app\models;

use \PDO;
<<<<<<< HEAD:SistemaDeVentaDeServicios/app/models/mainModel.php
use PDOException;

=======
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
>>>>>>> 899df87a69ab6db078624f7f26f377d034c50b5a:app/models/mainModel.php

if (file_exists(__DIR__ . "/../../config/server.php")) {
    require_once __DIR__ . "/../../config/server.php";
}
class mainModel
{
    private $server = DB_SERVER;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
<<<<<<< HEAD:SistemaDeVentaDeServicios/app/models/mainModel.php
    private $port = DB_PORT;
    private $conexion;

    protected function conectar()
    {
        // Modifica la cadena de conexión para incluir el puerto
        $dsn = "mysql:host=" . $this->server . ";dbname=" . $this->db . ";port=" . $this->port;
        $this->conexion = new PDO($dsn, $this->user, $this->pass);
=======
    private $conexion;
    /*----------  Funcion conectar a BD  ----------*/
    protected function conectar()
    {
        $this->conexion = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db, $this->user, $this->pass);
>>>>>>> 899df87a69ab6db078624f7f26f377d034c50b5a:app/models/mainModel.php
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

    /* GUARDAR */

    protected function guardarDatos($tabla, $datos){
        
        // Construir la consulta INSERT
        $query="INSERT INTO $tabla (";

        $C=0;
        foreach ($datos as $clave){
            if($C>=1){ $query.=","; }
            $query.=$clave["campo_nombre"];
            $C++;
        }
        
        $query.=") VALUES(";

        $C=0;
        foreach ($datos as $clave){
            if($C>=1){ $query.=","; }
            $query.=$clave["campo_marcador"];
            $C++;
        }

        $query.=")";
        $sql=$this->conectar()->prepare($query);

        foreach ($datos as $clave){
            $sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
        }

        $sql->execute();

        return $sql;
    }

    public function getLastInsertId() {
        return $this->conexion->lastInsertId(); // Devuelve el último ID insertado
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
    public function enviarCorreo($destino, $mensaje)
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
            $mail->Subject = 'Recuperacion de Contraseña';
            $mail->Body    = $mensaje;
            $mail->AltBody = strip_tags($mensaje);
            if ( $mail->send()) {
                return true;
            }else {
                return false;
            }
        } catch (Exception $e) {
            return "El correo no pudo enviarse. Error: {$mail->ErrorInfo}";
        }
    }
}
