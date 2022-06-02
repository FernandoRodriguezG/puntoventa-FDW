<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());
    if($rol == "Vendedor"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
    if(isset($_GET['err'])){
        if($_GET['err']==0){
            //NO se pudo eliminar el registro
            $error="El fabricante no pudo ser eliminado, verifique no haya productos asociados al fabricante";
        } else if($_GET['err']==1){
            //Se elimino el registro
            $error="El fabricante se elimino correctamente";
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
  <title>Fabricantes | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function eliminaFabricante(){
        if(confirm("¿Estas seguro de querer eliminar el fabricante? Se podrian perder algunos datos")){
            return confirm("Todo lo relacionado al fabricante se eliminara, ¿Desea continuar?");
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
      menu($rol);
    ?>
        <div class="col py-3">
            <h3>Listado de Fabricantes</h3>
            <div class="alertMsg"><?php if($error!="")echo $error;?></div>
            <?php
            if($rol=="Proveedor" || $rol=="administrador"){
            echo "<a class='btn btn-primary' href='nuevoFabricante.php' role='button'>Añadir fabricante</a>";
            }
            
            //Listado de usuarios para mostrar al administrador
            $cons = "select fabricantes.* from fabricantes";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Dirección</th>";
                echo "<th scope='col'>Telefono</th>";
                echo "<th scope='col'>Correo electronico</th>";  
                if($rol=="Proveedor" || $rol=="administrador"){
                echo "<th scope='col'></th>";  
                echo "<th scope='col'></th>";  
                echo "<th scope='col'></th>";           
                }
                echo "</tr>";
                echo "</thead>";
                while($dFab = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dFab["Nombre"]."</td>";
                        echo "<td>".$dFab["Direccion"]."</td>";
                        echo "<td>".$dFab["Telefono"]."</td>";
                        echo "<td>".$dFab["Correo"]."</td>";
                        if($rol=="Proveedor" || $rol=="administrador"){
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='verProductosFab.php?id=".$dFab["idFabricante"]."' role='button'>Ver productos del fabricante</a>";
                        echo "</td>";

                        echo "<td>";
                        echo "<a class='btn btn-primary' href='editarFab.php?id=".$dFab["idFabricante"]."' role='button'>Editar fabricante</a>";
                        echo "</td>";

                        echo "<td>";
                        echo "<a class='btn btn-danger' onclick='return eliminaFabricante()' href='eliminaFabricante.php?id=".$dFab["idFabricante"]."' role='button'>Eliminar Fabricante</a>";
                        echo "</td>";
                        }
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