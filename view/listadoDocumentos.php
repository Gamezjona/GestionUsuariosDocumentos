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
    <title>Listado de Documentos</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="" alt="" class="logoImg">
            <p class="logoNombre"></p>
        </div>

        <nav class="navLinks">

            <a class="linkNav" href="../index.html">Regresar</a>

            <a class="linkNav" href="../controller/cCerrarSessiones.php">Cerrar Session</a>
        </nav>
    </header>

    <section>
        <div class="wrapper">
            <h2 class="tituloWraper">Documentos Subidos  <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>

            <div class="table-container">
                <table class="tablaWraper">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $list = verDocumentos($_SESSION['id']); // Asegúrate de pasar el ID del usuario correctamente

                        if ($list != false) {
                            foreach ($list as $document) {  // Recorremos el array de documentos
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($document['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($document['tipo_archivo']); ?></td>
                                    <td>
                                        <a class="btnEliminar" href="../controller/cDeleteDocument.php?document_id=<?php echo $document['id']; ?>&nombreDocument=<?php echo urlencode($document['nombre']); ?>">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>

                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>No se encontraron documentos.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <button class="btnSubir" onclick="location.href='documentos.php'">Subir Documento</button>
        </div>
    </section>
</body>

</html>