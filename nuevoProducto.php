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
    if($_GET['err']==4){
      $error="Producto añadido correctamente";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Nuevo producto | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaProducto(){   
    if (document.getElementById("txtNombre").value == "" ||
        document.getElementById("txtPrecio").value == "" ||
        document.getElementById("txtDescripcion").value == "" ||
        document.getElementById("txtStock").value == "" ||
        document.getElementById("txtModelo").value == "" || 
        document.getElementById("imagen").value=="") {
        alert("Todos los campos son requeridos");
        return false;
    }
    else{
      if(document.getElementById("txtStock").value <= "0"){
        alert("El stock del nuevo producto no puede ser 0");
        return false;
      }
      else{
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
    <h3>Añadir producto</h3>
    <div class="alertMsg"><?php if($error!="") echo $error;?></div>
    <form action="addProducto.php" method="post" onsubmit=" return validaProducto()" enctype="multipart/form-data">
      Ingresa el nombre del producto: 
      <input type="text" id="txtNombre" name="txtNombre" class="form-control">
      Ingresa el precio: 
      <input type="number" id="txtPrecio" name="txtPrecio" class="form-control">
      Descripción del producto: 
      <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control">
      Fabricante: 
      <?php
      echo "<select name='idFabricante' class='form-select' aria-label='Default select example'>";
                    
                        $qry = "select idFabricante,Nombre from fabricantes";
                        $res = mysqli_query(conectDB(),$qry);
                        if(mysqli_num_rows($res)){
                          while($datosFab = mysqli_fetch_object($res)){
                            echo "<option value='".$datosFab->idFabricante."'>".$datosFab->Nombre."</option>";
                        }
                        }else{
                          echo "No hay fabricantes para asociar con el producto";
                          echo "<a class='btn btn-primary' href='nuevoFabricante.php' role='button'>Añadir fabricante</a>";
            
                        }
                        
                    
      echo "</select>";
      ?>
      
      <br>Ingresa el stock:
      <input type="number" id="txtStock" name="txtStock" class="form-control" >
      Categoria del producto: 
      <?php
      echo "<select name='idCategoria' class='form-select' aria-label='Default select example'>";
                    
                        $qry = "select idCategoria,Nombre from categoria";
                        $res = mysqli_query(conectDB(),$qry);
                        if(mysqli_num_rows($res)){
                          while($datosCat = mysqli_fetch_object($res)){
                            echo "<option value='".$datosCat->idCategoria."'>".$datosCat->Nombre."</option>";
                        }
                        }else{
                          echo "No hay categorias para asociar con el producto";
                          echo " <a class='btn btn-primary' href='añadirCategoria.php' role='button'>Añadir Categoria</a>";
                        }
                        
                    
      echo "</select>";
      ?>
      ¿No encuentras la categoria que deseas? <a href="añadirCategoria.php">Click aquí para añadir categoria </a>
      <br>Modelo:
      <input type="text" id="txtModelo" name="txtModelo" class="form-control"><br>
      Selecciona imagen para el producto:<br>
      <input type="file" name="imagen" id="imagen" accept="image/*" ><br><br>
      <input type="submit" value="Añadir producto" class="btn btn-primary">
      <input type="reset" value="Cancelar" class="btn btn-danger">
    </form>
        </div>
    </div>
</div>
</body>
</html>