<?php

include("funciones.php");

if(!isset($_POST['Nombre']) || 
    !isset($_POST['Precio']) ||
    !isset($_POST['Descripcion']) ||
    !isset($_POST['Modelo']))
    {
        header("location:http://localhost/FDW21/proyecto/editarProd.php?err=1");
    }
else{
    $index=array(); 
    $campos=array();
    $tags = array_keys($_POST); //Obtener nombres de variables get
    $valores = array_values($_POST);//Valores de get
    for($i=0;$i<count($_POST);$i++){
        if($valores[$i]!=""){
            if($tags[$i]!="id" || $tags[$i]!="imagen"){
                array_push($index,$tags[$i]);
                array_push($campos,$valores[$i]);
            }
        }
    }
    $conn = conectDB();
        for($i=0;$i<count($index);$i++){
            $consulta = "update productos set ".$index[$i]."='".$campos[$i]."' where idProducto=".$_POST['id']." ";
            $rs = mysqli_query($conn,$consulta);
        }
$qry="";
if(!empty($_FILES["imagen"]["tmp_name"])){
        $nombre = $_FILES["imagen"]["name"];
        $tipo = $_FILES["imagen"]["type"];
        $nombreTemporal = $_FILES["imagen"]["tmp_name"];
        $tamanio = $_FILES["imagen"]["size"];
        if($_POST['Nombre']!=""){
            $titulo = $_POST["Nombre"];
        }
        //RECUPERAR CONTENIDO DEL ARCHIVO
        $fp = fopen($nombreTemporal,"r");
        $contenido = fread($fp,$tamanio);
        fclose($fp);

        $contenido = addslashes($contenido);
        if($_POST['Nombre']!=""){
            $qry="update archivos set Titulo='$titulo',NombreArchivo='$nombre',TipoArchivo='$tipo',ContenidoArchivo='$contenido' where idProducto=".$_POST['id'];
        }else{
            $qry="update archivos set NombreArchivo='$nombre',TipoArchivo='$tipo',ContenidoArchivo='$contenido' where idProducto=".$_POST['id'];
        }
        
        mysqli_query($conn,$qry);
}

mysqli_close($conn);
header("location:http://localhost/FDW21/proyecto/editarProd.php?err=3&id=".$_POST['id']);
}
?>