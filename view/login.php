<?php

session_start();

if(isset($_SESSION['nombre'])){

  if($_SESSION['nombre'] != "Admin"){
    header("Location: ../view/listadoDocumentos.php");
  }else{
    header("Location: ../view/usuarios.php");
  }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../resources/css/style.css">
    <title>Long in</title>
  </head>

  <body>
    <header>
      <div class="logo">
        <img src="" alt="" class="logoImg" />
        <p class="logoNombre"></p>
      </div>

        <nav class="navLinks">
            <button class="btnNavLink">
                <a class="linkNav" href="../index.html">Inicio</a>
            </button>
        </nav>
    </header>

    <form action="../controller/cLoginUser.php" class="fmlrLogin" method="post">
      <div class="campoForm">
        <label for="ipEmail" class="lbForm">Correo Electronico</label>

        <input id="ipEmail" name="correo" type="email" class="ip" required />
      </div>

      <div class="campoForm">
        <label for="ipPwd" class="lbForm">Contraseña</label>

        <input id="ipPwd" name="password" type="password" class="ip" required />
      </div>
      <div class="campoBtns">
        <label for="" class="lbBtns">
          <input type="submit" value="Enviar" class="btnEnviar" />
        </label>
      </div>
      <div class="RecuperarPwd">
        <label for="" class="RecuperarPwd">
          <a href="#" class="linkRcpPwd">Olvide mi Contraseña</a>
        </label>
      </div>
      <div class="campoForm">
        <label class="lbForm">
          este servira para saber si hay un error al registrar los datos
        </label>
      </div>
    </form>
  </body>
</html>
