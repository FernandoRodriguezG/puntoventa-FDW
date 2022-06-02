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
if(!isset($_GET['idV'])){
    header("location:http://localhost/FDW21/proyecto/ventas.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Detalles de venta | Sistema de Inventario</title>
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
            <h3>Detalles de venta</h3>
            <?php
            //Listado de usuarios para mostrar al administrador
            $cons = "Select V.Fecha, V.precioTotal,C.Nombre as nameCliente 
                from ventas as V inner join clientes as C on V.idCliente=C.idCliente where V.idVenta=".$_GET['idV'];
            $res = mysqli_query(conectDB(),$cons);
            $detVenta = mysqli_fetch_array($res);
            echo "<p class='fs-5'>Cliente: ";
            echo $detVenta['nameCliente']."<br>";
            echo "Fecha: ".$detVenta['Fecha']."<br>";
            echo "Total pagado: <b>$".$detVenta['precioTotal']."</b><br></p>";
            $ddv = "select DV.idProducto,DV.cantidad,DV.precioAdquirido,DV.Promo,DV.idPromo,P.Nombre as productName, 
            P.Modelo from detallesventa as DV inner join productos as P on DV.idProducto=P.idProducto where DV.idVenta=".$_GET['idV'];
            $detail = mysqli_query(conectDB(),$ddv);
            if(mysqli_num_rows($detail)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Imagen</th>";
                echo "<th scope='col'>Nombre articulo</th>";
                echo "<th scope='col'>Modelo</th>";
                echo "<th scope='col'>Cantidad</th>";
                echo "<th scope='col'>Precio por unidad</th>";  
                echo "<th scope='col'>Promo aplicada</th>";     
                echo "<th scope='col'>Total producto</th>";
                echo "</tr>";
                echo "</thead>";
                    while($dUser = mysqli_fetch_array($detail)){
                        echo "<tr>";
                        //inicio imagen
                            echo "<td>";
                            $qry = "select * from archivos where idProducto=".$dUser["idProducto"];
                            $ress = mysqli_query(conectDB(),$qry);
                            if(mysqli_num_rows($ress)>0){
                                //Encontro archivos
                                while($archivo = mysqli_fetch_array($ress)){
                                    echo "<img style='width:80px; height:80px' src='imagen.php?idA=".$archivo["idArchivo"]."' alt='".$archivo["Titulo"]."'>";
                                }
                            }
                            echo "</td>";
                        //Fin imagen
                            echo "<td>".$dUser["productName"]."</td>";
                            echo "<td>".$dUser["Modelo"]."</td>";
                            echo "<td>".$dUser["cantidad"]."</td>";
                            echo "<td>$".$dUser["precioAdquirido"]."</td>";
                            if($dUser["Promo"]==true){
                                $promo = "select Nombre from promociones where idPromocion=".$dUser["idPromo"];
                                $r = mysqli_query(conectDB(),$promo);
                                if(mysqli_num_rows($r)>0){
                                    //Encontro archivos
                                    $namePromo = mysqli_fetch_array($r);
                               
                                echo "<td>".$namePromo["Nombre"]."</td>";
                                }
                                else{
                                    echo "<td>"."N/A"."</td>";
                                }
                                
                            }
                            else
                            {
                                echo "<td> N/A </td>";
                            }
                            echo "<td>$".intval($dUser["precioAdquirido"])*intval($dUser["cantidad"])."</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
                echo " <a class='btn btn-primary' href='ventas.php' role='button'>Regresar a historial de ventas</a>";
            ?>
        </div>
    </div>
</div>
</body>
</html>