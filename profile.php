<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
  $rol = recuperaRol(conectDB());
}else{
  header("location:http://localhost/FDW21/proyecto/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Perfil | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script type="text/javascript">
    function confirmaInactiva(){
      if(confirm("¿Estas seguro de querer inactivar tu cuenta?")){
        return confirm("¿Deseas continuar? Tu sesión sera terminada y solo pdoras acceder cuando un administrador cambie tu estado");
      }
      else{
        return false;
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
            <h3>Perfil</h3>
            <?php
                $consulta = "select u.User,u.Status,u.Email,r.NameRol from usuarios as u inner join roles as r on u.idRol=r.idRol where u.idUsuario=".$_SESSION['idU'];
                $rs = mysqli_query(conectDB(),$consulta);
                $profile = mysqli_fetch_object($rs);
                echo "<p class='fs-3 fw-bold'>Nombre:</p>";
                echo "<p class='fs-4'>".$_SESSION['nombre']."<br>";
                echo "<p class='fs-3 fw-bold'>Nombre de usuario:</p>";
                echo "<p class='fs-4'>".$profile->User."<br>";
                echo "<p class='fs-3 fw-bold'>Estado:</p>";
                if($profile->Status == 1){
                  echo " <p class='fs-4'>Activo</p>      <a class='btn btn-danger' href='inactivaUser.php' onclick='return confirmaInactiva()' role='button'>Inactivar mi cuenta</a>";
                }
                else{
                  echo "Inactivo";
                }
                echo "<br><br><p class='fs-3 fw-bold'>Correo electronico:</p>";
                echo "<p class='fs-4'>".$profile->Email."<br>";
                echo "<p class='fs-3 fw-bold'>Rol:</p>";
                echo  "<div style='text-transform:capitalize' class='fs-4'>".$profile->NameRol."</div>";
            ?><br><br>
            <a href="editaProfile.php" class='btn btn-success'>Editar perfil</a>
        </div>
    </div>
  </div>
</body>
</html>

