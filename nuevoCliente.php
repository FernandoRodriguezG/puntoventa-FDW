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

  if(isset($_GET['txtNombre']) && 
  isset($_GET['txtDir']) && 
  isset($_GET['txtEmail']) &&
  isset($_GET['txtTel']))
  {
    if($_GET['txtNombre'] == "" ||
    $_GET['txtDir'] == "" ||
    $_GET['txtEmail'] == "" ||
    $_GET['txtTel'] == "")
    {
        $error="Todos los campos son requeridos";
    }
    extract($_GET); //Crea las variables $txtNombre,$txtUsuario,$txtPwd

    $conn = conectDB();
    $consulta = "insert into clientes (Nombre,Direccion,Telefono,Correo) 
            value ('$txtNombre','$txtDir','$txtTel','$txtEmail')";
    $rs = mysqli_query($conn,$consulta);
    mysqli_close($conn);
    header("location:http://localhost/FDW21/proyecto/nuevoCliente.php?err=3");
  }
  if(isset($_GET['err'])){
    if($_GET['err']==3){
      $error="Cliente añadido correctamente";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Nuevo cliente | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaCliente() {
    if (document.getElementById("txtNombre").value == "" ||
        document.getElementById("txtDir").value == "" ||
        document.getElementById("txtEmail").value == "" ||
        document.getElementById("txtTel").value == "") {
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
    <h3>Añadir nuevo cliente</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="nuevoCliente.php" method="get" onsubmit="return validaCliente()">
      Ingresa el nombre del cliente: <input type="text" id="txtNombre" name="txtNombre" class="form-control"><br>
      Ingresa la dirección del cliente: <input type="text" id="txtDir" name="txtDir" class="form-control"><br>
      Correo electronico del cliente: <input type="email" id="txtEmail" name="txtEmail" class="form-control"><br>
      Telefono: <input type="tel" id="txtTel" name="txtTel" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
      Formato: 123-456-7890
                <br><br>
      <input type="submit" value="Guardar cliente" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
        </div>
    </div>
</div>
</body>
</html>