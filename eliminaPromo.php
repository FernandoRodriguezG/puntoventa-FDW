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
            $qry= "delete from promociones where idPromocion=".$_GET['id'];
        
            $res = mysqli_query($conn,$qry);
            if(mysqli_affected_rows($conn)>0){
                if($_GET['p']==1)
                header("location:http://localhost/FDW21/proyecto/promociones.php?err=1");
                if($_GET['p']==2)
                header("location:http://localhost/FDW21/proyecto/promocionesFuturas.php?err=1");
                if($_GET['p']==3)
                header("location:http://localhost/FDW21/proyecto/promocionesPasadas.php?err=1");
            }else{
                if($_GET['p']==1)
                header("location:http://localhost/FDW21/proyecto/promociones.php?err=0");
                if($_GET['p']==2)
                header("location:http://localhost/FDW21/proyecto/promocionesFuturas.php?err=0");
                if($_GET['p']==3)
                header("location:http://localhost/FDW21/proyecto/promocionesPasadas.php?err=0");
            }
        }
    }else{
        header("location:http://localhost/FDW21/proyecto/index.php");
    }
    if(!isset($_GET['id'])){
        header("location:http://localhost/FDW21/proyecto/promociones.php");
    }
?>