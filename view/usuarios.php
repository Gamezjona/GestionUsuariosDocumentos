<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../resources/css/style.css" />
    <title>Usuarios</title>
  </head>

  <body>
    <header>
        <div class="logo">
            <img src="" alt="" class="logoImg">
            <p class="logoNombre"></p>
        </div>
        <nav class="navLinks">
            <button class="btnNavLink">
                <a class="linkNav" href="../index.html">Regresar</a>
                <a class="linkNav" href="index.php">Regresar</a>
            </button>
        </nav>
    </header>

    <div>
      <h2>Listado de Usuarios</h2>
      <table class="tablaUsuarios">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Ian Mio</td>
            <td>ian@amor.tu</td>
            <td>
              <a class="btnModificar" href="modificarUsuario.html">Modificar</a>
              <button class="btnBaja">Dar Baja</button>
            </td>
          </tr>
          <tr>
            <td>Usuario 2</td>
            <td>2@usuario.com</td>
            <td>
              <a class="btnModificar" href="modificarUsuario.html">Modificar</a>
              <button class="btnBaja">Dar Baja</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>
