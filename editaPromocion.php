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
  }
if(!isset($_GET['id'])){
    header("location:http://localhost/FDW21/proyecto/promociones.php");
}

if(isset($_GET['Nombre']) && isset($_GET['Descripcion']) && isset($_GET['descuento']) && isset($_GET['FechaFinal']) && isset($_GET['idP']) ){
    $index=array(); 
    $campos=array();
    $tags = array_keys($_GET); //Obtener nombres de variables get
    $valores = array_values($_GET);//Valores de get
    for($i=0;$i<count($_GET);$i++){
        if($valores[$i]!=""){
            if($tags[$i]!="idP"){
                array_push($index,$tags[$i]);
                array_push($campos,$valores[$i]);
            }
        }
    }
    $conn = conectDB();
    for($i=0;$i<count($index);$i++){
        $consulta = "update promociones set ".$index[$i]."='".$campos[$i]."' where id=".$_GET['idP']." ";
        $rs = mysqli_query($conn,$consulta);
    }
    $msg="Promocion actualizada";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Editar promo | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaPromo(){   
    if (document.getElementById("Nombre").value == "" &&
        document.getElementById("Descripcion").value == "" &&
        document.getElementById("descuento").value == "" ) {
        alert("Se necesita almenos una solicitud de cambio");
        return false;
    }else{
      if(document.getElementById("FechaFinal").value < document.getElementById("FechaInicio").value){
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
    <h3>Editar promoción de producto</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="editaPromocion.php" method="get" onsubmit=" return validaPromo()">
    <?php
            $prod = "select P.idProducto,P.Nombre as prodName,Pro.* from productos as P inner join promociones as Pro on P.idProducto=Pro.id where P.idProducto=".$_GET['id'];
            $resultado = mysqli_query(conectDB(),$prod);
            $producto = mysqli_fetch_object($resultado);
            echo "<div class='fw-bold fs-5'>Nombre:</div>".$producto->Nombre;
            echo "<div class='fw-bold fs-5'>Producto de promoción:</div>".$producto->prodName;
            echo "<div class='fw-bold fs-5'>Fecha de inicio:</div>".$producto->fechaInicio;
            echo "<div class='fw-bold fs-5'>Fecha de termino:</div>".$producto->fechaFinal;
            echo "<div class='fw-bold fs-5'>Descuento a aplicar:</div>".$producto->descuento."%";
        ?>
        <br><br>
        <input type="hidden" name ="idP" value="<?php echo $_GET['id']; ?>" >
        Nuevo nombre de la promoción:
        <input type="text" id="Nombre" name="Nombre" class="form-control">
        Nueva descripción de la promoción:
        <input type="text" id="Descripcion" name="Descripcion" class="form-control">
        Nueva fecha de inicio de la promoción:
        <input type="date" value="<?php echo date($producto->fechaInicio); ?>" id="FechaInicio" name="FechaInicio" class="form-control"> 
        Nueva fecha de termino de la promoción:
        <input type="date" value="<?php echo date($producto->fechaFinal); ?>" id="FechaFinal" name="FechaFinal" class="form-control"> 
        
      Nuevo descuento que se aplicara por producto:
      <input type="number" id="descuento" name="descuento" class="form-control" min="10" max="90" step="5" ><br>
      <input type="submit" value="Editar promoción" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
        </div>
    </div>
</div>
</body>
</html>