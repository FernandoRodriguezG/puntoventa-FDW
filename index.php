<?php
session_start();
include("menu.php");
include("encabezado.php");
include("funciones.php");
$rol="";
if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])) {
  $rol = recuperaRol(conectDB());
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Sistema de Inventario</title>
  <link href="bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/all.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script type="text/javascript"></script>
</head>
<body>
<?php
  encabezado();
?>
<div class="container-fluid">
    <div class="row flex-nowrap">
    <?php
      menu($rol);
    ?>
      <div class="col py-3">
      <h1 class="text-center">SISTEMA INVENTORY</h1>
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="images/SGI.png" class="d-block w-100" height="500">
          </div>
          <div class="carousel-item">
            <img src="images/bind.jpg" class="d-block w-100" height="500">
          </div>
          <div class="carousel-item">
            <img src="images/inventory.jpg" class="d-block w-100" height="500">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

          <h2 class="text-center">Administrar tu inventario nunca será igual</h2>
          <p>
          El Sistema de Inventario es una solución basada en la web, diseñado para pequeñas 
          y medianas empresas que buscan un sistema completo de gestión de inventario sin 
          reemplazar el software real para la contabilidad. El Sistema de Inventario es lo 
          suficientemente flexible para satisfacer las necesidades de las empresas que requieren 
          un control de inventario y facturación más ágil.
          </p>
          <p>
          Inventory está diseñado para mostrarte la información más importante de tus inventarios 
          y existencias cuando tú la necesites sin importar en donde te encuentres.
          </p>    
          <div class="text-center"><img src="images/invet.jpeg" class="img-fluid rounded" width="200" height="300"></div>
          <br>
          <h4 class="text-center">Actualización de inventario automática para que nunca te quedes sin stock</h2>
          Ordena tus productos de forma automática y evita tener inconvenientes como quedarte sin productos 
          o recomprar alguno que ya tenías en stock. Mantener tu inventario ordenado y actualizado en tiempo real 
          es parte fundamental de tu negocio.<br><br>
          La gestión de inventario es una parte crucial de su negocio, ya sea que tenga una pequeña 
          empresa o una gran empresa de fabricación, venta al por mayor, minorista o cualquier otra industria.<br>
          <div class="text-center"><img src="images/box.png" class="img-fluid rounded" width="200" height="300"></div><br>
          
          <h3 class="text-center">¿Qué es la gestión de inventario?</h3>
          <p>
          El software de gestión de inventario gestiona y controla el inventario actual de una empresa, incluidas sus existencias, 
        compras y ventas. Le ayuda a rastrear toda la información, mantiene existencias efectivas y simplifica los precios de los productos.
          </p>
          <div class="text-center"><img src="images/team.jpg" class="img-fluid rounded" width="300" height="400"></div>
      </div>
    </div>
</div>
</body>
</html>

