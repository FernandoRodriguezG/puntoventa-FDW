<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
  $Rol = recuperaRol(conectDB());
  if($Rol==""){
      header("location:http://localhost/FDW21/proyecto/index.php");
  }
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}
if(isset($_GET['txtStock'])&&isset($_GET['id'])){
    $cons = "select Stock from productos where idProducto=".$_GET['id']." ";
    $res = mysqli_query(conectDB(),$cons);
    $stock= mysqli_fetch_array($res);
    if($stock['Stock']<0){
        $stock['Stock']=0;
    }
    $newStock = intval($stock['Stock'])+intval($_GET['txtStock']);
    $upd = "update productos set Stock=".$newStock." where idProducto=".$_GET['id'];
    $res = mysqli_query(conectDB(),$upd);
    $error="Stock actualizado correctamente";
}
if(!isset($_GET['id'])){
  header("location:http://localhost/FDW21/proyecto/productos.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Añadir stock | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaPwd(){
        if(document.getElementById("txtStock").value == "")
        {
          alert("Por favor, añade un stock");
          return false;
        }
        else 
        {
            return true;
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
            <h3>Añadir Stock a producto</h3>
            <div class="alertMsg"><?php if($error!="") echo $error;?></div>
            <?php
            $qry="select Stock,Nombre from productos where idProducto=".$_GET['id'];
            $res = mysqli_query(conectDB(),$qry);
            $profile = mysqli_fetch_object($res);
            echo "<div class='fw-bold fs-5'>Producto: </div>";
            echo $profile->Nombre."<br>";
            echo "<div class='fw-bold fs-5'>Stock actual: </div>";
            if($profile->Stock<0){
                $profile->Stock=0;
            }
            echo $profile->Stock."<br>";            
            ?>
            <form action="addStock.php" method="get" onsubmit=" return validaPwd()">
            ¿Cuanto stock quieres agregar? <input type="number" id="txtStock" name="txtStock" class="form-control"><br>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Añadir stock" class="btn btn-primary">
            <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
</body>
</html>