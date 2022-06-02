<?php
function conectDB(){
    return mysqli_connect("localhost","root","","inventario");
}

function recuperaRol($c){
    //El usuario debe estar autenticado $_SESSION["idU"]
    $qry = "select R.nameRol from roles as R inner join usuarios as U on R.idRol=U.idRol where U.idUsuario=".$_SESSION['idU'];
    $rs = mysqli_query($c,$qry);
    $filas = mysqli_fetch_object($rs);
    return $filas->nameRol;
  }
?>