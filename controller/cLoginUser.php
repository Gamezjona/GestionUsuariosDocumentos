<?php

require_once '../model/UserModel.php';
session_start(); // Se recomienda iniciar la sesión al principio

if (isset($_POST['correo'], $_POST['password'])) {

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (!$correo) {
        die("Correo no válido.");
    }

    $user = new UserModel();

    try {
        $userData = $user->getByEmail($correo);

        if ($userData !== false && $password == $userData['contrasena']) {
            // Guardar datos en sesiones individuales
            $_SESSION['id'] = $userData['id'];  // Asegúrate de que `id` exista en `$userData`
            $_SESSION['nombre'] = $userData['nombre'];
            $_SESSION['apellido'] = $userData['apellido'];
            $_SESSION['correo'] = $userData['correo'];

            header("Location: ../view/listadoDocumentos.php");
            exit; // Importante para evitar ejecución posterior
        } else {
            throw new Exception("Usuario o contraseña incorrectos.");
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }

} else {
    echo "Faltan datos.";
}
