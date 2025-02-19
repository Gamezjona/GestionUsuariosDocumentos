<?php
require_once '../config/dbConection.php';

class User {
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new Conexion();
        } catch (Exception $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // 🔹 Crear Usuario
    public function create($nombre, $apellido) {
        try {
            $sql = "INSERT INTO usuarios (nombre, apellido) VALUES (:nombre, :apellido)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            return $stmt->execute();
        } catch (Exception $e) {
            die("Error al insertar usuario: " . $e->getMessage());
        }
    }

    // 🔹 Obtener Usuario por ID
    public function getById($id) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Error al obtener usuario: " . $e->getMessage());
        }
    }

    // 🔹 Actualizar Usuario
    public function update($id, $nombre, $apellido) {
        try {
            $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            return $stmt->execute();
        } catch (Exception $e) {
            die("Error al actualizar usuario: " . $e->getMessage());
        }
    }

    // 🔹 Eliminar Usuario
    public function delete($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            die("Error al eliminar usuario: " . $e->getMessage());
        }
    }
}
?>
