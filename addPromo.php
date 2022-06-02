<?php

include("funciones.php");

if(!isset($_GET['txtNombre']) || 
    !isset($_GET['txtDescripcion']) || 
    !isset($_GET['txtFechaInicio']) ||
    !isset($_GET['txtFechaFin']) ||
    !isset($_GET['txtDescuento']))
    {
        header("location:http://http://localhost/FDW21/proyecto/nuevaPromocion.php?err=1");
    }
if($_GET['txtNombre'] == "" ||
    $_GET['txtDescripcion'] == "" ||
    $_GET['txtFechaInicio'] == "" ||
    $_GET['txtFechaFin'] == "" ||
    $_GET['txtDescuento'] == "")
    {
        header("location:http://localhost/FDW21/proyecto/nuevaPromocion.php?err=2");
    }
extract($_GET); //Crea las variables $txtNombre,$txtUsuario,$txtPwd

$conn = conectDB();
$consulta = "insert into promociones (fechaInicio,fechaFinal,descuento,id,Nombre,Descripcion) 
            value ('$txtFechaInicio','$txtFechaFin','$txtDescuento','$id','$txtNombre','$txtDescripcion')";
$rs = mysqli_query($conn,$consulta);
mysqli_close($conn);
header("location:http://localhost/FDW21/proyecto/promociones.php?err=4");
?>