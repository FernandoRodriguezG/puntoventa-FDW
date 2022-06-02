<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$msg = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());
    if($rol==""){
      header("location:http://localhost/FDW21/proyecto/index.php");
  }
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}
$qry="";
    if(isset($_GET['Nombre']) && isset($_GET['Descripcion']) && isset($_GET['id'])){
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
            $consulta = "update categoria set ".$index[$i]."='".$campos[$i]."' where idCategoria=".$_GET['id']." ";
            $rs = mysqli_query($conn,$consulta);
        }
        $msg="Categoria actualizado";
    }
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Editar categoria| Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaDatos(){
        if(document.getElementById("Nombre").value == "" &&
          document.getElementById("Descripcion").value == "")
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
      menu($rol);
    ?>
        <div class="col py-3">
            <h3>Editar Categoria</h3>
            <div><?php if($msg!="") echo $msg;?></div>
            <?php 
                $consulta = "select Nombre,Descripcion from categoria where idCategoria=".$_GET['id'];
                $rs = mysqli_query(conectDB(),$consulta);
                $fabri = mysqli_fetch_object($rs);
                echo "<div class='fw-bold fs-5'>Nombre actual de la categoria:</div>";
                echo $fabri->Nombre."<br>";
                echo "<div class='fw-bold fs-5'>Descripción actual de la categoría:</div>";
                echo $fabri->Descripcion."<br>";
            ?>
            <form action="editarCat.php" method="get" onsubmit=" return validaDatos()">
               <br> Ingresa un nuevo nombre para la categoria:<input type="text" id="Nombre" name="Nombre" class="form-control"><br>
                Ingresa una nueva descripcion:<input type="text" id="Descripcion" name="Descripcion" class="form-control"><br>  
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" value="Editar categoria" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
        </div>
    </div>
</div>
</body>
</html>