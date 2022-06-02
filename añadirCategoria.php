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
if(isset($_GET['err'])){
    switch($_GET['err']){
        case 1:
            $error="No existen los datos";
            break;
            case 2:
                $error="Campos vacios";
                break;
                case 3:
                    $error="Categoria añadida correctamente";
                    break;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Añadir categoria | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
  function validaCat() {
    if (document.getElementById("txtNombre").value == "" ||
        document.getElementById("txtDescripcion").value == "") {
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
    <h3>Añadir nueva categoria de productos</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="addCategoria.php" method="get" onsubmit=" return validaCat()">
      Ingresa el nombre de la categoria: 
      <input type="text" id="txtNombre" name="txtNombre" class="form-control"><br>
      Ingresa la descripción de la categoria: 
      <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control"><br>
      <input type="submit" value="Añadir categoria" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
        </div>
    </div>
</div>
</body>
</html>