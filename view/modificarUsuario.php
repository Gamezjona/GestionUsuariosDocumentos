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
  <link rel="stylesheet" href="../resources/css/style.css" />
</head>

<body>
  <header>
    <div class="logo">
      <img src="" alt="" class="logoImg" />
      <p class="logoNombre"></p>
    </div>
    <nav class="navLinks">
      <button class="btnNavLink">
        <a class="linkNav" href="usuarios.php">Regresar</a>
      </button>
    </nav>
  </header>

  <div class="container">
    <h1>Modificar Usuario</h1>

    <form action="../controller/cUpdateUser.php" method="POST">
      
      <input type="hidden" name="user_id" value="<?php echo $data['id']; ?>" />

      <label for="nombre">Nombre:</label>

      <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nuevo dato" value="<?php echo $data['nombre']; ?>">

      <label for="apellido">Apellido:</label>
      <input type="text" id="apellido" name="apellido" placeholder="Ingrese el nuevo dato" value="<?php echo $data['apellido']; ?>">

      <label for="email">Correo Electrónico:</label>
      <input type="email" id="correo" name="correo" placeholder="Ingrese el nuevo dato" value="<?php echo $data['correo']; ?>">

      <label for="password">Contraseña:</label>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="Nueva contraseña"
        value="<?php echo $data['contrasena']; ?>" />

      <button type="submit" class="btnModificar">Modificar Usuario</button>
    </form>
  </div>

  <script src="script.js"></script>
</body>

</html>