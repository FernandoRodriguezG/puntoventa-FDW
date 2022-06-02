<?php
    function encabezado(){
?>
    <div class="container-fluid" style="background-color:#00A65A;">
        <div class="row">
            <div class="col">
                <a href="index.php"><img src="images/logo.png" width="200" height="70"></a>
            </div>
            <div class="col-2 user">
                <?php
                     if(isset($_SESSION['idU']) && isset($_SESSION['nombre'])){ //Usuario autenticado
                        userAuth($_SESSION['nombre']);
                     }
                     else{
                        registro();
                     }
                ?>
            </div>
        </div>
    </div>
<?php
    }

    function userAuth($Usuario){
?>
    <div class="dropdown ">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user"></i>
            <span class="d-none d-sm-inline mx-1"><?php echo $Usuario; ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
            <li><a class="dropdown-item" href="changePwd.php" >Cambiar contraseña</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar cuenta</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
        </ul>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Estas seguro de querer eliminar tu cuenta?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Tendras que crear una nueva cuenta para iniciar sesión.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a class='btn btn-danger' href='eliminaCuenta.php' role='button'>Eliminar cuenta</a>
      </div>
    </div>
  </div>
</div>
    
<?php
    }

    function registro(){
?>
<div class="dropdown ">
        <a href="registrate.php" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user""></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="registrate.php">Crear cuenta</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="login.php">Iniciar sesión</a></li>
        </ul>
    </div>
<?php
    }
?>