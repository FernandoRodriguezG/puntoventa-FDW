<?php
include("funciones.php");
        //VERIFICAR QUE EL idA este en la pagina
        if(isset($_GET['idA']) && $_GET['idA']!=""){
            $qry = "select NombreArchivo, TipoArchivo, ContenidoArchivo from archivos where idArchivo=".$_GET['idA'];
            $rs = mysqli_query(conectDB(),$qry);
            $imagen = mysqli_fetch_array($rs);
            header("Content-type:".$imagen['TipoArchivo']);
            echo $imagen["ContenidoArchivo"];
        }
?>