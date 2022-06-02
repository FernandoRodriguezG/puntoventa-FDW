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
            $error="La Promoción no pudo ser eliminado, verifique no haya ventas asociadas a ella";
        } else if($_GET['err']==1){
            //Se elimino el registro
            $error="La Promoción se elimino correctamente";
        }
    }
}

if(isset($_GET['err'])){
    if($_GET['err']==4){
        $error = "Promoción añadida correctamente";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Promociones | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function eliminaPromo(){
        if(confirm("¿Estas seguro de querer eliminar la Promocion? Se podrian perder algunos datos")){
            return confirm("Todo lo relacionado a la Promocion se eliminara, ¿Desea continuar?");
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
            <h3>Promociones Activas</h3>
            <div class="alertMsg"><?php if($error!="") echo $error;?></div>
            <?php
            if($rol!=""){
                echo " <a class='btn btn-primary' href='nuevaPromocionProd.php' role='button'>Añadir Promoción</a>";
            }
            $cons = "select * from promociones where fechaFinal>='".date('Y-m-d')."' and fechaInicio<='".date('Y-m-d')."'";// as P inner join categoria as C on p.id=C.idCategoria where p.fechaFinal>='".date('Y-m-d')."'";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Descripción</th>";
                echo "<th scope='col'>Inicio</th>";
                echo "<th scope='col'>Termino</th>";
                echo "<th scope='col'>Descuento</th>";
                echo "<th scope='col'>Producto</th>";  
                if($rol!="")
                     echo "<th scope='col'></th>";         
                echo "</tr>";
                echo "</thead>";
                while($dProm = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dProm["Nombre"]."</td>";
                        echo "<td>".$dProm["descripcion"]."</td>";
                        echo "<td>".$dProm["fechaInicio"]."</td>";
                        echo "<td>".$dProm["fechaFinal"]."</td>";
                        echo "<td>".$dProm["descuento"]."% </td>";
                        $tipo = "Select productos.Nombre, productos.idProducto from productos where idProducto=".$dProm['id'];
                        $r = mysqli_query(conectDB(),$tipo);
                        $type = mysqli_fetch_array($r);
                        echo "<td>".$type["Nombre"]."</td>"; 
                        if($rol!=""){
                            echo " <td><a class='btn btn-primary' href='editaPromocion.php?id=".$dProm["id"]."' role='button'>Edita promoción</a></td>";
                            echo "<td>";
                        echo "<a class='btn btn-danger' onclick='return eliminaPromo()' href='eliminaPromo.php?p=1&id=".$dProm["id"]."' role='button'>Eliminar Promo</a>";
                        echo "</td>";
                        }
                    echo "</tr>";
                }
                    echo "</table>";
                }else{
                    echo "<p class='fs-4'>No hay promociones activas para este momento</p>";
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>