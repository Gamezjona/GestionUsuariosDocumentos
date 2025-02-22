<?php

require_once '../model/UserModel.php';
session_start(); // Se recomienda iniciar la sesión al principio

if (isset($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['password'], $_POST['user_id'])) {

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $id = $_POST['user_id'];

    if (!$correo) {
        die("Correo no válido.");
    }

    $user = new UserModel();

    try {
        if ($user->getByEmail($correo)) {

            if ($user->update($id, $nombre, $apellido, $correo, $password)) {
                header("Location: ../view/usuarios.php");
            }
        } else {
            throw new Exception("Correo electrónico no existe.");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "Faltan datos";
}
