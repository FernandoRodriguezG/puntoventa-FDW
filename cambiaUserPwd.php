<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());
    if($rol != "administrador"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}

if(!isset($_GET['id'])){
  header("location:http://localhost/FDW21/proyecto/users.php");
}
if(isset($_GET['txtNueva']) && isset($_GET['txtReNueva']) && isset($_GET['id'])){
    if($_GET['txtNueva']=="" || $_GET['txtReNueva']==""){
        $error = "Por favor llena todos los campos para el cambio de contraseña";
    }
    if($_GET['txtNueva']!=$_GET['txtReNueva']){
        $error="Contraseñas no coinciden.";
    }
    if($error==""){
        $qry = "update usuarios set Password='".$_GET['txtNueva']."' where idUsuario=".$_GET['id'];
        $rs = mysqli_query(conectDB(),$qry);
        $error="Contraseña actualizada";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Cambio de contraseña | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaPwd(){
        if(document.getElementById("txtNueva").value == "" || 
          document.getElementById("txtReNueva").value == "" )
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
            <h3>Cambio de contraseña a un usuario</h3>
            <div class="alertMsg"><?php if($error!="") echo $error;?></div>
            <?php 
                $consulta = "select u.User from usuarios as u where u.idUsuario=".$_GET['id'];
                $rs = mysqli_query(conectDB(),$consulta);
                $profile = mysqli_fetch_object($rs);
                echo "<div class='fw-bold fs-5'>Usuario a editar:</div>";
                echo $profile->User."<br>";          
            ?><br>
            <form action="cambiaUserPwd.php" method="get" onsubmit=" return validaPwd()">
                Nueva contraseña: <input type="password" id="txtNueva" name="txtNueva" class="form-control">
                Confirma la nueva contraseña: <input type="password" id="txtReNueva" name="txtReNueva" class="form-control"><br>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" value="Cambiar contraseña" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
</body>
</html>