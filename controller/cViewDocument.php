<?php

require_once '../model/DocumentModel.php';
session_start();

if (isset($_GET['nombreDocument']) && isset($_SESSION['id'])) {

    $docNombre = $_GET['nombreDocument'];
    $usuario_id = $_SESSION['id'];

    $newDocument = new DocumentModel();

    // Obtener el documento desde la base de datos
    $document = $newDocument->getDocumentByNameAndUser($docNombre, $usuario_id);

    if ($document) {
        $filePath = $document['ruta_archivo']; // Ruta del archivo almacenada en la BD

        if (file_exists($filePath)) {
            // Obtener el tipo MIME del archivo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filePath);
            finfo_close($finfo);

            // Forzar la visualización del archivo en el navegador
            header("Content-Type: $mimeType");
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            header('Accept-Ranges: bytes');

            readfile($filePath);
            exit();
        } else {
            echo "Error: El archivo no existe en el servidor.";
        }
    } else {
        echo "Documento no encontrado.";
    }
} else {
    echo "Faltan datos en el formulario.";
}
