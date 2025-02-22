<?php

require_once '../model/DocumentModel.php';
session_start();

if (isset($_FILES['documento']) && isset($_SESSION['id'])) {

    $documento = $_FILES['documento'];
    $usuario_id = $_SESSION['id'];

    $newDocument = new DocumentModel();

    // Obtener el directorio de subida
    $uploadDir = $newDocument->getUploadDir();
    $filePath = $uploadDir . basename($documento['name']);

    // Obtener la extensión del archivo
    $extension = pathinfo($documento['name'], PATHINFO_EXTENSION);

    // Verificar si el archivo ya está subido en el servidor
    if (file_exists($filePath)) {
        echo "El archivo ya ha sido subido anteriormente.";
    } else {
        // Verificar si el archivo ya está registrado en la base de datos
        $existingDocument = $newDocument->getDocumentByNameAndUser($documento['name'], $usuario_id);

        if ($existingDocument) {

            echo "Ya tienes un archivo con ese nombre en la base de datos";
        } else {
            // Si el archivo no existe, intentar mover el archivo subido al directorio adecuado
            if (move_uploaded_file($documento['tmp_name'], $filePath)) {

                // Si se movió correctamente, crear el documento en la base de datos
                $result = $newDocument->create($documento['name'], $filePath, $extension, $usuario_id);

                if ($result) {
                    header("Location: ../view/listadoDocumentos.php");
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
