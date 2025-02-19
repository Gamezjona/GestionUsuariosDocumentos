<?php
require_once '../config/dbConection.php';

class Document
{
    private $conexion;
    private $uploadDir = '../uploads/'; // Directorio donde se guardarán los archivos

    public function __construct()
    {
        $this->conexion = new Conexion();

        // Asegurarse de que el directorio de subida exista
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    // 🔹 Crear Documento (Guarda en la BD y mueve el archivo)
    public function create($nombre, $file)
    {
        // Generar el nombre completo del archivo (ruta y nombre)
        $filePath = $this->uploadDir . basename($file['name']);

        // Mover el archivo del directorio temporal al destino
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Insertar los datos en la base de datos
            try {
                $sql = "INSERT INTO documentos (nombre, ruta_archivo) VALUES (:nombre, :ruta)";
                $stmt = $this->conexion->pdo->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':ruta', $filePath);

                return $stmt->execute();
            } catch (Exception $e) {
                return false; // Error al insertar en la base de datos
            }
        } else {
            return false; // Error al mover el archivo
        }
    }


    // 🔹 Eliminar Documento (De la BD y del directorio)
    public function delete($id)
    {
        try {
            // Buscar el archivo en la base de datos
            $sql = "SELECT ruta_archivo FROM documentos WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($documento) {
                $filePath = $documento['ruta_archivo'];

                // Borrar el archivo físico del servidor si existe
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Eliminar el registro de la base de datos
                $sql = "DELETE FROM documentos WHERE id = :id";
                $stmt = $this->conexion->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);

                return $stmt->execute();
            }

            return false; // No se encontró el documento
        } catch (Exception $e) {
            return false; // Error en la eliminación
        }
    }

    // 🔹 Obtener Documento (Buscar por ID)
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM documentos WHERE id = :id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false; // Error en la consulta
        }
    }

    // 🔹 Listar Todos los Documentos
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM documentos";
            $stmt = $this->conexion->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false; // Error en la consulta
        }
    }
}
