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
            // Forzar la descarga del archivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit();
        } else {
            $_SESSION['error'] = "Error: El archivo no existe en el servidor.";
            header("Location: ../view/listadoDocumentos.php");
        }
    } else {
        $_SESSION['error'] = "Documento no encontrado.";
        header("Location: ../view/listadoDocumentos.php");
    }
} else {
    $_SESSION['error'] = "Faltan datos en el formulario.";
    header("Location: ../view/listadoDocumentos.php");
}
