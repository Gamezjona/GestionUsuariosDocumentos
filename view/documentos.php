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
    <script src="../resources/js/sweetalert2@11.js"></script>
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

    <?php
    if (isset($_SESSION['exito']) || isset($_SESSION['error'])) {
        // Verificar si existe el mensaje de éxito
        if (isset($_SESSION['exito'])) {
            $icon = "success";
            $message = $_SESSION['exito'];
            unset($_SESSION['exito']); // Limpiar el mensaje después de mostrarlo
        }
        // Verificar si existe el mensaje de error
        elseif (isset($_SESSION['error'])) {
            $icon = "error";
            $message = $_SESSION['error'];
            unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo
        }
    ?>
        <script>
            Swal.fire({
                position: "top-end",
                icon: "<?php echo $icon; ?>",
                title: "<?php echo addslashes($message); ?>",
                showConfirmButton: false,
                timer: 2800
            });
        </script>
    <?php
    }
    ?>

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