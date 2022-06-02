<?php
include("menu.php");
include("encabezado.php");
$Rol = "";
$error = "";
if(isset($_GET['err']) && $_GET['err']!=""){
  switch($_GET['err']){
    case 1:
      $error = "No se recibieron datos del formulario";
      break;
    case 2:
      $error = "No pueden existir campos vacios, todos los datos son necesarios";
      break;
    case 3:
      $error = "No coinciden las contraseñas";
      break;
    case 4:
      $error = "El usuario se registro correctamente";
      break;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Registro | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
</head>
<body>
<?php
  encabezado();
?>
<div class="container-fluid">
    <div class="row flex-nowrap">
    <?php
      menu($Rol);
    ?>
    <div class="col py-3">
    <h3>Crea tu cuenta para ingresar al sistema</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="creaCuenta.php" method="get" onsubmit=" return validaFrm()">
      Nombre: <input type="text" id="txtNombre" name="txtNombre" class="form-control"><br>
      Ingresa tu nombre de usuario: <input type="text" id="txtUsuario" name="txtUsuario" class="form-control"><br>
      Correo electronico: <input type="email" id="txtEmail" name="txtEmail" class="form-control"><br>
      Contraseña: <input type="password" id="txtPwd" name="txtPwd" class="form-control"><br>
      Confirma tu contraseña: <input type="password" id="txtRePwd" name="txtRePwd" class="form-control" ><br>
      Indicio para recuperar tu contraseña: <input type="text" id="txtIndicio" name="txtIndicio" class="form-control"><br> 
      <input type="submit" value="Registrame" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
    ¿Ya tienes una cuenta?<a href="login.php">Ingresar</a>
        </div>
    </div>
</div>
</body>
</html>