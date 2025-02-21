<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Listado de Documentos</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="" alt="" class="logoImg">
            <p class="logoNombre"></p>
        </div>

        <nav class="navLinks">
            <button class="btnNavLink">
                <a class="linkNav" href="index.html">Regresar</a>
            </button>
        </nav>
    </header>

    <div class="wrapper">
        <h2>Documentos Subidos</h2>
        <table class="tablaDocumentos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Documento1.pdf</td>
                    <td>PDF</td>
                    <td><button class="btnEliminar">Eliminar</button></td>
                </tr>
                <tr>
                    <td>Documento2.docx</td>
                    <td>Word</td>
                    <td><button class="btnEliminar">Eliminar</button></td>
                </tr>
             
            </tbody>
        </table>
    </div>
</body>

</html>
