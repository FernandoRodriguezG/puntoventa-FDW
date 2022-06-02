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
    function validaUnCliente(){
        var selects = document.getElementsByClassName("form-check-input");
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
               alert("Debes elegir un cliente");
               return false;
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
    function calA(){
        document.form1.action ="nuevaVenta.php";
    }
    function calB(){
        document.form1.action = "add.php";
    }
    function validaVenta(){ 
        var cont = 0;
        
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
               alert("Eliga por lo menos un producto para seguir con la venta");
               return false;
           }
        
    }
    function validaCli(){
        if (document.getElementById("txtNombre").value == "") {
        alert("Introduzca una busqueda");
        return false;
    }
    return true;
    }
    function validaPro(){
        if (document.getElementById("txtNombrePro").value == "") {
        alert("Introduzca una busqueda");
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
    <h3>Registrar venta</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="nuevaVenta.php" method="get" onsubmit="return validaCli()" >
      Ingresa un nombre de cliente para asignar venta:
      <input type="text" id="txtNombre" name="txtNombre" class="form-control">
      <input type="submit" value="Buscar" class="btn btn-primary">
    </form>
    <?php
        if(isset($_GET['txtNombre']) && $Rol!="Proveedor"){
            echo "<form action='nuevaVenta.php' method='get' onsubmit='return validaUnCliente()'>";
            $consulta = "select * from clientes where Nombre like '%".$_GET['txtNombre']."%'";
            $rs = mysqli_query(conectDB(),$consulta);
                if(mysqli_num_rows($rs)){
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'></th>";
                    echo "<th scope='col'>Nombre</th>";
                    echo "<th scope='col'>Direccion</th>";
                    echo "<th scope='col'>Telefono</th>";
                    echo "<th scope='col'>Correo</th>";     
                    echo "</tr>";
                    echo "</thead>";
                    while($dBus = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        //echo "<td><input class='cbox' type='checkbox' id='".$dBus['idCliente']."' onclick='unCliente(\"".$dBus['idCliente']."\")' name='".$dBus['idCliente']."'></td>";
                        echo "<td><input class='form-check-input' type='radio' name='flexRadioDefault' value='".$dBus['idCliente']."' id='".$dBus['idCliente']."'></td>";
                        echo "<td>".$dBus["Nombre"]."</td>";
                        echo "<td>".$dBus["Direccion"]."</td>";
                        echo "<td>".$dBus["Telefono"]."</td>";
                        echo "<td>".$dBus["Correo"]."</td>";
                        echo "</tr>";
                        
                    }
                    echo "</table>";
                } else{
                  echo "<p class='fs-4'>No hay clientes coincidentes, realize otra busqueda</p>";
                }  
               echo "<input type='submit' value='Continuar Venta' class='btn btn-primary'>";
            echo "</form>";
        }
        if(isset($_GET['flexRadioDefault']) && $Rol!="Proveedor"){
                $cons = "select * from clientes where idCliente=".$_GET['flexRadioDefault'];
                $rs = mysqli_query(conectDB(),$cons);
                if(mysqli_num_rows($rs)){
                    $dClienteVenta = mysqli_fetch_array($rs);
                    echo "<br>Cliente: ";
                    echo $dClienteVenta['Nombre'];
                    echo "<br>Direccion: ";
                    echo $dClienteVenta['Direccion'];
                    echo "<br>Telefono: ";
                    echo $dClienteVenta['Telefono'];
                    echo "<br>Correo: ";
                    echo $dClienteVenta['Correo'];
                }
                echo "<form action='nuevaVenta.php' method='get' onsubmit='return validaPro()' >";
                echo "<b>Buscar producto:</b>";
                echo "<input type='text' id='txtNombrePro' name='txtNombrePro' class='form-control'><br>";
                echo "<input type='hidden' name='idCli' value='".$_GET['flexRadioDefault']."'>";
                echo "<input type='submit' value='Busca producto' class='btn btn-primary'>";
                echo "</form>";
        }
        if(isset($_GET['idCli']) &&  isset($_GET['txtNombrePro']) && $Rol!="Proveedor" && count($_GET)<3){
                $cons = "select * from clientes where idCliente=".$_GET['idCli'];
                $ress = mysqli_query(conectDB(),$cons);
                if(mysqli_num_rows($ress)){
                    $dClienteVenta = mysqli_fetch_array($ress);
                    echo "<br>Cliente: ";
                    echo $dClienteVenta['Nombre'];
                    echo "<br>Direccion: ";
                    echo $dClienteVenta['Direccion'];
                    echo "<br>Telefono: ";
                    echo $dClienteVenta['Telefono'];
                    echo "<br>Correo: ";
                    echo $dClienteVenta['Correo'];
                }
                $consulta = "select * from productos where Nombre like '%".$_GET['txtNombrePro']."%'";
                $rs = mysqli_query(conectDB(),$consulta);
                if(mysqli_num_rows($rs)){
                    echo "<form action ='nuevaVenta.php' method='get' name='form1' onsubmit='return validaVenta()'>";
                    echo "<input type='hidden' name='idCli' value='".$_GET['idCli']."'>";
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'></th>";
                    echo "<th scope='col'>Nombre</th>";
                    echo "<th scope='col'>Descripcion</th>";
                    echo "<th scope='col'>Modelo</th>";
                    echo "<th scope='col'>Precio</th>"; 
                    echo "<th scope='col'>Stock</th>";     
                    echo "</tr>";
                    echo "</thead>";
                    while($dPro = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        if($dPro["Stock"]>0){
                        echo "<td>";
                        echo "<input class='cbox' type='checkbox' id='".$dPro['idProducto']."' name='".$dPro['idProducto']."' onclick='aparecerSelect(\"".$dPro['idProducto']."\")'>";
                            echo "<select style='display:none' id='cant".$dPro['idProducto']."'  disable>";
                                for($i=1;$i<=$dPro['Stock'];$i++){
                                    echo "<option class='opCant' value='".$i."'>".$i."</option>";
                                }
                           echo" </select>";
                           echo "</td>";
                            }else{
                                echo "<td>";
                                echo "AGOTADO";
                                echo "</td>";
                            }
                        echo "<td>".$dPro["Nombre"]."</td>";
                        echo "<td>".$dPro["Descripcion"]."</td>";
                        echo "<td>".$dPro["Modelo"]."</td>";
                        echo "<td>$".$dPro["Precio"]."</td>";
                        if($dPro["Stock"]>=0)
                         echo "<td>".$dPro["Stock"]."</td>";
                         else
                         echo "<td>0</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<input type ='submit' value='Añadir Producto' class='btn btn-primary'>";
                    echo "</form>";
                } else{
                  echo "<p class='fs-4'>No hay resultados que coincidan con tu busqueda</p>";
                } 
        }
        if(count($_GET)>=3 && $Rol!="Proveedor" && !isset($_GET['txtNombrePro'])){
            $cons = "select * from clientes where idCliente=".$_GET['idCli'];
            $ress = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($ress)){
                $dClienteVenta = mysqli_fetch_array($ress);
                echo "<br>Cliente: ";
                echo $dClienteVenta['Nombre'];
                echo "<br>Direccion: ";
                echo $dClienteVenta['Direccion'];
                echo "<br>Telefono: ";
                echo $dClienteVenta['Telefono'];
                echo "<br>Correo: ";
                echo $dClienteVenta['Correo'];
            }
            echo "<br>Productos de la venta:";
            $ides=array(); 
            $cants=array();
            $tags = array_keys($_GET);
            $valores = array_values($_GET);
            for($i=1;$i<count($_GET);$i++){
                if($i%2==1){
                    array_push($ides,$tags[$i]); //Obtener IDES de productos de venta
                }
                else{
                    array_push($cants,$valores[$i]); //Obtener Cantidades de cada producto en la venta
                }
            }
            echo "<form action='addVenta.php' method='get'>";
            echo "<input type='hidden' name='idCli' value='".$_GET['idCli']."'>";
            for($i=0;$i<count($ides);$i++){
                echo "<input type='hidden' name='".$ides[$i]."' value='true'>";
                echo "<input type='hidden' name='cant".$ides[$i]."' value='".$cants[$i]."'>";
            }
            echo "<table class='table table-striped'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Nombre</th>";
            echo "<th scope='col'>Modelo</th>";
            echo "<th scope='col'>Precio</th>"; 
            echo "<th scope='col'>Cantidad</th>";     
            echo "</tr>";
            echo "</thead>";
            $prods = "";
            $total = 0;
            for($i=0;$i<count($ides);$i++){
                $prods = "select * from productos where idProducto=".$ides[$i];
                $rs = mysqli_query(conectDB(),$prods);
                $dBus = mysqli_fetch_array($rs);
                echo "<tr>";
                echo "<td>".$dBus["Nombre"]."</td>";
                echo "<td>".$dBus["Modelo"]."</td>";
                echo "<td>$".$dBus["Precio"]."</td>";
                echo "<td>".$cants[$i]."</td>";
                echo "</tr>";
                $total = $total + (intval($cants[$i])*intval($dBus["Precio"]));
            }
            echo "</table>";
            echo "Total de la venta: $".$total."<br>";
            echo "<input type='submit' value='Registrar venta' class='btn btn-success'>";
            echo "</form>";
            echo "<form action='nuevaVenta.php' method='get' onsubmit='return validaPro()' >";
            echo "<b>Buscar producto:</b>";
            echo "<input type='text' id='txtNombrePro' name='txtNombrePro' class='form-control'><br>";
            echo "<input type='hidden' name='idCli' value='".$_GET['idCli']."'>";
            for($i=0;$i<count($ides);$i++){
                echo "<input type='hidden' name='".$ides[$i]."' value='true'>";
                echo "<input type='hidden' name='cant".$ides[$i]."' value='".$cants[$i]."'>";
            }
            echo "<input type='submit' value='Busca producto' class='btn btn-primary'>";
            echo "</form>";
        }
        if(count($_GET)>3 && $Rol!="Proveedor" && isset($_GET['txtNombrePro'])){
            $cons = "select * from clientes where idCliente=".$_GET['idCli'];
            $ress = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($ress)){
                $dClienteVenta = mysqli_fetch_array($ress);
                echo "<br>Cliente: ";
                echo $dClienteVenta['Nombre'];
                echo "<br>Direccion: ";
                echo $dClienteVenta['Direccion'];
                echo "<br>Telefono: ";
                echo $dClienteVenta['Telefono'];
                echo "<br>Correo: ";
                echo $dClienteVenta['Correo'];
            }
            echo "<br>Productos de la venta:";
            $ides=array(); 
            $cants=array();
            $tags = array_keys($_GET);
            $valores = array_values($_GET);
            for($i=2;$i<count($_GET);$i++){
                if($i%2==0){
                    array_push($ides,$tags[$i]); //Obtener IDES de productos de venta
                }
                else{
                    array_push($cants,$valores[$i]); //Obtener Cantidades de cada producto en la venta
                }
            }
            echo "<form action='addVenta.php' method='get'>";
            echo "<input type='hidden' name='idCli' value='".$_GET['idCli']."'>";
            for($i=0;$i<count($ides);$i++){
                echo "<input type='hidden' name='".$ides[$i]."' value='true'>";
                echo "<input type='hidden' name='cant".$ides[$i]."' value='".$cants[$i]."'>";
            }
            echo "<table class='table table-striped'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Nombre</th>";
            echo "<th scope='col'>Modelo</th>";
            echo "<th scope='col'>Precio</th>"; 
            echo "<th scope='col'>Cantidad</th>";     
            echo "</tr>";
            echo "</thead>";
            $prods = "";
            $total = 0;
            for($i=0;$i<count($ides);$i++){
                $prods = "select * from productos where idProducto=".$ides[$i];
                $rs = mysqli_query(conectDB(),$prods);
                $dBus = mysqli_fetch_array($rs);
                echo "<tr>";
                echo "<td>".$dBus["Nombre"]."</td>";
                echo "<td>".$dBus["Modelo"]."</td>";
                echo "<td>$".$dBus["Precio"]."</td>";
                echo "<td>".$cants[$i]."</td>";
                echo "</tr>";
                $total = $total + (intval($cants[$i])*intval($dBus["Precio"]));
            }
            
            echo "</table>";
            echo "Total de la venta: $".$total."<br>";
            echo "<input type='submit' value='Registrar venta' class='btn btn-success'>";
            echo "</form>";
            echo "<form action='nuevaVenta.php' method='get' onsubmit='return validaPro()' >";
            echo "<b>Buscar producto:</b>";
            echo "<input type='text' id='txtNombrePro' name='txtNombrePro' class='form-control'><br>";
            echo "<input type='hidden' name='idCli' value='".$_GET['idCli']."'>";
            for($i=0;$i<count($ides);$i++){
                echo "<input type='hidden' name='".$ides[$i]."' value='true'>";
                echo "<input type='hidden' name='cant".$ides[$i]."' value='".$cants[$i]."'>";
            }
            echo "<input type='submit' value='Busca producto' class='btn btn-primary'>";
            echo "</form>";
            echo "RESULTADOS DE BUSQUEDA:";
            $consulta = "select * from productos where Nombre like '%".$_GET['txtNombrePro']."%'";
                $rs = mysqli_query(conectDB(),$consulta);
                if(mysqli_num_rows($rs)){
                    echo "<form action ='nuevaVenta.php' method='get' name='form1'>";
                    echo "<input type='hidden' name='idCli' value='".$_GET['idCli']."'>";
                    for($i=0;$i<count($ides);$i++){
                        echo "<input type='hidden' name='".$ides[$i]."' value='true'>";
                        echo "<input type='hidden' name='cant".$ides[$i]."' value='".$cants[$i]."'>";
                    }
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'></th>";
                    echo "<th scope='col'>Nombre</th>";
                    echo "<th scope='col'>Descripcion</th>";
                    echo "<th scope='col'>Modelo</th>";
                    echo "<th scope='col'>Precio</th>"; 
                    echo "<th scope='col'>Stock</th>";     
                    echo "</tr>";
                    echo "</thead>";
                    while($dPro = mysqli_fetch_array($rs)){
                        echo "<tr>";
                        if($dPro['Stock']>0){
                        echo "<td>";
                        echo "<input class='cbox' type='checkbox' id='".$dPro['idProducto']."' name='".$dPro['idProducto']."' onclick='aparecerSelect(\"".$dPro['idProducto']."\")'>";
                            echo "<select style='display:none' id='cant".$dPro['idProducto']."'  disable>";
                                for($i=1;$i<=$dPro['Stock'];$i++){
                                    echo "<option class='opCant' value='".$i."'>".$i."</option>";
                                }
                           echo" </select>";
                           echo "</td>";
                            }else{
                                echo "<td>";
                                echo "AGOTADO";
                                echo "</td>";
                            }
                        echo "<td>".$dPro["Nombre"]."</td>";
                        echo "<td>".$dPro["Descripcion"]."</td>";
                        echo "<td>".$dPro["Modelo"]."</td>";
                        echo "<td>$".$dPro["Precio"]."</td>";
                        if($dPro["Stock"]>=0)
                         echo "<td>".$dPro["Stock"]."</td>";
                         else
                         echo "<td>0</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<input type ='submit' value='Añadir Producto' class='btn btn-primary'>";
                    echo "</form>";
                } 
        }
    ?>
        </div>
    </div>
</div>

</body>
</html>
