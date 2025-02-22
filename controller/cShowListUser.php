<?php

require '../model/UserModel.php';

function verUsuarios() {

    $user = new UserModel();
    
    // Ejecutar solo una vez el método readAll y retornar el resultado
    $users = $user->getAll();

    // Verificar si se encontraron documentos
    return $users != false ? $users : false;
}


function verUsuario($id){
    $user = new UserModel();

    $data = $user->getById($id);

    // Verificar si se encontraron datos
    return $data != false ? $data : false;
}

