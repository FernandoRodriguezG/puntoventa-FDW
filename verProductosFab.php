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
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
if(!isset($_GET['id'])){
    header("location:http://localhost/FDW21/proyecto/fabricantes.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Productos de Fabricante | Sistema de Inventario</title>
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
            
            <?php
            $name = "select Nombre from fabricantes where idFabricante=".$_GET['id'];
            $dd = mysqli_query(conectDB(),$name);
            $nameF = mysqli_fetch_array($dd);
            echo "<h3>Fabricante: ".$nameF['Nombre']."</h3>";
            //Listado de usuarios para mostrar al administrador
            $cons = "select productos.*,F.Nombre as fabName,C.Nombre as catName from productos inner join fabricantes as F on 
            productos.idFabricante=F.idFabricante inner join categoria as C on productos.idCategoria=C.idCategoria where productos.idFabricante=".$_GET['id'];
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Modelo</th>";
                echo "<th scope='col'>Descripción</th>";
                echo "<th scope='col'>Stock</th>";
                echo "<th scope='col'>Precio</th>";
                echo "<th scope='col'>Imagen</th>";  
                if($rol == "administrador" || $rol == "Proveedor"){ 
                echo "<th scope='col'></th>";
                echo "<th scope='col'></th>";  
                }         
                echo "</tr>";
                echo "</thead>";
                while($dProd = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dProd["Nombre"]."</td>";
                        echo "<td>".$dProd["Modelo"]."</td>";
                        echo "<td>".$dProd["Descripcion"]."</td>";
                        if($dProd["Stock"]<0){
                            $dProd["Stock"]=0;
                        }
                        echo "<td>".$dProd["Stock"]."</td>";
                        echo "<td>$".$dProd["Precio"]."</td>";
                        //INICIO IMAGEN 
                        echo "<td>";
                        $qry = "select * from archivos where idProducto=".$dProd["idProducto"];
                        $ress = mysqli_query(conectDB(),$qry);
                        if(mysqli_num_rows($ress)>0){
                            //Encontro archivos
                            while($archivo = mysqli_fetch_array($ress)){
                                echo "<img style='width:100px; height:100px' src='imagen.php?idA=".$archivo["idArchivo"]."' alt='".$archivo["Titulo"]."'>";
                            }
                        }   
                        echo "</td>";     
                        if($rol == "administrador" || $rol == "Proveedor"){
                        
                        echo "<td>";
                        echo " <a class='btn btn-primary' href='editarProd.php?id=".$dProd["idProducto"]."' role='button'>Editar producto</a>";
                        echo "</td>";

                        echo "<td>";
                        echo " <a class='btn btn-primary' href='addStock.php?id=".$dProd["idProducto"]."' role='button'>Añadir Stock</a>";
                        echo "</td>";
                        }
                        
                    echo "</tr>";
                }
                    echo "</table>";
            }
            else{
                echo "<br><br>Aún no hay productos asociados con este fabricante";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>