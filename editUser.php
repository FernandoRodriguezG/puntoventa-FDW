<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$msg = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());
    if($rol != "administrador"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}

if(!isset($_GET['id'])){
    header("location:http://localhost/FDW21/proyecto/users.php");
}
$qry="";
    if(isset($_GET['txtUser']) && isset($_GET['txtEmail']) && isset($_GET['txtIndicio']) && isset($_GET['id'])){
        if($_GET['txtUser']!=""){
            if($_GET['txtEmail']!=""){
                if($_GET['txtIndicio']!=""){
                    $qry = "update usuarios set KeyPwd='".$_GET['txtIndicio']."', Email='".$_GET['txtEmail']."',User='".$_GET['txtUser']."' where idUsuario=".$_GET['id'];
                    //Tres actualizaciones
                    $msg="Se actualizaron todos los datos";
                }else{
                    //Se actualizan email y user
                    $qry = "update usuarios set Email='".$_GET['txtEmail']."',User='".$_GET['txtUser']."' where idUsuario=".$_GET['id'];
                    $msg="Se actualizaron el correco electronico y el usuario";
                }
            }
            else{
                if($_GET['txtIndicio']!=""){
                    //Se actualiza inidicio y user
                    $qry = "update usuarios set KeyPwd='".$_GET['txtIndicio']."', User='".$_GET['txtUser']."' where idUsuario=".$_GET['id'];
                    $msg="Se actualizaron el indicio de la contraseña y el usuario";
                }
                else{
                    //Se actualiza User
                    $qry = "update usuarios set User='".$_GET['txtUser']."' where idUsuario=".$_GET['id'];
                    $msg="Se actualizo el usuario";
                }
            }
        }
        else{
            if($_GET['txtEmail']!=""){
                if($_GET['txtIndicio']!=""){
                    //Se actualiza email e indicio
                    $qry = "update usuarios set KeyPwd='".$_GET['txtIndicio']."', Email='".$_GET['txtEmail']."' where idUsuario=".$_GET['id'];
                    $msg="Se actualizaron el correo electronico y el indicio de contraseña";
                }
                else{
                    //Se Actualiza email
                    $qry = "update usuarios set Email='".$_GET['txtEmail']."' where idUsuario=".$_GET['id'];
                    
                    $msg="Se actualizo el correo electronico";
                }
            }else{
                if($_GET['txtIndicio']!=""){
                    //Se actualiza inidicio
                    $qry = "update usuarios set KeyPwd='".$_GET['txtIndicio']."' where idUsuario=".$_GET['id'];
                    
                    $msg="Se actualizo el indicio de contraseña";
                }
                else{
                    $msg="No hay capos con datos para hacer una actualización";
                }
            }
        }
            $rs = mysqli_query(conectDB(),$qry);
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Editar usuario | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function validaDatos(){
        if(document.getElementById("txtUser").value == "" &&
          document.getElementById("txtEmail").value == "" && 
          document.getElementById("txtIndicio").value == "")
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
            <h3>Editar perfil de usuario</h3>
            <div class="alertMsg"><?php if($msg!="") echo $msg;?></div>
            <?php 
                $consulta = "select u.User,u.Email from usuarios as u where u.idUsuario=".$_GET['id'];
                $rs = mysqli_query(conectDB(),$consulta);
                $profile = mysqli_fetch_object($rs);
                echo "<div class='fw-bold fs-5'>Nombre de usuario a editar:</div>";
                echo $profile->User."<br>";
                echo "<div class='fw-bold fs-5'>Correo electronico de usuario a editar:</div>";
                echo $profile->Email."<br>";            
            ?><br>
            <form action="editUser.php" method="get" onsubmit=" return validaDatos()">
                Ingresa un nuevo nombre de usuario:<input type="text" id="txtUser" name="txtUser" class="form-control"><br>
                Ingresa un nuevo correo electronico:<input type="text" id="txtEmail" name="txtEmail" class="form-control"><br>                
                Ingresa un nuevo indicio de contraseña:<input type="text" id="txtIndicio" name="txtIndicio" class="form-control"><br>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" value="Actualizar datos" class="btn btn-primary">
                <input type="reset" value="Cancelar" class="btn btn-danger">
            </form>
            ¿Quieres cambiar la contraseña del usuario? <a  href="cambiaUserPwd.php?id=<?php echo $_GET['id'];?>">Click aquí.</a>
        </div>
    </div>
</div>
</body>
</html>