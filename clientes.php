<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
    $Rol = recuperaRol(conectDB());
    if($Rol==""||$Rol=="Proveedor"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
    if(isset($_GET['err'])){
        if($_GET['err']==0){
            //NO se pudo eliminar el registro
            $error="El cliente no pudo ser eliminado, verifique no haya ventas asociadas al cliente";
        } else if($_GET['err']==1){
            //Se elimino el registro
            $error="El cliente se elimino correctamente";
        }
    }
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Clientes | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function eliminaCliente(){
        if(confirm("¿Estas seguro de querer eliminar el cliente? Se podrian perder algunos datos")){
            return confirm("Todo lo relacionado al cliente se eliminara, ¿Desea continuar?");
        }
        else{
            return false;
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
      menu($Rol);
    ?>
        <div class="col py-3">
            <h3>Clientes</h3>
            <div class="alertMsg"><?php if($error!="")echo $error;?></div>
            <a class="btn btn-primary" href="nuevoCliente.php" role="button">Añadir Cliente</a>
            <?php
            //Listado de usuarios para mostrar al administrador
            $cons = "select clientes.* from clientes";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Dirección</th>";
                echo "<th scope='col'>Telefono</th>";
                echo "<th scope='col'>Correo electronico</th>";  
                echo "<th scope='col'></th>";  
                echo "<th scope='col'></th>"; 
                echo "<th scope='col'></th>";          
                echo "</tr>";
                echo "</thead>";
                while($dCli = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dCli["Nombre"]."</td>";
                        echo "<td>".$dCli["Direccion"]."</td>";
                        echo "<td>".$dCli["Telefono"]."</td>";
                        echo "<td>".$dCli["Correo"]."</td>";
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='verComprasCliente.php?id=".$dCli["idCliente"]."' role='button'>Ver compras del cliente</a>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='editCliente.php?id=".$dCli["idCliente"]."' role='button'>Editar cliente</a>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a class='btn btn-danger' onclick='return eliminaCliente()' href='eliminaCliente.php?id=".$dCli["idCliente"]."' role='button'>Eliminar cliente</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                    echo "</table>";
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>