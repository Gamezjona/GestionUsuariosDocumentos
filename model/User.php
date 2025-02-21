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
    public function create($nombre, $apellido, $contrasena) {
        try {
            $sql = "INSERT INTO usuarios (nombre, apellido, contrasena) VALUES (:nombre, :apellido, :contrasena)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':contrasena', $contrasena);
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

    // 🔹 Obtener Todos los Usuarios
    public function getAll() {
        try {
            $sql = "SELECT * FROM usuarios";
            $stmt = $this->conexion->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    // 🔹 Actualizar Usuario
    public function update($id, $nombre, $apellido, $contrasena) {
        try {
            $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':contrasena', $contrasena);
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
