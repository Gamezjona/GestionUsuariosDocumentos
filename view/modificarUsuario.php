<?php
if (empty($_GET['user_id'])) {
  header("Location: usuarios.php");
}else{
  require '../controller/cShowListUser.php';

  $data = verUsuario($_GET['user_id']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modificar Usuario</title>
  <link rel="stylesheet" href="../resources/css/style2.css" />
  <script src="../resources/js/sweetalert2@11.js"></script>
</head>

<body>
  <header>
    <div class="logo">
      <img src="" alt="" class="logoImg" />
      <p class="logoNombre"></p>
    </div>
    <nav class="navLinks">
        <a class="linkNav" href="usuarios.php">Regresar</a>
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
    <form action="../controller/cUpdateUser.php" method="post">
      <h2 >Modificar Usuario</h2>

      <input type="hidden" name="user_id" value="<?php echo $data['id']; ?>" />

      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Nombre(s)</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nuevo dato" value="<?php echo $data['nombre']; ?>">
      </div>
      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Apellidos</label>

        <input type="text" id="apellido" name="apellido" placeholder="Ingrese el nuevo dato" value="<?php echo $data['apellido']; ?>">
      </div>

      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Correo Electronico</label>

        <input type="email" id="correo" name="correo" placeholder="Ingrese el nuevo dato" value="<?php echo $data['correo']; ?>">
      </div>

      <input
        type="password"
        id="password"
        name="password"
        placeholder="Nueva contraseña"
        value="<?php echo $data['contrasena']; ?>" />

      <button type="submit" class="btnModificar">Modificar Usuario</button>
    </form>
  </section>
</body>

</html>