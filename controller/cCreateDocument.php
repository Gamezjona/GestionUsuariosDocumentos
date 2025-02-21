<?php

require_once '../model/DocumentModel.php';
session_start(); // Se recomienda iniciar la sesión al principio

// Verifica si se recibieron los datos necesarios del formulario
if (isset($_POST['nombre']) && isset($_FILES['documento']) && isset($_SESSION['id'])) {

    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $documento = $_FILES['documento'];
    $usuario_id = $_SESSION['id'];

    // Crear un nuevo objeto de la clase DocumentModel
    $newDocument = new DocumentModel();

    // Obtener el directorio de subida
    $uploadDir = $newDocument->getUploadDir();
    $filePath = $uploadDir . basename($documento['name']);

    // Verificar si el archivo ya está subido en el servidor
    if (file_exists($filePath)) {
        echo "El archivo ya ha sido subido anteriormente.";
    } else {
        // Verificar si el archivo ya está registrado en la base de datos
        $existingDocument = $newDocument->getDocumentByNameAndUser($nombre, $usuario_id);

        if ($existingDocument) {
            echo "Ya tienes un archivo con ese nombre.";
        } else {
            // Si el archivo no existe, intentar mover el archivo subido al directorio adecuado
            if (move_uploaded_file($documento['tmp_name'], $filePath)) {
                // Si se movió correctamente, crear el documento en la base de datos
                $result = $newDocument->create($nombre, $filePath, $usuario_id);

                if ($result) {
                    echo "Documento subido exitosamente.";
                } else {
                    echo "Hubo un error al guardar el documento en la base de datos.";
                }
            } else {
                echo "Hubo un error al mover el archivo al servidor.";
            }
        }
    }
} else {
    echo "Faltan datos en el formulario.";
}
?>
