<?php

namespace app\models;

use \PDO;
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
        $this->conexion = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db, $this->user, $this->pass);
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

    protected function guardarDatosProveedor($tabla, $datos){
        $query = "INSERT INTO $tabla (";

        $C = 0;
        foreach($datos as $clave){
            if($C >= 1){ $query .= ","; }
            $query .= $clave ["campo_nombre"];
            $C++;
        }

        $query .= ") VALUES(";
        $C = 0;
        foreach($datos as $clave){
            if($C >= 1){ $query .= ","; }
            $query .= $clave ["campo_marcador"];
            $C++;
        }

         $query .= ")";
         $sql = $this->conectar()->prepare($query);

         foreach($datos as $clave){
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
         }

         if ($sql->execute()) {
            // Obtener el último ID insertado
            return $this->conexion->lastInsertId();
        } else {
            return false;
        }
    }
}
