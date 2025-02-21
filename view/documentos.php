<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Subir Documentos</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="" alt="" class="logoImg">
            <p class="logoNombre"></p>
        </div>

        <nav class="navLinks">
            <button class="btnNavLink">
                <a class="linkNav" href="listadoDocumentos.html">Listado de Documentos</a>
            </button>
        </nav>
    </header>

    <div class="wrapper">
        <form action="" class="fmlrLogin" enctype="multipart/form-data">
            <div class="campoForm">
                <label for="documento" class="lbForm">Seleccionar Documento (Word, PDF, Excel)</label>
                <input id="documento" name="documento" type="file" accept=".doc,.pdf,.xlsx" class="ip" required>
            </div>
            <div class="campoBtns">
                <input type="submit" value="Subir Documento" class="btnEnviar">
            </div>
        </form>
    </div>
</body>

</html>



