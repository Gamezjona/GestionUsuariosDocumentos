<?php

require_once '../model/UserModel.php';
session_start(); // Se recomienda iniciar la sesión al principio

if (isset($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['password'], $_POST['user_id'])) {

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $id = $_POST['user_id'];

    try {

        if (!$correo) {
            throw new Exception("Correo no válido.");
        }

        $user = new UserModel();


        if ($user->getByEmail($correo)) {

            if ($user->update($id, $nombre, $apellido, $correo, $password)) {

                if ($_SESSION['correo'] == 'admin@main.com') {
                    $_SESSION['exito'] = "Usuario modificado exitosamente.";
                    header("Location: ../view/usuarios.php");
                } else {
                    $userData = $user->getByEmail($correo);

                    if ($userData !== false) {
                        $_SESSION['id'] = $userData['id'];  // Asegúrate de que `id` exista en `$userData`
                        $_SESSION['nombre'] = $userData['nombre'];
                        $_SESSION['apellido'] = $userData['apellido'];
                        $_SESSION['correo'] = $userData['correo'];
                    }
                    $_SESSION['exito'] = "Tu usuario modificado exitosamente.";
                    header("Location: ../view/listadoDocumentos.php");
                }
            }
        } else {
            throw new Exception("Correo electrónico no existe.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../view/modificarUsuario.php?user_id=$id");
    }
} else {
    $_SESSION['error'] = "Faltan datos";
    header("Location: ../view/modificarUsuario.php?user_id=$id");
}
