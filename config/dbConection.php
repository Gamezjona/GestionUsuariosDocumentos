<?php
class Conexion {
    private $host = "localhost";
    private $dbname = "userdocument";
    private $usuario = "root";
    private $password = "";
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->usuario, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
