<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(!isset($_SESSION['idU']) || !isset($_SESSION['nombre'])){
    
    header("location:http://localhost/FDW21/proyecto/index.php");
}
else{
    $rol = recuperaRol(conectDB());
}
if(isset($_GET['txtActual']) && isset($_GET['txtNueva']) && isset($_GET['txtReNueva']) && isset($_GET['txtInd'])){
    if($_GET['txtActual']=="" || $_GET['txtNueva']=="" || $_GET['txtReNueva']=="" || $_GET['txtInd']==""){
        $error = "Por favor llena todos los campos para el cambio de contraseña";
    }
    if($_GET['txtNueva']!=$_GET['txtReNueva']){
      $error="Contraseñas no coinciden.";
  }
    if($error==""){
        $qry = "update usuarios set Password='".$_GET['txtNueva']."' where idUsuario=".$_SESSION['idU'] . " and KeyPwd='".$_GET['txtInd']."'";
        $rs = mysqli_query(conectDB(),$qry);
        $error="Contraseña actualizada";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Cambiar contraseña | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaPwd(){
        if(document.getElementById("txtActual").value == "" ||
          document.getElementById("txtNueva").value == "" || 
          document.getElementById("txtReNueva").value == "" ||
          document.getElementById("txtInd").value == "")
        {
          alert("Todos los campos son requeridos");
          return false;
        }
        else 
        {
          if(document.getElementById("txtNueva").value != document.getElementById("txtReNueva").value){
            document.getElementById("msgError").innerHTML="Las contraseñas no coinciden";
            document.getElementById("txtPwd").value ="";
            document.getElementById("txtRePwd").value="";
            return false;
          } 
          else{
            return true;
          }
        }
    }
  </script>
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
            <h3>Cambio de contraseña</h3>
            <div><?php if($error!="") echo $error;?></div>
            <form action="changePwd.php" method="get" onsubmit=" return validaPwd()">
                Contraseña actual: <input type="password" id="txtActual" name="txtActual" class="form-control"><br>
                Nueva contraseña: <input type="password" id="txtNueva" name="txtNueva" class="form-control"><br>
                Confirma tu nueva contraseña: <input type="password" id="txtReNueva" name="txtReNueva" class="form-control"><br>
                Ingresa tu indicio de la antigua contraseña: <input type="text" id="txtInd" name="txtInd" class="form-control"><br>
                <input type="submit" value="Cambiar contraseña" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
</body>
</html>