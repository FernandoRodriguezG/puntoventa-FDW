<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol = "";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
  $Rol = recuperaRol(conectDB());
  if($Rol==""||$Rol=="Proveedor"){
      header("location:http://localhost/FDW21/proyecto/index.php");
  }
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Buscar venta | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaBusqueda() {
    if (document.getElementById("criterio").value == "0" ||
        document.getElementById("txtCriterio").value == "") {
        alert("Todos los campos son requeridos");
        return false;
    }
    return true;
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
    <h3>Buscar venta</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="buscaVenta.php" method="get" onsubmit="return validaBusqueda()">
      Buscar por cliente por:
      <select id='criterio' name='criterio' class='form-select'>;
       <option value='0'>Selecciona tu criterio de busqueda</option>;
       <option value='Fecha'>Fecha</option>;
       <option value='numProd'>Numero de productos</option>;
       <option value='Total'>Precio total</option>;      
      </select>
    Ingresa tu criterio de busqueda:
      <input type="text" id="txtCriterio" name="txtCriterio" class="form-control"><br>
      <input type="submit" value="Buscar" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>

    <?php
    $consulta = "";
        if(isset($_GET['criterio']) && isset($_GET['txtCriterio'])){
            if($_GET['criterio']!=0 && $_GET['txtCriterio']!=""){
                if($_GET['criterio']=="Fecha"){
                    $consulta = "select *,C.Nombre as cliNom from ventas inner join clientes as C on ventas.idCliente=C.idCliente where Fecha like '%".$_GET['txtCriterio']."%'";
                }
                else if($_GET['criterio']=="numProd"){
                    $consulta = "select *,C.Nombre as cliNom from ventas inner join clientes as C on ventas.idCliente=C.idCliente where numProductos=".$_GET['txtCriterio'];
                }else{
                    $consulta = "select *,C.Nombre as cliNom from ventas inner join clientes as C on ventas.idCliente=C.idCliente where precioTotal=".$_GET['txtCriterio'];
                }
                $rs = mysqli_query(conectDB(),$consulta);
                if(mysqli_num_rows($rs)){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Cliente</th>";
                    echo "<th scope='col'>Fecha</th>";
                    echo "<th scope='col'>Numero de productos</th>";
                    echo "<th scope='col'>Total</th>";   
                    echo "<th scope='col'></th>";  
                    echo "</tr>";
                    echo "</thead>";
                    while($dBus = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        echo "<td>".$dBus["cliNom"]."</td>";
                        echo "<td>".$dBus["Fecha"]."</td>";
                        echo "<td>".$dBus["numProductos"]."</td>";
                        echo "<td>".$dBus["precioTotal"]."</td>";
                        echo " <td><a class='btn btn-primary' href='detallesVenta.php?idV=".$dBus["idVenta"]."' role='button'>Detalles Venta</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else{
                    echo "<p class='fs-4'>No hay resultados que coincidan con tu busqueda</p>";
                }       
            }
        }
    ?>
        </div>
    </div>
</div>
</body>
</html>