<?php

require_once '../model/UserModel.php';
session_start(); // Se recomienda iniciar la sesión al principio

if (isset($_POST['correo'], $_POST['password'])) {

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (!$correo) {
        throw new Exception("Correo no válido.");
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

            if($userData['correo'] != "admin@main.com"){
                header("Location: ../view/listadoDocumentos.php");
            }else{
                header("Location: ../view/usuarios.php");
            }
            exit; // Importante para evitar ejecución posterior
        } else {
            throw new Exception("Usuario o contraseña incorrectos.");
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../view/login.php");
    }

} else {
    $_SESSION['error'] = "Faltan datos.";
    header("Location: ../view/login.php");
}
