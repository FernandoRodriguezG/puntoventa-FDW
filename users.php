<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
$error = "";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){
    $rol = recuperaRol(conectDB());
    if($rol != "administrador"){
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
}else{
    header("location:http://localhost/FDW21/proyecto/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Usuarios | Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <script src="validaciones.js" ></script>
  <script type="text/javascript">
    function confirmaStatus(){
        return confirm("¿Deseas continuar con el cambio de estado del usuario?");
    }
    function confirmDelete(){
        if(confirm("¿Estas seguro de querer eliminar al usuario?")){
            return confirm("Su cuenta quedara eliminada y no podra acceder más,¿Deseas continuar?");
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
            <h3>Listado de Usuarios</h3>
            <a class="btn btn-primary" href="addUser.php" role="button">Añadir usuario</a>
            <?php
            //Listado de usuarios para mostrar al administrador
            $cons = "select usuarios.*,roles.nameRol as NombreRol from usuarios inner join roles on roles.idRol=usuarios.idRol";
            $res = mysqli_query(conectDB(),$cons);
            if(mysqli_num_rows($res)){
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nombre</th>";
                echo "<th scope='col'>Usuario</th>";
                echo "<th scope='col'>Estado</th>";
                echo "<th scope='col'>Correo electronico</th>";
                echo "<th scope='col'>Rol</th>";  
                echo "<th scope='col'></th>";           
                echo "</tr>";
                echo "</thead>";
                while($dUser = mysqli_fetch_array($res)){
                    echo "<tr>";
                        echo "<td>".$dUser["Name"]."</td>";
                        echo "<td>".$dUser["User"]."</td>";
                        if($dUser["Status"]==1){
                            echo "<td> Activo </td>";
                        }else{
                            echo "<td> Inactivo </td>";
                        }
                        echo "<td>".$dUser["Email"]."</td>";
                        echo "<td style='text-transform: capitalize;'>".$dUser["NombreRol"]."</td>";
                        echo "<td>";
                        ?>
                        <div class="dropdown ">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <button type="button" class="btn btn-primary">Acciones</button>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="cambiaRol.php?id=<?php echo $dUser["idUsuario"]; ?>">Cambiar rol</a></li>
                                <?php
                                if($dUser["idUsuario"]!=$_SESSION['idU']){
                                    echo "<li><a onclick='return confirmDelete()' class='dropdown-item' href='deleteUser.php?id=".$dUser["idUsuario"]."'>Eliminar usuario</a></li>";
                                    echo "<li><a class='dropdown-item' href='editUser.php?id=".$dUser["idUsuario"]."'>Editar usuario</a></li>";
                                }
                                ?>
                        <?php
                        if($dUser["idUsuario"]!=$_SESSION['idU']){
                            if($dUser["Status"]==1){
                                echo "<li><a class='dropdown-item' onclick='return confirmaStatus()' href='inactivar.php?id=".$dUser["idUsuario"]."'>Inactivar usuario</a></li>";
                            }else{
                                echo "<li><a class='dropdown-item' onclick='return confirmaStatus()' href='activar.php?id=".$dUser["idUsuario"]."'>Activar usuario</a></li>";
                            }
                        }
                        ?>     
                            </ul>
                        </div>
                        <?php
                        echo "</td>";
                    echo "</tr>";
                }
                    echo "</table>";
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>