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
    <title>Listado de Documentos</title>
    <style>
        /* Botones interactivos */
        .btnDescargar {
            padding: 10px 14px;
            margin-right: 10px;
            background-color: #a2ff00;
            border: none;
            border-radius: 8px;
            color: #333;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btnDescargar:hover {
            background-color: #8dd700;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }


        .btnView {
            padding: 10px 14px;
            margin-right: 10px;
            background-color: rgb(148, 242, 220);
            border: none;
            border-radius: 8px;
            color: #333;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btnView:hover {
            background-color: rgb(56, 102, 91);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="" alt="" class="logoImg">
            <p class="logoNombre"></p>
        </div>

        <nav class="navLinks">

            <a class="linkNav" href="../index.html">Regresar</a>
            <a class="linkNav" href="modificarUsuario.php?user_id=<?php echo $_SESSION['id']; ?>">Actualizar usuario</a>

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
        <div class="wrapper">
            <h2 class="tituloWraper">Documentos Subidos <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>

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
                                        <a class="btnView" href="../controller/cViewDocument.php?document_id=<?php echo $document['id']; ?>&nombreDocument=<?php echo urlencode($document['nombre']); ?>">
                                            View
                                        </a>
                                        <a class="btnDescargar" href="../controller/cDownloadDocument.php?document_id=<?php echo $document['id']; ?>&nombreDocument=<?php echo urlencode($document['nombre']); ?>">
                                            Descargar
                                        </a>
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