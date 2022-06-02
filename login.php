<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(isset($_GET['txtUsuario']) && isset($_GET['txtPwd']))
    {
        if( $_GET['txtUsuario'] != "" &&  $_GET['txtPwd'] != "")
        {
            $conn = conectDB();
            $qry = "select idUsuario,Name,Status from usuarios where User='". $_GET['txtUsuario']."' and Password='".$_GET['txtPwd']."'";
            $rs=mysqli_query($conn,$qry);
            if(mysqli_num_rows($rs)>0)//Usuario existe
            {
                $datosUsuario = mysqli_fetch_array($rs);
                if($datosUsuario["Status"]!=0){
                  $_SESSION['idU'] = $datosUsuario["idUsuario"];
                  $_SESSION['nombre'] = $datosUsuario["Name"];
                  header("location:http://localhost/FDW21/proyecto/index.php");
                }
                else{
                  header("location:http://localhost/FDW21/proyecto/login.php?err=3");
                }
            }
            else//Los datos son incorrectos
            {
                $error = "Los datos no son validos";
            }
        }
    }else {
      if(isset($_GET['err'])){
        if($_GET['err']==3){
          $error="Usuario inactivo, por favor contacta a un administrador";
        }
      }
    }

?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Iniciar sesión | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
</head>
<body>
<?php
  encabezado();
?>
<div class="container-fluid">
    <div class="row flex-nowrap">
    <?php
      menu($rol);
    ?>
    <div class="col py-3">
    <h3>Iniciar sesión</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="login.php" method="get" onsubmit=" return validaLogin()">
      Ingresa tu nombre de usuario: <input type="text" id="txtUsuario" name="txtUsuario" class="form-control"><br>
      Contraseña: <input type="password" id="txtPwd" name="txtPwd" class="form-control"><br> 
      <input type="submit" value="Iniciar sesión" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form><br>
    ¿Aún no tienes una cuenta?  <a href="registrate.php">  Registrate aquí.</a>
        </div>
    </div>
</div>
</body>
</html>