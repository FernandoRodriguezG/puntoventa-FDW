<?php
function menu($rol){
?>
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 menu">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100 ">
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item ">
                <a href="index.php" class="nav-link align-middle px-0 opMenu">
                <i class="fas fa-home"></i>
                  <span class="ms-1 d-none d-sm-inline">Inicio</span>
                </a>
            </li>
              <?php
              if(isset($_SESSION['idU']) && isset($_SESSION['nombre']) && ($rol=="administrador" || $rol=="Vendedor")){ //Usuario autenticado
                smCompras();
              }
              ?>
              <?php
            if(isset($_SESSION['idU']) && isset($_SESSION['nombre']) && ($rol=="administrador" || $rol=="Vendedor")){ //Usuario autenticado
                  Clientes();
            }
            ?>
            <li>
              <a href="#submenu6" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu">
              <i class="fas fa-cube"></i>
                <span class="ms-1 d-none d-sm-inline">Productos</span></a>
              <ul class="collapse nav flex-column ms-1 smenu" id="submenu6" data-bs-parent="#menu">
              <?php
              if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){ //Usuario autenticado
                smProductos();
              }
              ?>
                <li>
                  <a href="productos.php" class="nav-link px-0 opMenu">
                  <i class="fas fa-list"></i>
                    <span class="d-none d-sm-inline">Mostrar productos </span></a>
                </li>
                
              </ul>
            </li>
            <?php
              if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])  && ($rol=="administrador" || $rol=="Proveedor")){ //Usuario autenticado
                menuFabricantes();
              }
              ?>
            <li>
              <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu">
              <i class="fas fa-th-large"></i>
                <span class="ms-1 d-none d-sm-inline">Categorias</span></a>
              <ul class="collapse nav flex-column ms-1 smenu" id="submenu4" data-bs-parent="#menu">
                <li>
                  <a href="categorias.php" class="nav-link px-0 opMenu">
                  <i class="fas fa-list"></i>
                    <span class="d-none d-sm-inline">Mostrar categorias </span></a>
                </li>
                <?php
                  if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){ //Usuario autenticado
                    smCategorias();
                  }
                ?>
              </ul>
            </li>
            <li>
              <a href="#submenu5" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu">
              <i class="fas fa-percent"></i>
                <span class="ms-1 d-none d-sm-inline">Promociones</span></a>
              <ul class="collapse nav flex-column ms-1 smenu" id="submenu5" data-bs-parent="#menu">
              <?php
                  if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){ //Usuario autenticado
                    smPromociones();
                  }
                ?>
                <li>
                  <a href="promociones.php" class="nav-link px-0 opMenu">
                  <i class="fas fa-list"></i>
                    <span class="d-none d-sm-inline">Ver promociones activas</span></a>
                </li>
                <li>
                  <a href="promocionesPasadas.php" class="nav-link px-0 opMenu">
                  <i class="fas fa-times-circle"></i>
                    <span class="d-none d-sm-inline">Ver promociones pasadas</span></a>
                </li>
                <li>
                  <a href="promocionesFuturas.php" class="nav-link px-0 opMenu">
                  <i class="fas fa-arrow-circle-right"></i>
                    <span class="d-none d-sm-inline">Ver promociones futuras</span></a>
                </li>
              </ul>
            </li>
            <?php
            if(isset($_SESSION['idU']) && isset($_SESSION['nombre']) && $rol=="administrador"){ //Usuario autenticado
                  configUsuarios();
            }
            ?>
          </ul>
          <hr />
        </div>
      </div>
<?php
}
?>

<?php
function configUsuarios(){
?>
<li>
  <a href="#submenu7" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu">
    <i class="fas fa-users-cog"></i>
    <span class="ms-1 d-none d-sm-inline">Configuración de usuarios</span></a>
  <ul class="collapse nav flex-column ms-1 smenu" id="submenu7" data-bs-parent="#menu">
    <li class="w-100">
      <a href="users.php" class="nav-link px-0 opMenu">
      <i class="fas fa-list"></i>
        <span class="d-none d-sm-inline">Listado de usuarios</span></a>
    </li>
    <li class="w-100">
      <a href="roles.php" class="nav-link px-0 opMenu">
      <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Crear nuevo rol</span></a>
    </li>
  </ul>
</li>
<?php
}

function smCompras(){
?>
<li>
  <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu" >
    <i class="fas fa-truck-moving"></i>
    <span class="ms-1 d-none d-sm-inline">Ventas</span>
  </a>
  <ul class="collapse nav flex-column ms-1 smenu" id="submenu1" data-bs-parent="#menu">
    <li class="w-100">
      <a href="nuevaVenta.php" class="nav-link px-0 opMenu">
        <i class="fas fa-file"></i>
        <span class="d-none d-sm-inline">Nueva venta</span>
      </a>
    </li>
    <li>
      <a href="ventas.php" class="nav-link px-0 opMenu">
        <i class="fas fa-history"></i>
        <span class="d-none d-sm-inline">Historial de ventas</span>
      </a>
    </li>
    <li>
      <a href="buscaVenta.php" class="nav-link px-0 opMenu">
       <i class="fas fa-search"></i>
       <span class="d-none d-sm-inline">Buscar ventas </span></a>
    </li>
  </ul>
</li>
<?php
}

function smProductos(){
?>
<li class="w-100">
  <a href="nuevoProducto.php" class="nav-link px-0 opMenu">
    <i class="fas fa-plus"></i>
    <span class="d-none d-sm-inline">Nuevo producto </span></a>
</li>
<li>
                  <a href="buscaProducto.php" class="nav-link px-0 opMenu">
                  <i class="fas fa-search"></i>
                    <span class="d-none d-sm-inline">Buscar productos </span></a>
                </li>
<?php
}

function smCategorias(){
?>
<li class="w-100">
  <a href="añadirCategoria.php" class="nav-link px-0 opMenu">
    <i class="fas fa-plus"></i>
     <span class="d-none d-sm-inline">Nueva categoria </span></a>
</li>
<?php
}

function smPromociones(){
?>
<li class="w-100">
  <a href="nuevaPromocionProd.php" class="nav-link px-0 opMenu">
    <i class="fas fa-plus"></i>
    <span class="d-none d-sm-inline">Nueva promoción </span></a>
</li>      
<li>
      <a href="buscaPromo.php" class="nav-link px-0 opMenu">
       <i class="fas fa-search"></i>
       <span class="d-none d-sm-inline">Buscar Promoción</span></a>
    </li>        
<?php
}

function menuFabricantes(){
?>
<li>
  <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu">
    <i class="fas fa-tag"></i>
    <span class="ms-1 d-none d-sm-inline">Fabricantes</span></a>
  <ul class="collapse nav flex-column ms-1 smenu" id="submenu2" data-bs-parent="#menu">
    <li class="w-100">
      <a href="nuevoFabricante.php" class="nav-link px-0 opMenu">
        <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Nuevo fabricante</span></a>
    </li>
    <li>
      <a href="fabricantes.php" class="nav-link px-0   opMenu">
        <i class="fas fa-list"></i>
        <span class="d-none d-sm-inline">Ver fabricantes</span></a>
    </li>
    <li>
      <a href="buscaFabricante.php" class="nav-link px-0 opMenu">
       <i class="fas fa-search"></i>
       <span class="d-none d-sm-inline">Buscar Fabricante</span></a>
    </li>
  </ul>
</li>
<?php
}
function Clientes(){
?>
<li>
  <a href="#submenu9" data-bs-toggle="collapse" class="nav-link px-0 align-middle opMenu">
  <i class="fas fa-user-tie"></i>
    <span class="ms-1 d-none d-sm-inline">Clientes</span></a>
  <ul class="collapse nav flex-column ms-1 smenu" id="submenu9" data-bs-parent="#menu">
    <li class="w-100">
      <a href="clientes.php" class="nav-link px-0 opMenu">
      <i class="fas fa-list"></i>
        <span class="d-none d-sm-inline">Lista de clientes</span></a>
    </li>
    <li class="w-100">
      <a href="nuevoCliente.php" class="nav-link px-0 opMenu">
      <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Añadir cliente</span></a>
    </li>
    <li class="w-100">
      <a href="buscaCliente.php" class="nav-link px-0 opMenu">
      <i class="fas fa-search"></i>
        <span class="d-none d-sm-inline">Buscar cliente</span></a>
    </li>
    
  </ul>
</li>
<?php
}
?>