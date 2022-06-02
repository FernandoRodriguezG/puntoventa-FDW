<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol="";
$msg = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
  $Rol = recuperaRol(conectDB());
  if($Rol==""||$Rol=="Proveedor"){
      header("location:http://localhost/FDW21/proyecto/index.php");
  }
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}
$qry="";

if(!isset($_GET['id'])){
  header("location:http://localhost/FDW21/proyecto/clientes.php");
}

    if(isset($_GET['Nombre']) && isset($_GET['Correo']) && isset($_GET['Telefono']) && isset($_GET['Direccion']) && isset($_GET['id'])){
        $index=array(); 
        $campos=array();
        $tags = array_keys($_GET); //Obtener nombres de variables get
        $valores = array_values($_GET);//Valores de get
        for($i=0;$i<count($_GET);$i++){
            if($valores[$i]!=""){
                if($tags[$i]!="id"){
                    array_push($index,$tags[$i]);
                    array_push($campos,$valores[$i]);
                }
            }
        }
        $conn = conectDB();
        for($i=0;$i<count($index);$i++){
            $consulta = "update clientes set ".$index[$i]."='".$campos[$i]."' where idCliente=".$_GET['id']." ";
            $rs = mysqli_query($conn,$consulta);
        }
        $msg="Usuario actualizado";
    }
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Editar cliente | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaDatos(){
        if(document.getElementById("Nombre").value == "" &&
          document.getElementById("Correo").value == "" && 
          document.getElementById("Telefono").value == "" &&
          document.getElementById("Direccion").value == "")
        {
          alert("Se necesita minimo una actualización de los datos");
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
            <h3>Editar cliente</h3>
            <div class="alertMsg"><?php if($msg!="") echo $msg;?></div>
            <?php 
                $consulta = "select C.Nombre,C.Correo,C.Telefono,C.Direccion from clientes as C where C.idCliente=".$_GET['id'];
                $rs = mysqli_query(conectDB(),$consulta);
                $profile = mysqli_fetch_object($rs);
                echo "<div class='fw-bold'>Nombre a editar:</div>";
                echo $profile->Nombre."<br><br>";
                echo "<div class='fw-bold'>Correo electronico de usuario a editar:</div>";
                echo $profile->Correo."<br><br>";
                echo "<div class='fw-bold'>Teléfono:</div>";
                echo $profile->Telefono."<br><br>";
                echo "<div class='fw-bold'>Dirección:</div>";
                echo $profile->Direccion."<br><br>";              
            ?>
            <form action="editCliente.php" method="get" onsubmit=" return validaDatos()">
                Ingresa un nuevo nombre para el cliente:<input type="text" id="Nombre" name="Nombre" class="form-control"><br>
                Ingresa un nuevo correo electronico:<input type="text" id="Correo" name="Correo" class="form-control"><br>                
                Ingresa un nuevo telefono:<input type="tel" id="Telefono" name="Telefono" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><br>
                Ingresa una nueva dirección:<input type="text" id="Direccion" name="Direccion" class="form-control"><br>  
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" value="Actualizar cliente" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
</body>
</html>