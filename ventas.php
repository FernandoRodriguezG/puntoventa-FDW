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
            $error="La Venta no pudo ser eliminada";
        } else if($_GET['err']==1){
            //Se elimino el registro
            $error="La Venta se elimino correctamente";
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
  <title>Ventas | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function eliminaVenta(){
        if(confirm("¿Estas seguro de querer eliminar la venta? Se podrian perder algunos datos")){
            return confirm("Todo lo relacionado a la venta se eliminara, ¿Desea continuar?");
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
            <h3>Historial de ventas</h3>
            <a class="btn btn-primary" href="nuevaVenta.php" role="button">Nueva venta</a>
            <?php
            //Listado de usuarios para mostrar al administrador
            $cons = "select V.idVenta, V.Fecha, V.precioTotal,V.numProductos, C.Nombre from ventas as V inner join clientes as C on V.idCliente=C.idCliente";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Cliente</th>";
                echo "<th scope='col'>Fecha</th>";
                echo "<th scope='col'>Cantidad de Articulos</th>";
                echo "<th scope='col'>Total pagado</th>";  
                echo "<th scope='col'></th>"; 
                if($Rol=="administrador"){
                    echo "<th scope='col'></th>"; 
                }        
                echo "</tr>";
                echo "</thead>";
                while($dUser = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dUser["Nombre"]."</td>";
                        echo "<td>".$dUser["Fecha"]."</td>";
                        echo "<td>".$dUser["numProductos"]."</td>";
                        echo "<td>$".$dUser["precioTotal"]."</td>";
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='detallesVenta.php?idV=".$dUser["idVenta"]."' role='button'>Detalles de la venta</a>";
                        echo "</td>";
                        if($Rol=="administrador"){
                            echo "<td>";
                            echo "<a class='btn btn-danger' onclick='return eliminaVenta()' href='eliminaVenta.php?idV=".$dUser["idVenta"]."' role='button'>Elimina Venta</a>";
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