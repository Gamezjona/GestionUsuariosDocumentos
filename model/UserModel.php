<?php
require_once '../config/dbConection.php';

class UserModel {
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new Conexion();
        } catch (Exception $e) {
            // En caso de fallo en la conexión, se retorna false
            return false;
        }
    }

    // 🔹 Crear Usuario
    public function create($nombre, $apellido, $correo, $contrasena) {
        try {
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, contrasena) VALUES (:nombre, :apellido, :correo, :contrasena)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena);
            return $stmt->execute();
        } catch (Exception $e) {
            // Si ocurre un error, se retorna false
            return false;
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
            // Si ocurre un error, se retorna false
            return false;
        }
    }

    // 🔹 Obtener Todos los Usuarios
    public function getAll() {
        try {
            $sql = "SELECT * FROM usuarios";
            $stmt = $this->conexion->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Si ocurre un error, se retorna false
            return false;
        }
    }

    // 🔹 Actualizar Usuario
    public function update($id, $nombre, $apellido, $correo, $contrasena) {
        try {
            $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo, contrasena = :contrasena WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena);
            return $stmt->execute();
        } catch (Exception $e) {
            // Si ocurre un error, se retorna false
            return false;
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
            // Si ocurre un error, se retorna false
            return false;
        }
    }
}
?>
