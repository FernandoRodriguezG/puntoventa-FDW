<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol = "";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
    $Rol = recuperaRol(conectDB());
    if($Rol==""){
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
  <title>Busca producto | Sistema de Inventario</title>
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
    <h3>Buscar productos</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="buscaProducto.php" method="get" onsubmit="return validaBusqueda()">
      Buscar producto por:
      <select id='criterio' name='criterio' class='form-select'>;
       <option value='0'>Selecciona tu criterio de busqueda</option>;
       <option value='Precio'>Precio</option>;
       <option value='Nombre'>Nombre</option>;
       <option value='Modelo'>Modelo</option>;      
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
                if($_GET['criterio']=="Precio"){
                    $consulta = "select * from productos where Precio=".$_GET['txtCriterio'];
                }
                else if($_GET['criterio']=="Nombre"){
                    $consulta = "select * from productos where Nombre like '%".$_GET['txtCriterio']."%'";
                }else{
                    $consulta = "select * from productos where Modelo like '%".$_GET['txtCriterio']."%'";
                }
                $rs = mysqli_query(conectDB(),$consulta);
                if(mysqli_num_rows($rs)){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Nombre</th>";
                    echo "<th scope='col'>Descripcion</th>";
                    echo "<th scope='col'>Modelo</th>";
                    echo "<th scope='col'>Precio</th>"; 
                    echo "<th scope='col'>Stock</th>";     
                    echo "</tr>";
                    echo "</thead>";
                    while($dBus = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        echo "<td>".$dBus["Nombre"]."</td>";
                        echo "<td>".$dBus["Descripcion"]."</td>";
                        echo "<td>".$dBus["Modelo"]."</td>";
                        echo "<td>$".$dBus["Precio"]."</td>";
                        echo "<td>".$dBus["Stock"]."</td>";
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