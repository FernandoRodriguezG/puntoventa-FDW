<?php
session_start();
include("funciones.php");
    //Quien puede acceder a esta página?
    //Autenticado
    //Administrador
    if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
            $qry= "delete from usuarios where idUsuario=".$_SESSION['idU'];
            mysqli_query(conectDB(),$qry);
            session_destroy();
            header("location:http://localhost/FDW21/proyecto/index.php");
    }
?>