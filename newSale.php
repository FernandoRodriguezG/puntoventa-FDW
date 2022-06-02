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
if(isset($_GET['err'])){
    if($_GET['err']==4){
        $error="Venta registrada, Total: $".$_GET['t'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Nueva venta | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaVenta(){ 
        var cont = 0;
        if(document.getElementById("idCliente").value==-1){
           alert("Selecciona un cliente para continuar con la operación");
           return false;
        }
        else{
           var selects = document.getElementsByClassName("cbox");
           var cont = 0;
           for(i=0;i<selects.length;i++){
               if(selects[i].checked){
                   cont=cont+1;
               }
           }
           if(cont>0){
               return true;
           }
           else{
               alert("Eliga ppor lo menos un producto para seguir con la venta");
               return false;
           }
        }
    }
    function aparecerSelect(ID){
        var cb = document.getElementById(ID);
        var select = document.getElementById("cant"+ID);

        if(cb.checked==true){
            select.style.display =  "block";
            select.disabled = false;
            cb.value = true;
            select.setAttribute("name","cant"+ID);
        }
        else{
            select.style.display= "none";
            select.disabled = true;
            cb.value = false;
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
    <h3>Registrar venta</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <?php
    $consulta = "select productos.*,F.Nombre as fabName,C.Nombre as catName from productos inner join fabricantes as F on productos.idFabricante=F.idFabricante inner join categoria as C on productos.idCategoria=C.idCategoria";
    $res = mysqli_query(conectDB(),$consulta);
    if(mysqli_num_rows($res)){
    ?>
    <form action="addVenta.php" method="get" onsubmit="return validaVenta()" >
      Elige cliente:
      <?php
      echo "<select id='idCliente' name='idCliente' class='form-select' value=''>";
      echo "<option value='-1' selected='selected' hidden='hidden'>Nombre del cliente --- Dirección --- Correo</option>";
                        $qry = "select idCliente,Nombre,Direccion,Correo from clientes";
                        $res = mysqli_query(conectDB(),$qry);
                        if(mysqli_num_rows($res)){
                            while($datosCli = mysqli_fetch_object($res)){
                                echo "<option value='".$datosCli->idCliente."'>".$datosCli->Nombre." --- ".$datosCli->Direccion." --- ".$datosCli->Correo."</option>";
                            }
                        }else{
                            echo "No hay clientes registrados para completar la compra";
                            echo "<a class='btn btn-primary' href='nuevoCliente.php' role='button'>Añadir Cliente</a>";
                        }
                        
                    
      echo "</select>";
      ?>
      Fecha de la venta:
      <input type="date" value="<?php echo date('Y-m-d'); ?>" id="txtFecha" name="txtFecha" class="form-control">
      <br>Elige productos:
      <?php
      $res = mysqli_query(conectDB(),$consulta);
       if(mysqli_num_rows($res)){
            echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Modelo</th>";
                echo "<th scope='col'>Fabricante</th>";
                echo "<th scope='col'>Precio</th>";
                echo "<th scope='col'>Imagen</th>"; 
                echo "<th scope='col'></th>";          
                echo "</tr>";
                echo "</thead>";
                while($dProd = mysqli_fetch_array($res)){
                    
                        echo "<tr>";
                        echo "<td>".$dProd["Nombre"]."</td>";
                        echo "<td>".$dProd["Modelo"]."</td>";
                        echo "<td>".$dProd["fabName"]."</td>";
                        echo "<td>$".$dProd["Precio"]."</td>";
                        //INICIO IMAGEN 
                        echo "<td>";
                        $qry = "select * from archivos where idProducto=".$dProd["idProducto"];
                        $ress = mysqli_query(conectDB(),$qry);
                        if(mysqli_num_rows($ress)>0){
                            while($archivo = mysqli_fetch_array($ress)){
                                echo "<img style='width:70px; height:70px' src='imagen.php?idA=".$archivo["idArchivo"]."' alt='".$archivo["Titulo"]."'>";
                            }
                        }   
                        echo "</td>"; 

                        if($dProd["Stock"]>0){
                        echo "<td>";
                            echo "<div id='selectForms'>";
                            echo "<input class='cbox' type='checkbox' id='".$dProd['idProducto']."' name='".$dProd['idProducto']."' onclick='aparecerSelect(\"".$dProd['idProducto']."\")'>";
                            echo "<select style='display:none' id='cant".$dProd['idProducto']."'  disable>";
                                for($i=1;$i<=$dProd['Stock'];$i++){
                                    echo "<option class='opCant' value='".$i."'>".$i."</option>";
                                }
                           echo" </select>";
                           echo "</div>";
                        echo "</td>";
                        }else{
                            echo "<td>";
                            echo "<p style='color:red' class='fw-bolder'>AGOTADO</p>";
                            echo "</td>";
                        }


                        echo "</tr>";
                    
                    
                }
                echo "</table>";
            }
        
        ?>
      <input type="submit" value="Registrar venta" class="btn btn-success">
    </form>
    <?php
    }
    else{
        echo "NO HAY PRODUCTOS REGISTRADOS PARA REGISTRAR UNA VENTA<br>";
        if($Rol=="general" || $Rol=="administrador"){
            echo " <a class='btn btn-primary' href='nuevoProducto.php' role='button'>Añadir Producto</a>";
        }
    }
    ?>

        </div>
    </div>
</div>
</body>
</html>
