<?php
session_start();
include("funciones.php");
    //Quien puede acceder a esta página?
    //Autenticado
    //Administrador
    if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
        $conn = conectDB();
        $rolUsr = recuperaRol($conn);
        if($rolUsr == "administrador" || $rolUsr == "Vendedor"){
            //Cambiar estado del usuario
            $qry= "delete from clientes where idCliente=".$_GET['id'];
        
            $res = mysqli_query($conn,$qry);
            if(mysqli_affected_rows($conn)>0){
                header("location:http://localhost/FDW21/proyecto/clientes.php?err=1");
            }else{
                header("location:http://localhost/FDW21/proyecto/clientes.php?err=0");
            }
        }
    }else{
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
    if(!isset($_GET['id'])){
        header("location:http://localhost/FDW21/proyecto/clientes.php");
    }
?>