<!DOCTYPE html>
<?php
$username = htmlentities($_SESSION['current_user_name'],ENT_QUOTES,'utf-8');
// $userid = htmlentities($_SESSION['current_user_id'],ENT_QUOTES,'utf-8');
$user_type = htmlentities($_SESSION['current_user_type'],ENT_QUOTES,'utf-8');

?>
<html>
<nav class="navbar navbar-default top-navbar" role="navigation" style="box-shadow: 2px 2px 5px 2px #bfbcbc;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <!--Title left up corner-->
                <a class="navbar-brand" href="Dashboard.php">La Guera</a>
            </div>
            <!--Dropdown-->
            <ul class="nav navbar-top-links navbar-right collapse navbar-collapse" id="navbar-collapse" role="navigation">
                <li class="dropdown ">
                    <a href="Dashboard.php" aria-expanded="false">
                        <i class="fa fa-home fa-fw"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="CargarUsuario.php" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i>
                        <b>Usuarios</b> 
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-desktop fa-fw"></i> <i class="fa fa-caret-down"> </i>
                        <b>Inventario</b>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="CargarProducto.php"><i class="fa fa-upload fa-fw"></i> Cargar Producto</a>
                        </li>
                        <li>
                            <a href="VerProductos.php"><i class="fa fa-eye fa-fw"></i> Ver Inventario</a>
                        </li>
                        <!-- <li>
                            <a href="Categorias.php"><i class="fa fa-list fa-fw"></i> Categorias</a>
                        </li> -->
                    </ul>
                </li>
                <li class="dropdown">
                <a href="Categorias.php">
                        <i class="fa fa-list fa-fw"></i> 
                        <b>Categorias</b>                        
                    </a>
                </li>
                <li class="dropdown">                    
                    <a href="Proveedores.php">
                        <i class="fa fa-bar-chart-o fa-fw"></i>
                        <b>Proveedores</b>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="Usuarios.html" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <!-- <li>
                            <a href="Configuracion.html"><i class="fa fa-gear fa-fw"></i> Configuración</a>
                        </li> -->
                        <li>
                            <a href="Ayuda.php"><i class="fa fa-circle-question fa-fw"></i> Ayuda</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <!-- <a href="Usuarios.php"><i class="fa fa-user fa-fw"></i> Usuario</a> -->
                            <a ><i class="fa fa-user fa-fw"></i> <?php echo $username ?></a>
                        </li>
                        <li>
                            <a href="../Login/CerrarSesion.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a> <!-- Cambiar en caso de ser necesario -->
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.dropdown -->
        </nav> 
</html>
