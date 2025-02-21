<?php
require_once '../config/dbConection.php';

class Documento {
    private $conexion;
    private $uploadDir = 'uploads/'; // Directorio de almacenamiento de archivos

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Crear Documento (Guardar en la BD y mover el archivo)
    public function create($nombre, $file, $usuario_id)
    {
        // Obtener la extensión del archivo
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        // Mapear las extensiones a tipos de archivo
        $tipoArchivo = $this->getTipoArchivo($extension);
        
        $filePath = $this->uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            try {
                $sql = "INSERT INTO documentos (nombre, ruta_archivo, tipo_archivo, usuario_id) VALUES (:nombre, :ruta, :tipo, :usuario_id)";
                $stmt = $this->conexion->pdo->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':ruta', $filePath);
                $stmt->bindParam(':tipo', $tipoArchivo);
                $stmt->bindParam(':usuario_id', $usuario_id);

                return $stmt->execute();
            } catch (Exception $e) {
                return false; // Error al insertar en la base de datos
            }
        } else {
            return false; // Error al mover el archivo
        }
    }

    // Determinar el tipo de archivo basado en la extensión
    private function getTipoArchivo($extension)
    {
        // Definir los tipos de archivo soportados
        $tipos = [
            'php' => 'PHP',
            'doc' => 'Word',
            'docx' => 'Word',
            'xls' => 'Excel',
            'xlsx' => 'Excel',
            'pdf' => 'PDF',
            'txt' => 'Texto'
        ];

        // Retornar el tipo de archivo o 'Desconocido' si no está en el array
        return isset($tipos[$extension]) ? $tipos[$extension] : 'Desconocido';
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
            return false;
        }
    }

    // Actualizar Documento
    public function update($id, $nombre, $file, $usuario_id)
    {
        // Obtener la extensión del archivo
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        // Mapear las extensiones a tipos de archivo
        $tipoArchivo = $this->getTipoArchivo($extension);

        $filePath = $this->uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            try {
                $sql = "UPDATE documentos SET nombre = :nombre, ruta_archivo = :ruta, tipo_archivo = :tipo WHERE id = :id AND usuario_id = :usuario_id";
                $stmt = $this->conexion->pdo->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':ruta', $filePath);
                $stmt->bindParam(':tipo', $tipoArchivo);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':usuario_id', $usuario_id);

                return $stmt->execute();
            } catch (Exception $e) {
                return false; // Error al actualizar en la base de datos
            }
        } else {
            return false; // Error al mover el archivo
        }
    }

    // Eliminar Documento
    public function delete($id, $usuario_id)
    {
        try {
            // Obtener la ruta del archivo para poder eliminarlo
            $sql = "SELECT ruta_archivo FROM documentos WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($documento) {
                // Eliminar el archivo del servidor
                unlink($documento['ruta_archivo']);

                // Eliminar el registro de la base de datos
                $sql = "DELETE FROM documentos WHERE id = :id AND usuario_id = :usuario_id";
                $stmt = $this->conexion->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':usuario_id', $usuario_id);

                return $stmt->execute();
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}