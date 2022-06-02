<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());

    if(isset($_GET['err'])){
        if($_GET['err']==0){
            //NO se pudo eliminar el registro
            $error="El producto no pudo ser eliminado, verifique no haya ventas asociadas al producto";
        } else if($_GET['err']==1){
            //Se elimino el registro
            $error="El producto se elimino correctamente";
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Productos | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function eliminaProducto(){
        if(confirm("¿Estas seguro de querer eliminar el producto? Se podrian perder algunos datos")){
            return confirm("Todo lo relacionado al producto se eliminara, ¿Desea continuar?");
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
            <h3>Productos</h3>
            <div class="alertMsg"><?php if($error!="")echo $error;?></div>
            <?php
            if($rol!=""){
                echo " <a class='btn btn-primary' href='nuevoProducto.php' role='button'>Añadir Producto</a>";
            }
            //Listado de usuarios para mostrar al administrador
            $cons = "select productos.*,F.Nombre as fabName,C.Nombre as catName from productos inner join fabricantes as F on 
            productos.idFabricante=F.idFabricante inner join categoria as C on productos.idCategoria=C.idCategoria";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Modelo</th>";
                echo "<th scope='col'>Descripción</th>";
                echo "<th scope='col'>Fabricante</th>";
                echo "<th scope='col'>Stock</th>";
                echo "<th scope='col'>Precio</th>";
                echo "<th scope='col'>Imagen</th>"; 
                if($rol!=""){
                    echo "<th scope='col'></th>";  
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
                        echo "<td>".$dProd["fabName"]."</td>";
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
                        if($rol!=""){
                        

                        echo "<td>";
                        echo " <a class='btn btn-primary' href='editarProd.php?id=".$dProd["idProducto"]."' role='button'>Editar producto</a>";
                        echo "</td>";

                        echo "<td>";
                        echo " <a class='btn btn-primary' href='addStock.php?id=".$dProd["idProducto"]."' role='button'>Añadir Stock</a>";
                        echo "</td>";

                        echo "<td>";
                        echo " <a class='btn btn-danger' onclick='return eliminaProducto()' href='eliminaProducto.php?id=".$dProd["idProducto"]."' role='button'>Elimina producto</a>";
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