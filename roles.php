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
    if(isset($_GET['nuevoRol'])){
        //Se actualiza el estado
        $qry = "insert into roles (nameRol) value ('".$_GET['nuevoRol']."')";
        $rs = mysqli_query(conectDB(),$qry);
        $error ="Rol añadido";
    }
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Roles | Sistema de Inventario</title>
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
            <h3>Roles</h3>
            <div>
            <div class="alertMsg"><?php if($error!="")echo $error;?></div>
            <?php 
                $consulta = "select * from roles as R";
                $resultado = mysqli_query(conectDB(),$consulta);
                echo "Roles actuales:";
                if(mysqli_num_rows($resultado)){
                    echo "<table class='table table-success table-striped' style='text-transform:capitalize'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Rol</th>";
                    echo "</tr>";
                    echo "</thead>";
                    while($infoRoles = mysqli_fetch_array($resultado)){
                        echo "<tr>";
                        echo "<td>".$infoRoles["nameRol"]."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?>
            </div>
            <form method="get" action="roles.php">
                Nombre del nuevo rol: 
                <input type="text" id="nuevoRol" name="nuevoRol" class="form-control">
                <br>
                <input type="submit" value="Añadir Rol" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
                <br>
            </form>
        </div>
    </div>
</div>
</body>
</html>