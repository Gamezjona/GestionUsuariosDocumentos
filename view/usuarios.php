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
  <script src="../resources/js/sweetalert2@11.js"></script>
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
                      <a class="btnEliminar" href="javascript:void(0);" onclick="confirmDelete(<?php echo $value['id']; ?>)">Dar Baja</a>
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

<script>
  function confirmDelete(userId) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: '¡Si eliminas este usuario tambien eliminaras todos sus documetos!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminarlo',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Si el usuario confirma, redirigimos al enlace de eliminación
        window.location.href = '../controller/cDeleteUser.php?user_id=' + userId;
      }
    });
  }
</script>

</html>