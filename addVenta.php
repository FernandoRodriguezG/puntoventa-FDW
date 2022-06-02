<?php

include("funciones.php");
date_default_timezone_set('America/Mexico_City');
if(!isset($_GET['idCliente']) && count($_GET)<3)
    {
        header("location:http://http://localhost/FDW21/proyecto/nuevaVenta.php?err=1");
    }
if($_GET['idCli'] == "")
    {
        header("location:http://localhost/FDW21/proyecto/nuevaVenta.php?err=2");
    }
$ides=array(); 
$cants=array();
$tags = array_keys($_GET); //Obtener nombres de variables get
$valores = array_values($_GET); //Obtener valores de variables get
for($i=1;$i<count($_GET);$i++){
    if($i%2==1){
        array_push($ides,$tags[$i]); //Obtener IDES de productos de venta
    }
    else{
        array_push($cants,$valores[$i]); //Obtener Cantidades de cada producto en la venta
    }
}
extract($_GET);
$total = 0; //Cantidad total de productos
for($j=0;$j<count($cants);$j++){
    $total = intval($cants[$j]) + $total;
}

$prices = array();
$stock = array();
$categoria = array(); //Categoria de productos para checar promociones
$conn = conectDB(); //Conexion a la DB
for($j=0;$j<count($cants);$j++){
    echo $consulta = "select Precio,Stock,idCategoria from productos where idProducto=".$ides[$j]; //Obtener precios de cada uno de los productos involucrados
    $rs = mysqli_query($conn,$consulta);
    $precio = mysqli_fetch_object($rs);
    array_push($prices,$precio->Precio); //Se guarda en un arreglo todos los productos
    array_push($stock,$precio->Stock);
    array_push($categoria,$precio->idCategoria);  
}

$c = 0;
for($i=0;$i<count($stock);$i++){
    if($stock[$i]>0){
        $c = $c+1;
    }
}

if($c != count($ides)){
    header("location:http://localhost/FDW21/proyecto/nuevaVenta.php?err=5");
}

//Se checa que en las categorias involucradas haya promociones, de ser así, se buscan y se
//hacen los calculos, si no, se procede normal
$promosAplicadas=array();
$descuentos=array();

$promos = "select idPromocion,descuento,id from promociones where fechaInicio<='".date('Y-m-d')."' and fechaFinal>='".date('Y-m-d')."'";
$r = mysqli_query($conn,$promos);


for($i=0;$i<count($ides);$i++){
    while($activas = mysqli_fetch_array($r)){
        if($ides[$i]==$activas['id']){
            array_push($promosAplicadas,$activas['idPromocion']);
            array_push($descuentos,$activas['descuento']);
        }
        else{
            array_push($promosAplicadas,0);
            array_push($descuentos,0);
        }
    }
}

$totalDinero = 0; //Cantidad total de la venta 
for($i=0;$i<count($ides);$i++){
    if($promosAplicadas[$i]>0){
        $prices[$i] = intval($prices[$i]) - intval($prices[$i] * ($descuentos[$i]/100)); 
    }
    $totalDinero = intval($prices[$i])*intval($cants[$i]) + $totalDinero;
}

$pushVenta = "insert into ventas(Fecha,numProductos,precioTotal,idCliente) value ('".date('Y-m-d')."','$total','$totalDinero','$idCli')"; //Consulta para inserción de la venta en DB
$ressInsert = mysqli_query($conn,$pushVenta);

//Actualización de stock en cada uno de los productos
$temp = 0;
$nuevoStock=array();
for($i=0;$i<count($ides);$i++){
    $temp = intval($stock[$i])-intval($cants[$i]);
    array_push($nuevoStock,$temp);
}

for($i=0;$i<count($ides);$i++){
   $update = "update productos set Stock=".$nuevoStock[$i]." where idProducto=".$ides[$i];
    $rs = mysqli_query($conn,$update);
}
//Hacer relacion con la tabla detalleVenta (Se inserta idProducto, idVenta y cuantos de cada producto)
$insert = "";
$consVenta = "Select idVenta from ventas where idCliente=".$idCli." and precioTotal=".$totalDinero." and Fecha='".date('Y-m-d')."'";
$v = mysqli_query($conn,$consVenta);
$venta = mysqli_fetch_object($v);
for($i=0;$i<count($ides);$i++){
    if($promosAplicadas[$i]>0){
        echo $insert = "insert into detallesventa(idProducto,idVenta,cantidad,precioAdquirido,idPromo,Promo) values ('$ides[$i]','$venta->idVenta','$cants[$i]','$prices[$i]','$promosAplicadas[$i]',true)";
    }
    else{
      $insert = "insert into detallesventa(idProducto,idVenta,cantidad,precioAdquirido,idPromo,Promo) values ('$ides[$i]','$venta->idVenta','$cants[$i]','$prices[$i]',0,false)";
    }
    $rs = mysqli_query($conn,$insert);
}

mysqli_close($conn);
header("location:http://localhost/FDW21/proyecto/detallesVenta.php?idV=".$venta->idVenta);
?>