<?php
session_start();

// Verificación adicional para asegurar que el usuario esté correctamente logueado
if ($_SESSION['nombre'] != "Admin") {
  header("Location: ../index.html");
  exit(); // Es importante hacer un exit después de un redireccionamiento
} else {
  require '../controller/cShowListUser.php';
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="../resources/css/style2.css" />
  <title>Usuarios</title>
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
      <h2 class="tituloWraper">Lista Usuarios <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>

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

            $users = verUsuarios();
            if ($users != false) {


              foreach ($users as $value) {
            ?>
                <tr>
                  <td><?php echo $value['nombre']; ?></td>
                  <td><?php echo $value['correo']; ?></td>
                  <td>
                    <?php if ($value['correo'] != "admin@main.com") {  ?>
                      <a class="btnModificar" href="modificarUsuario.php?user_id=<?php echo $value['id']; ?>">Modificar</a>
                      <a class="btnEliminar" href="../controller/cDeleteUser.php?user_id=<?php echo $value['id']; ?>">Dar Baja</a>
                    <?php   } else {
                      echo "sin acciones";
                    } ?>
                  </td>
                </tr>
            <?php }
            } else {
              echo "<tr><td colspan='3'>No se encontraron Usuarios.</td></tr>";
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>