<?php
session_start();

// Verificación adicional para asegurar que el usuario esté correctamente logueado
if (!isset($_SESSION['nombre']) || !isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit(); // Es importante hacer un exit después de un redireccionamiento
} else {
    require '../controller/cShowListDocument.php';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../resources/css/style2.css">
    <title>Subir Documentos</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="" alt="" class="logoImg">
            <p class="logoNombre"></p>
        </div>

        <nav class="navLinks">

            <a class="linkNav" href="listadoDocumentos.php">Listado de Documentos</a>

            <a class="linkNav" href="../controller/cCerrarSessiones.php">Cerrar Session</a>

        </nav>
    </header>

    <section>
        <form action="../controller/cCreateDocument.php" class="fmlrLogin" enctype="multipart/form-data" method="post">
            <h2 class="tituloWraper">Subir Documentos</h2>
            <input type="text" name="usuario_id" hidden value="<?php echo $_SESSION['id']; ?>">
            <div class="campoForm">
                <label for="documento" class="lbForm">Seleccionar Documento (Word, PDF, Excel)</label>
                <input id="documento" name="documento" type="file" accept=".doc,.pdf,.xlsx" class="ip" required>
            </div>
            <div class="campoBtns">
                <input type="submit" value="Subir Documento" class="btnEnviar">
            </div>
        </form>
    </section>

</body>

</html>

</body>

</html>