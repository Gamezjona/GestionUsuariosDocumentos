<?php

require '../model/DocumentModel.php';

function verDocumentos($id_user) {
    $document = new DocumentModel();

    // Ejecutar solo una vez el método readAll y retornar el resultado
    $documentos = $document->readAll($id_user);

    // Verificar si se encontraron documentos
    return $documentos !== false ? $documentos : false;
}

