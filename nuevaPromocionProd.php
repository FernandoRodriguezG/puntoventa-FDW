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
  <title>Nueva promoción | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaPromo(){   
    if (document.getElementById("txtNombre").value == "" ||
        document.getElementById("txtDescripcion").value == "" ||
        document.getElementById("txtDescuento").value == "") {
        alert("Todos los campos son requeridos");
        return false;
    }else{
      if(document.getElementById("txtFechaFin").value < document.getElementById("txtFechaInicio").value){
          alert("La fecha de finalización no puede ser antes que la de inicio, por favor, cambia las fechas");
          return false
        }else{
          return true;
        }
    }
    }

  </Script>
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
    <h3>Añadir promoción a producto</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="addPromo.php" method="get" onsubmit=" return validaPromo()">
        Nombre de la promoción:
        <input type="text" id="txtNombre" name="txtNombre" class="form-control">
        Descripción de la promoción:
        <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control">
        Fecha de inicio de la promoción:
        <input type="date" value="<?php echo date('Y-m-d'); ?>" id="txtFechaInicio" name="txtFechaInicio" class="form-control"> 
        Fecha de termino de la promoción:
        <input type="date" value="<?php echo date('Y-m-d'); ?>" id="txtFechaFin" name="txtFechaFin" class="form-control"> 
        Producto al que se aplicara la promocion:
        <?php
        $qry = "select idProducto,Nombre,Modelo from productos";
        $res = mysqli_query(conectDB(),$qry);
        if(mysqli_num_rows($res)){
            echo "<select name='id' class='form-select' aria-label='Default select example' class='form-control'>";
                    
                       
                          while($datosCat = mysqli_fetch_object($res)){
                            echo "<option value='".$datosCat->idProducto."'>".$datosCat->Nombre." --- ".$datosCat->Modelo."</option>";
                          }
                        }else{
                          echo "No hay productos para añadirles una promoción";
                          echo " <a class='btn btn-primary' href='nuevoProducto.php' role='button'>Añadir Producto</a>";
                        }
                        
                    
      echo "</select>";
    ?>
      
      Descuento que se aplicara por producto:
      <input type="number" id="txtDescuento" name="txtDescuento" class="form-control" min="10" max="90" step="5" ><br>
      <input type="submit" value="Añadir promoción" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
        </div>
    </div>
</div>
</body>
</html>