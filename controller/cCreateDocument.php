<?php

require_once '../model/DocumentModel.php';
session_start();

if (isset($_FILES['documento']) && isset($_SESSION['id'])) {

    $documento = $_FILES['documento'];
    $usuario_id = $_SESSION['id'];

    $newDocument = new DocumentModel();

    // Obtener el directorio de subida
    $uploadDir = $newDocument->getUploadDir();

    // Obtener la extensión del archivo
    $extension = strtolower(pathinfo($documento['name'], PATHINFO_EXTENSION));

    // Definir las extensiones permitidas
    $allowedExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx'];

    // Modificar el nombre del archivo para agregar el ID de sesión al inicio
    $newFileName = $usuario_id . "_" . basename($documento['name']);
    $filePath = $uploadDir . $newFileName;

    // Verificar si la extensión del archivo está permitida
    if (!in_array($extension, $allowedExtensions)) {
        $_SESSION['error'] = "Solo se permiten archivos PDF, Excel (XLS/XLSX) y Word (DOC/DOCX).";
        header("Location: ../view/documentos.php");
        exit();
    }

    // Verificar si el archivo ya está subido en el servidor
    try {

        if (file_exists($filePath)) {
            throw new Exception("El archivo ya ha sido subido anteriormente.");
        } else {
            // Verificar si el archivo ya está registrado en la base de datos
            $existingDocument = $newDocument->getDocumentByNameAndUser($newFileName, $usuario_id);

            if ($existingDocument) {
                throw new Exception("Ya tienes un archivo con ese nombre en la base de datos.");
            } else {
                // Si el archivo no existe, intentar mover el archivo subido al directorio adecuado
                if (move_uploaded_file($documento['tmp_name'], $filePath)) {

                    // Si se movió correctamente, crear el documento en la base de datos
                    $result = $newDocument->create($newFileName, $filePath, $extension, $usuario_id);

                    if ($result) {
                        $_SESSION['exito'] = 'Documento agregado exitosamente.';
                        header("Location: ../view/listadoDocumentos.php");
                    } else {
                        throw new Exception("Hubo un error al guardar el documento en la base de datos.");
                    }
                } else {
                    throw new Exception("Hubo un error al mover el archivo al servidor.");
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../view/documentos.php");
    }
} else {
    $_SESSION['error'] = "Faltan datos en el formulario.";
    header("Location: ../view/documentos.php");
}

?>
