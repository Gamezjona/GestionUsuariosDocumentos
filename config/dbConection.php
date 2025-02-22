<?php
class Conexion {
    private $host = "sql113.infinityfree.com";
    private $dbname = "if0_37830654_userDocument";
    private $usuario = "if0_37830654";
    private $password = "sebasGamez8";
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
