<?php
session_start();
include("funciones.php");
    //Quien puede acceder a esta página?
    //Autenticado
    //Administrador
    if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
        $conn = conectDB();
        $rolUsr = recuperaRol($conn);
        if($rolUsr !=""){
            //Cambiar estado del usuario
            $qry= "delete from productos where idProducto=".$_GET['id'];
        
            $res = mysqli_query($conn,$qry);
            if(mysqli_affected_rows($conn)>0){
                header("location:http://localhost/FDW21/proyecto/productos.php?err=1");
            }else{
                header("location:http://localhost/FDW21/proyecto/productos.php?err=0");
            }
        }
    }else{
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
    if(!isset($_GET['id'])){
        header("location:http://localhost/FDW21/proyecto/productos.php");
    }
?>