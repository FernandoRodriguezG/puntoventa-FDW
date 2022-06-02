<?php

include("funciones.php");

if(!isset($_GET['txtNombre']) || 
    !isset($_GET['txtUsuario']) || 
    !isset($_GET['txtPwd']) ||
    !isset($_GET['txtRePwd']) ||
    !isset($_GET['txtNombre']) ||
    !isset($_GET['txtEmail']) ||
    !isset($_GET['txtIndicio']))
    {
        header("location:http://http://localhost/FDW21/proyecto/registrate.php?err=1");
    }
if($_GET['txtNombre'] == "" ||
    $_GET['txtUsuario'] == "" ||
    $_GET['txtPwd'] == "" ||
    $_GET['txtRePwd'] == "" ||
    $_GET['txtEmail'] == "" ||
    $_GET['txtInidicio'] == "")
    {
        header("location:http://localhost/FDW21/proyecto/registrate.php?err=2");
    }
if($_GET['txtPwd'] != $_GET['txtRePwd'])
{
    header("location:http://http://localhost/FDW21/proyecto/registrate.php?err=3");
}

extract($_GET); //Crea las variables $txtNombre,$txtUsuario,$txtPwd

$conn = conectDB();
$consulta = "insert into usuarios (Name,User,Password,Status,Email,KeyPwd,idRol) 
            value ('$txtNombre','$txtUsuario','$txtPwd',true,'$txtEmail','$txtIndicio',1)";
$rs = mysqli_query($conn,$consulta);
mysqli_close($conn);
header("location:http://localhost/FDW21/proyecto/registrate.php?err=4");
?>