<?php

require_once '../model/UserModel.php';
require_once '../model/DocumentModel.php';
session_start();

if (isset($_GET['user_id'])) {
    $usuario_id = $_GET['user_id'];

    $newUser = new UserModel();
    $newDocument = new DocumentModel(); // Corregir el nombre de la variable

    try {

        // Obtener todos los documentos del usuario
        $documents = $newDocument->readAll($usuario_id);

        if ($documents) {
            // Iterar sobre todos los documentos y eliminarlos
            foreach ($documents as $document) {

                $filePath = $document['ruta_archivo'];

                // Verificar si el archivo existe y eliminarlo
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Eliminar el registro de la base de datos
                $deleteResult = $newDocument->delete($document['id'], $usuario_id);

                if (!$deleteResult) {
                    throw new Exception("Hubo un error al eliminar el documento con ID " . $document['id'] . " de la base de datos.");
                }
            }
        }

        // Eliminar el usuario
        if ($newUser->delete($usuario_id)) {
            $_SESSION['exito'] = "Usuario eliminado exitosamente.";
            header("Location: ../view/usuarios.php");          
        } else {
            throw new Exception("Hubo un error al eliminar el usuario.");
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../view/usuarios.php");
    }

} else {
    $_SESSION['error'] = "Faltan datos en el formulario.";
    header("Location: ../view/usuarios.php");
}

?>
