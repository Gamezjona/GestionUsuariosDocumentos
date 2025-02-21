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

    // Crear Documento (Guardar en la BD y mover el archivo)
    public function create($nombre, $file, $usuario_id)
    {
        // Verificar si $file es un arreglo y contiene la información esperada
        if (is_array($file) && isset($file['name']) && isset($file['tmp_name'])) {
            // Obtener la extensión del archivo
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Mapear las extensiones a tipos de archivo
            $tipoArchivo = $this->getTipoArchivo($extension);

            // Validar si la extensión es permitida
            $allowedExtensions = ['pdf', 'docx', 'xlsx', 'jpg', 'png', 'txt'];
            if (!in_array($extension, $allowedExtensions)) {
                return false; // Error si la extensión no es permitida
            }

            // Definir el nombre del archivo y la ruta
            $filePath = $this->uploadDir . uniqid() . basename($file['name']); // Usar uniqid() para evitar nombres duplicados

            // Verificar si el directorio de subida existe, si no, crearlo
            if (!file_exists($this->uploadDir)) {
                mkdir($this->uploadDir, 0777, true); // Crear directorio con permisos de escritura
            }

            // Mover el archivo al directorio de uploads
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                try {
                    // Realizar la inserción en la base de datos
                    $sql = "INSERT INTO documentos (nombre, ruta_archivo, tipo_archivo, usuario_id) VALUES (:nombre, :ruta, :tipo, :usuario_id)";
                    $stmt = $this->conexion->pdo->prepare($sql);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':ruta', $filePath);
                    $stmt->bindParam(':tipo', $tipoArchivo);
                    $stmt->bindParam(':usuario_id', $usuario_id);

                    // Ejecutar la consulta
                    return $stmt->execute();
                } catch (Exception $e) {
                    // Manejo de errores si ocurre un problema con la base de datos
                    error_log('Error al insertar en la base de datos: ' . $e->getMessage());
                    return false; // Error al insertar en la base de datos
                }
            } else {
                // Error al mover el archivo
                return false;
            }
        } else {
            // Error si no se ha recibido un archivo correctamente
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

            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna el documento si existe
        } catch (Exception $e) {
            return false;
        }
    }

    // Método para obtener el directorio de subida
    public function getUploadDir()
    {
        return $this->uploadDir;
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

    // Actualizar Documento
    public function update($id, $nombre, $file, $usuario_id)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $tipoArchivo = $this->getTipoArchivo($extension);
        $filePath = $this->uploadDir . uniqid() . basename($file['name']);

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
                error_log('Error al actualizar el documento: ' . $e->getMessage());
                return false; // Error al actualizar
            }
        } else {
            return false; // Error al mover el archivo
        }
    }

    // Eliminar Documento
    public function delete($id, $usuario_id)
    {
        try {
            $sql = "SELECT ruta_archivo FROM documentos WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($documento) {
                unlink($documento['ruta_archivo']); // Eliminar archivo del servidor

                $sql = "DELETE FROM documentos WHERE id = :id AND usuario_id = :usuario_id";
                $stmt = $this->conexion->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':usuario_id', $usuario_id);

                return $stmt->execute();
            } else {
                return false; // Documento no encontrado
            }
        } catch (Exception $e) {
            error_log('Error al eliminar documento: ' . $e->getMessage());
            return false;
        }
    }
}
