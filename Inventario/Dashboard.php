<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><!--Cambiar-->
<?php include '../Inventario/head.php';
session_start();

if (!isset($_SESSION['current_user_id'])) { 
    header('Location: ../Login/Expired.php');
    exit();
} 
?>

<body>
    <div id="wrapper">
        <?php include '../Inventario/Top-navbar.php'; ?>
        <!-- h1  -->
        <div id="page-wrapper">
            <div id="page-inner">                
                <!-- h1-->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Bienvenid@: <b><?php echo $username ?></b>  </h1>
                    </div>
                </div>
                <!-- h1-->
                <!--Panel verde-->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-green" >
                            <div class="panel-body">
                                <i class="fa fa-desktop fa-5x"></i>
                                <!-- funcion para mostrar el total de productos -->
                                <?php
                                $query = $pdo->query("SELECT COUNT(product_id) FROM Products_tbl; "); ?>
                                <h3><b><?php echo $query->fetchColumn(); ?></b></h3>                                                                                             
                            </div>
                            <div class="panel-footer back-footer-green">
                                Total de productos
                            </div>
                        </div>
                    </div>
                    <!-- /Panel verde -->
                    <!--Panel azul-->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-blue">
                            <div class="panel-body">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                                <?php
                                $query = $pdo->query("SELECT COUNT(category_id) FROM categories_tbl; "); ?>
                                <h3><b><?php echo $query->fetchColumn(); ?></b></h3>  
                            </div>
                            <div class="panel-footer back-footer-blue">
                                Categorias
                            </div>
                        </div>
                    </div>
                    <!--Panel azul-->
                    <!--Panel rojo-->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-red">
                            <div class="panel-body">
                                <i class="fa fa fa-bar-chart-o fa-5x"></i>
                                <?php
                                $query = $pdo->query("SELECT COUNT(supplier_id) FROM supplier_tbl; "); ?>
                                <h3><b><?php echo $query->fetchColumn(); ?></b></h3> 
                            </div>
                            <div class="panel-footer back-footer-red">
                                Proveedores
                            </div>
                        </div>
                    </div>
                    <!-- panel rojo -->
                    <!-- panel naranja -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-brown">
                            <div class="panel-body">
                                <i class="fa fa-users fa-5x"></i>
                                <?php
                                $query = $pdo->query("SELECT COUNT(user_id) FROM user_tbl; "); ?>
                                <h3><b><?php echo $query->fetchColumn(); ?></b></h3> 
                            </div>
                            <div class="panel-footer back-footer-brown">
                                Usuarios
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /panel naranja -->
                
                <div class="row">
                    <!-- Bar table -->
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Ejemplo de tabla de barras
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- donut table -->
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Donut Chart Example
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!--Panel de tareas-->
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Panel de tareas
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <span class="badge">7 minutes ago</span>
                                        <i class="fa fa-fw fa-comment"></i> Commented on a post
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">16 minutes ago</span>
                                        <i class="fa fa-fw fa-truck"></i> Order 392 shipped
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">36 minutes ago</span>
                                        <i class="fa fa-fw fa-globe"></i> Invoice 653 has paid
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">1 hour ago</span>
                                        <i class="fa fa-fw fa-user"></i> A new user has been added
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">1.23 hour ago</span>
                                        <i class="fa fa-fw fa-user"></i> A new user has added
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">yesterday</span>
                                        <i class="fa fa-fw fa-globe"></i> Saved the world
                                    </a>
                                </div>
                                <div class="text-right">
                                    <a href="#">Mas tareas <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--Tabla responsiva-->
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Responsive Table Example
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>S No.</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>User Name</th>
                                                <th>Email ID.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>John</td>
                                                <td>Doe</td>
                                                <td>John15482</td>
                                                <td>name@site.com</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Kimsila</td>
                                                <td>Marriye</td>
                                                <td>Kim1425</td>
                                                <td>name@site.com</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Rossye</td>
                                                <td>Nermal</td>
                                                <td>Rossy1245</td>
                                                <td>name@site.com</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Richard</td>
                                                <td>Orieal</td>
                                                <td>Rich5685</td>
                                                <td>name@site.com</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Jacob</td>
                                                <td>Hielsar</td>
                                                <td>Jac4587</td>
                                                <td>name@site.com</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Wrapel</td>
                                                <td>Dere</td>
                                                <td>Wrap4585</td>
                                                <td>name@site.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Copyright  -->
                <footer><p>Derechos reservados. Roberto Hernandez</p></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
</body>
</html>