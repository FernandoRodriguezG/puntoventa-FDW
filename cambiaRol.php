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
    if(isset($_GET['id']) && isset($_GET['idRol'])){
        //Se actualiza el estado
        $qry = "update usuarios set idRol='".$_GET['idRol']."' where idUsuario=".$_GET['id'];
        $rs = mysqli_query(conectDB(),$qry);
        $error ="Rol actualizado";
    }
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
if(!isset($_GET['id'])){
    header("location:http://localhost/FDW21/proyecto/users.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Cambio de rol | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
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
            <h3>Cambio de rol</h3>
            <div>
            <div><?php if($error!="")echo $error;?></div>
            <?php 
                $consulta = "select U.Name as Nombre, R.nameRol from usuarios as U inner join roles as R on U.idRol=R.idRol where U.idUsuario=".$_GET['id'];
                $resultado = mysqli_query(conectDB(),$consulta);
                $datosUsr = mysqli_fetch_object($resultado);
                echo "<div class='fw-bold fs-5'>Usuario seleccionado:</div>".$datosUsr->Nombre."<br>";
                echo "<div class='fw-bold fs-5'>Rol actual:</div><div  style='text-transform:capitalize'>".$datosUsr->nameRol."</div><br>";
            ?>
            </div>
            <form method="get" action="cambiaRol.php">
                Nuevo rol:
                <select name="idRol" class="form-select" aria-label="Default select example" style="text-transform:capitalize;">
                    <?php
                        $qry = "select nameRol,idRol from Roles";
                        $res = mysqli_query(conectDB(),$qry);
                        while($datosRol = mysqli_fetch_object($res)){
                            echo "<option style='text-transform:capitalize' value='".$datosRol->idRol."'>".$datosRol->nameRol."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <br>
                <input type="submit" value="Cambiar Rol" class="btn btn-info">
                <br>
            </form>
        </div>
    </div>
</div>
</body>
</html>