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
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
if(!isset($_GET['id'])){
    header("location:http://localhost/FDW21/proyecto/clientes.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Compras de cliente | Sistema de Inventario</title>
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
      menu($Rol);
    ?>
        <div class="col py-3">
            
            <?php
            $cons = "select C.Nombre from clientes as C where C.idCliente=".$_GET['id'];
            $res = mysqli_query(conectDB(),$cons);
            $name = mysqli_fetch_array($res);
            echo "<h3>Historial de ventas del cliente ".$name['Nombre']."</h3>";
            $ventas = "select V.idVenta, V.Fecha, V.precioTotal, V.numProductos from ventas as V where V.idCliente=".$_GET['id'];
            $rs = mysqli_query(conectDB(),$ventas);
            if(mysqli_num_rows($rs)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Fecha</th>";
                echo "<th scope='col'>Cantidad de Articulos</th>";
                echo "<th scope='col'>Total pagado</th>";  
                echo "<th scope='col'></th>";           
                echo "</tr>";
                echo "</thead>";
                while($dUser = mysqli_fetch_array($rs)){
                    echo "<tr>";
                        echo "<td>".$dUser["Fecha"]."</td>";
                        echo "<td>".$dUser["numProductos"]."</td>";
                        echo "<td>$".$dUser["precioTotal"]."</td>";
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='detallesVenta.php?idV=".$dUser["idVenta"]."' role='button'>Detalles de la venta</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                    echo "</table>";
            }else{
                echo "ESTE CLIENTE AÚN NO TIENE COMPRAS REGISTRADAS";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>