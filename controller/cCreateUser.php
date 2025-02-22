<?php

require_once '../model/UserModel.php';
session_start(); // Se recomienda iniciar la sesión al principio

if (isset($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['password'], $_POST['password2'])) {

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (!$correo) {
        die("Correo no válido.");
    }

    if ($password === $password2) {

        $user = new UserModel();

        try {
            if (!$user->getByEmail($correo)) {

                // Insertar usuario
                $userData = $user->create($nombre, $apellido, $correo, $password);

                if ($userData !== false) {

                    if ($user->getByEmail($correo)) {

                        $userData = $user->getByEmail($correo);
                        // Guardar datos en sesiones individuales
                        $_SESSION['id'] = $userData['id'];  // Asegúrate de que `id` exista en `$userData`
                        $_SESSION['nombre'] = $userData['nombre'];
                        $_SESSION['apellido'] = $userData['apellido'];
                        $_SESSION['correo'] = $userData['correo'];

                        header("Location: ../view/listadoDocumentos.php");
                    }else{
                        throw new Exception("No se pudo insertar usuario.");
                    }
                    exit; // Importante para evitar ejecución posterior
                } else {
                    throw new Exception("No se pudo insertar usuario.");
                }
            } else {
                throw new Exception("Correo electrónico ya existe.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "Las contraseñas no coinciden";
    }
} else {
    echo "Faltan datos";
}
