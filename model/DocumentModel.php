<?php
require_once '../config/dbConection.php';

class DocumentModel
{
    private $conexion;
    private $uploadDir = 'uploads/'; // Directorio de almacenamiento de archivos

    public function __construct()
    {
        try {
            $this->conexion = new Conexion();
        } catch (Exception $e) {
            // Registrar error
            error_log('Error al conectar a la base de datos: ' . $e->getMessage());
            return false;
        }
    }

    public function create($nombre, $filePath, $tipoArchivo, $usuario_id)
    {
        try {
            // Verificar si la conexión está establecida
            if (!$this->conexion || !$this->conexion->pdo) {
                error_log('Error: No hay conexión con la base de datos.');
                return false; // No hay conexión, no se puede continuar
            }

            // Preparar la consulta SQL para insertar el documento
            $sql = "INSERT INTO documentos (nombre, ruta_archivo, tipo_archivo, usuario_id) 
                VALUES (:nombre, :ruta, :tipo, :usuario_id)";
            $stmt = $this->conexion->pdo->prepare($sql);

            // Enlazar los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':ruta', $filePath);
            $stmt->bindParam(':tipo', $tipoArchivo);
            $stmt->bindParam(':usuario_id', $usuario_id);

            // Ejecutar la consulta
            return $stmt->execute();
        } catch (Exception $e) {
            // Manejo de errores y registro en el log
            error_log('Error al insertar en la base de datos: ' . $e->getMessage());
            return false;
        }
    }

    public function getDocumentByNameAndUser($nombre, $usuario_id)
    {
        try {
            $sql = "SELECT * FROM documentos WHERE nombre = :nombre AND usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }


    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    // Leer Documento por ID
    public function read($id, $usuario_id)
    {
        try {
            $sql = "SELECT * FROM documentos WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo documento
        } catch (Exception $e) {
            error_log('Error al leer documento: ' . $e->getMessage());
            return false;
        }
    }

    // Leer Todos los Documentos de un Usuario
    public function readAll($usuario_id)
    {
        try {
            $sql = "SELECT * FROM documentos WHERE usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los documentos del usuario
        } catch (Exception $e) {
            error_log('Error al leer todos los documentos: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar Documento
    public function delete($id, $usuario_id)
    {
        try {

            $sql = "DELETE FROM documentos WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':usuario_id', $usuario_id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error al eliminar documento: ' . $e->getMessage());
            return false;
        }
    }


    public function deleteAll($usuario_id)
    {
        try {

            $sql = "DELETE FROM documentos WHERE  usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error al eliminar documento: ' . $e->getMessage());
            return false;
        }
    }


}



