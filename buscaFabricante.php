<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol = "";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
    $Rol = recuperaRol(conectDB());
    if($Rol=="Vendedor"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Busca fabricante | Sistema de Inventario</title>
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
    <h3>Buscar Fabricante</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="buscaFabricante.php" method="get" onsubmit="return validaBusqueda()">
      Buscar fabricante por:
      <select id='criterio' name='criterio' class='form-select'>;
       <option value='0'>Selecciona tu criterio de busqueda</option>;
       <option value='Nombre'>Nombre</option>;
       <option value='Correo'>Correo</option>;      
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
                if($_GET['criterio']=="Nombre"){
                    $consulta = "select * from fabricantes where Nombre like '%".$_GET['txtCriterio']."%'";
                }else{
                    $consulta = "select * from fabricantes where Correo like '%".$_GET['txtCriterio']."%'";
                }
                $rs = mysqli_query(conectDB(),$consulta);
                if(mysqli_num_rows($rs)){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Nombre</th>";
                    echo "<th scope='col'>Direccion</th>";
                    echo "<th scope='col'>Telefono</th>";
                    echo "<th scope='col'>Correo</th>";     
                    echo "</tr>";
                    echo "</thead>";
                    while($dBus = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        echo "<td>".$dBus["Nombre"]."</td>";
                        echo "<td>".$dBus["Direccion"]."</td>";
                        echo "<td>".$dBus["Telefono"]."</td>";
                        echo "<td>".$dBus["Correo"]."</td>";
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