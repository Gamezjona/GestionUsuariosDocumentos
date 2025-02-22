<?php

require_once '../model/UserModel.php';
session_start();

if (isset($_GET['user_id'])) {
    $usuario_id = $_GET['user_id'];

    $newUser = new UserModel();


    if($newUser->delete($_GET['user_id'])){
        header("Location: ../view/usuarios.php");
    }

    
} else {
    echo "Faltan datos en el formulario.";
}
