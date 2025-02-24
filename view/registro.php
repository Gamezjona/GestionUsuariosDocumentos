<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="../resources/css/style2.css" />
  <script src="../resources/js/sweetalert2@11.js"></script>

  <title>Registro</title>
</head>

<body class="bodyRegistro">
  <header>
    <div class="logo">
      <img src="" alt="" class="logoImg" />
      <p class="logoNombre"></p>
    </div>

    <nav class="navLinks">
      <a class="linkNav" href="../index.html">Inicio</a>
    </nav>
  </header>

  <?php
  session_start();
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
    <form action="../controller/cCreateUser.php" method="post">
      <h2 class="tituloForm">Registro</h2>
      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Nombre(s)</label>

        <input id="ipEmail" name="nombre" type="text" required />
      </div>
      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Apellidos</label>

        <input id="ipEmail" name="apellido" type="text" required />
      </div>

      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Correo Electronico</label>

        <input id="ipEmail" name="correo" type="email" required />
      </div>

      <div class="campoForm">
        <label for="ipPwd" class="lbForm">Contraseña</label>

        <input
          id="ipPwd"
          name="password"
          type="password"

          required />
      </div>
      <div class="campoForm">
        <label for="ipPwd" class="lbForm">Comfirmar Contraseña</label>

        <input
          id="ipPwd2"
          name="password2"
          type="password"

          required />
      </div>
      <div class="campoBtns">
        <label for="" class="lbBtns">
          <input type="submit" value="Enviar" class="btnEnviar" />
        </label>
      </div>
    </form>
  </section>
</body>

</html>