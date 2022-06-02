<?php
session_start();
include("funciones.php");
    //Quien puede acceder a esta página?
    //Autenticado
    //Administrador
    if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
        $conn = conectDB();
        $rolUsr = recuperaRol($conn);
        if($rolUsr =="administrador"){
            //Cambiar estado del usuario
            $qry= "delete from usuarios where idUsuario=".$_GET['id'];
            mysqli_query($conn,$qry);
            header("location:http://localhost/FDW21/proyecto/users.php");
        }
    }
?>