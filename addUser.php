<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol = "";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
    $Rol = recuperaRol(conectDB());
    if($Rol!="administrador"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
  }
  else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Añadir usuario | Sistema de Inventario</title>
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
    <h3>Añadir usuario</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="addCuenta.php" method="get" onsubmit=" return validaFrm()">
      Ingresa el nombre: <input type="text" id="txtNombre" name="txtNombre" class="form-control"><br>
      Ingresa el nombre de usuario: <input type="text" id="txtUsuario" name="txtUsuario" class="form-control"><br>
      Correo electronico: <input type="email" id="txtEmail" name="txtEmail" class="form-control"><br>
      Contraseña: <input type="password" id="txtPwd" name="txtPwd" class="form-control"><br>
      Confirma la contraseña del usuario: <input type="password" id="txtRePwd" name="txtRePwd" class="form-control" ><br>
      Indicio para recuperar la contraseña: <input type="text" id="txtIndicio" name="txtIndicio" class="form-control"><br> 
      Selecciona el rol:
      <select name="idRol" class="form-select" aria-label="Default select example">
                    <?php
                        $qry = "select nameRol,idRol from Roles";
                        $res = mysqli_query(conectDB(),$qry);
                        while($datosRol = mysqli_fetch_object($res)){
                            echo "<option style='text-transform:capitalize' value='".$datosRol->idRol."'>".$datosRol->nameRol."</option>";
                        }
                    ?>
                </select>
                <br><br>
      <input type="submit" value="Registrame" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
        </div>
    </div>
</div>
</body>
</html>