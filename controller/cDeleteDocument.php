<?php

require_once '../model/DocumentModel.php';
session_start();

if (isset($_GET['document_id']) && isset($_GET['nombreDocument']) && isset($_SESSION['id'])) {

    // Eliminación de archivos
    $docNombre = $_GET['nombreDocument'];
    $document_id = $_GET['document_id'];
    $usuario_id = $_SESSION['id'];

    $newDocument = new DocumentModel();

    try {
        // Obtener el documento desde la base de datos
        $document = $newDocument->getDocumentByNameAndUser($docNombre, $usuario_id);

        if ($document) {
            $filePath = $document['ruta_archivo']; // Ruta del archivo almacenada en la BD

            // Eliminar el archivo del servidor
            if (file_exists($filePath) && unlink($filePath)) {
                // Eliminar el registro de la base de datos
                $deleteResult = $newDocument->delete($document_id, $usuario_id);

                if ($deleteResult) {
                    $_SESSION['exito'] = "Documento eliminado exitosamente.";
                    header("Location: ../view/listadoDocumentos.php");
                } else {
                    throw new Exception("Hubo un error al eliminar el documento de la base de datos.");
                }
            } else {
                throw new Exception("Error al eliminar el archivo del servidor.");
            }
        } else {
            throw new Exception("Documento no encontrado.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../view/listadoDocumentos.php");
    }
} else {
    $_SESSION['error'] = "Faltan datos en el formulario.";
    header("Location: ../view/listadoDocumentos.php");
}
