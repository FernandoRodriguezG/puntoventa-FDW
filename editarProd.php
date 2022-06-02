<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$Rol="";
$msg = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
  $Rol = recuperaRol(conectDB());
  if($Rol==""){
      header("location:http://localhost/FDW21/proyecto/index.php");
  }
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}
$qry="";
if(isset($_GET['err'])){
  if($_GET['err']==3){
    $msg="Producto actualizado";
  }
}
if(!isset($_GET['id'])){
  header("location:http://localhost/FDW21/proyecto/productos.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Editar producto | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaDatos(){
        if(document.getElementById("Nombre").value == "" &&
          document.getElementById("Precio").value == "" && 
          document.getElementById("Descripcion").value == "" &&
          document.getElementById("Modelo").value == "" && 
          document.getElementById("imagen").value=="")
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
            <h3>Editar información del producto</h3>
            <div class="alertMsg"><?php if($msg!="") echo $msg;?></div>
            <?php 
                $consulta = "select productos.*,F.Nombre as fabName,C.Nombre as catName from productos inner join fabricantes as F on 
                productos.idFabricante=F.idFabricante inner join categoria as C on productos.idCategoria=C.idCategoria where productos.idProducto=".$_GET['id'];
                $rs = mysqli_query(conectDB(),$consulta);
                $profile = mysqli_fetch_object($rs);
                echo "<div class='fw-bold fs-5'>Producto:</div>";
                echo $profile->Nombre."<br>";
                echo "<div class='fw-bold fs-5'>Fabricante:</div>";
                echo $profile->fabName."<br>";
                echo "<div class='fw-bold fs-5'>Precio:</div>";
                echo $profile->Precio."<br>";
                echo "<div class='fw-bold fs-5'>Descripción:</div>";
                echo $profile->Descripcion."<br>";
                echo "<div class='fw-bold fs-5'>Categoria:</div>";
                echo $profile->catName."<br>";  
                echo "<div class='fw-bold fs-5'>Modelo:</div>";
                echo $profile->Modelo."<br>";   
                $qry = "select * from archivos where idProducto=".$_GET['id'];
                $ress = mysqli_query(conectDB(),$qry);
                if(mysqli_num_rows($ress)>0){
                    //Encontro archivos
                    while($archivo = mysqli_fetch_array($ress)){
                        echo "<img style='width:100px; height:100px' src='imagen.php?idA=".$archivo["idArchivo"]."' alt='".$archivo["Titulo"]."'>";
                    }
                }         
            ?>
            <form action="editProducto.php" method="post" onsubmit=" return validaProd()" enctype="multipart/form-data">
                Ingresa el nuevo nombre del producto: 
                <input type="text" id="Nombre" name="Nombre" class="form-control">
                Ingresa el nuevo precio: 
                <input type="number" id="Precio" name="Precio" class="form-control">
                Nueva descripción del producto: 
                <input type="text" id="Descripcion" name="Descripcion" class="form-control">
                Nuevo Fabricante: 
                <select name="idFabricante" class="form-select" aria-label="Default select example">
                              <?php
                                  $qry = "select idFabricante,Nombre from fabricantes";
                                  $res = mysqli_query(conectDB(),$qry);
                                  while($datosFab = mysqli_fetch_object($res)){
                                      echo "<option value='".$datosFab->idFabricante."'>".$datosFab->Nombre."</option>";
                                  }
                              ?>
                </select>
                Categoria del producto: 
                <select name="idCategoria" class="form-select" aria-label="Default select example">
                              <?php
                                  $qry = "select idCategoria,Nombre from categoria";
                                  $res = mysqli_query(conectDB(),$qry);
                                  while($datosCat = mysqli_fetch_object($res)){
                                      echo "<option value='".$datosCat->idCategoria."'>".$datosCat->Nombre."</option>";
                                  }
                              ?>
                </select>
                Modelo:
                <input type="text" id="Modelo" name="Modelo" class="form-control"><br>
                Selecciona imagen para el producto:<br>
                <input type="file" name="imagen" id="imagen" accept="image/*"><br><br><br>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" value="Editar producto" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
</body>
</html>