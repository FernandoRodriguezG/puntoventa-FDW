<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());
    if($rol==""){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
    if(isset($_GET['err'])){
        if($_GET['err']==0){
            //NO se pudo eliminar el registro
            $error="La categoria no pudo ser eliminado, verifique no haya productos asociados a ella";
        } else if($_GET['err']==1){
            //Se elimino el registro
            $error="La categoria se elimino correctamente";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Categorias | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function eliminaCategoria(){
        if(confirm("¿Estas seguro de querer eliminar la categoria? Se podrian perder algunos datos")){
            return confirm("Todo lo relacionado a la categoria se eliminara, ¿Desea continuar?");
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
            <h3>Categorias</h3>
            <div class="alertMsg"><?php if($error!="")echo $error;?></div>
            <?php
            if($rol=="general" || $rol=="administrador"){
                echo " <a class='btn btn-primary' href='añadirCategoria.php' role='button'>Añadir Categoria</a>";
            }
            
            //Listado de usuarios para mostrar al administrador
            $cons = "select categoria.* from categoria";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Descripción</th>";  
                echo "<th scope='col'></th>";  
                echo "<th scope='col'></th>";      
                if($rol!=""){
                    echo "<th scope='col'></th>";    
                } 
                echo "</tr>";
                echo "</thead>";
                while($dCat = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dCat["Nombre"]."</td>";
                        echo "<td>".$dCat["Descripcion"]."</td>";
                        echo "<td>";
                        
                        echo "<a class='btn btn-primary' href='verCategoria.php?id=".$dCat["idCategoria"]."' role='button'>Ver productos de la Categoria</a>";
                        
                        echo "</td>";
                        
                        if($rol!=""){
                            echo "<td>";
                            echo "<a class='btn btn-primary' href='editarCat.php?id=".$dCat["idCategoria"]."' role='button'>Editar Categoria</a>";
                            echo "</td>";

                            echo "<td>";
                            echo "<a class='btn btn-danger' onclick='return eliminaCategoria()' href='eliminaCategoria.php?id=".$dCat["idCategoria"]."' role='button'>Eliminar Categoria</a>";
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