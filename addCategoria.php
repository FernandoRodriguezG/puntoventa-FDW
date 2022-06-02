<?php

include("funciones.php");

if(!isset($_GET['txtNombre']) || 
    !isset($_GET['txtDescripcion']))
    {
        header("location:http://http://localhost/FDW21/proyecto/añadirCategoria.php?err=1");
    }
if($_GET['txtNombre'] == "" ||
    $_GET['txtDescripcion'] == "")
    {
        header("location:http://localhost/FDW21/proyecto/añadirCategoria.php?err=2");
    }
extract($_GET); //Crea las variables $txtNombre,$txtUsuario,$txtPwd

$conn = conectDB();
$consulta = "insert into categoria (Nombre,Descripcion) 
            value ('$txtNombre','$txtDescripcion')";
$rs = mysqli_query($conn,$consulta);
mysqli_close($conn);
header("location:http://localhost/FDW21/proyecto/añadirCategoria.php?err=3");
?>