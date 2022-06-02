<?php

include("funciones.php");

if(!isset($_POST['txtNombre']) || 
    !isset($_POST['txtPrecio']) ||
    !isset($_POST['txtDescripcion']) ||
    !isset($_POST['txtStock']) ||
    !isset($_POST['txtModelo']))
    {
        header("location:http://http://localhost/FDW21/proyecto/nuevoProducto.php?err=1");
    }
if($_POST['txtNombre'] == "" ||
    $_POST['txtPrecio'] == "" ||
    $_POST['txtDescripcion'] == "" ||
    $_POST['txtStock'] == "" ||
    $_POST['txtModelo'] == "")
    {
        header("location:http://localhost/FDW21/proyecto/nuevoProducto.php?err=2");
    }
extract($_POST); //Crea las variables $txtNombre,$txtUsuario,$txtPwd

$conn = conectDB();
$consulta = "insert into productos (Precio,Descripcion,idFabricante,Nombre,Stock,Status,idCategoria,Modelo) 
            values ('$txtPrecio','$txtDescripcion','$idFabricante','$txtNombre','$txtStock',true,'$idCategoria','$txtModelo')";
$rs = mysqli_query($conn,$consulta);

$cons = "select idProducto from productos where Modelo='".$txtModelo."'";
$id = mysqli_query($conn,$cons);
$prod= mysqli_fetch_array($id);
if(!empty($_FILES["imagen"]["tmp_name"])){
        $nombre = $_FILES["imagen"]["name"];
        $tipo = $_FILES["imagen"]["type"];
        $nombreTemporal = $_FILES["imagen"]["tmp_name"];
        $tamanio = $_FILES["imagen"]["size"];
        $titulo = $_POST["txtNombre"];

        //RECUPERAR CONTENIDO DEL ARCHIVO
        $fp = fopen($nombreTemporal,"r");
        $contenido = fread($fp,$tamanio);
        fclose($fp);

        $contenido = addslashes($contenido);
        $qry="insert into archivos (idProducto,Titulo,NombreArchivo,TipoArchivo,ContenidoArchivo) values (".$prod["idProducto"].",'$titulo','$nombre','$tipo','$contenido')";
        mysqli_query($conn,$qry);
        mysqli_close($conn);
        header("location:http://localhost/FDW21/proyecto/nuevoProducto.php?err=4");
}

?>