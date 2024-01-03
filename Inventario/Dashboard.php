<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once '../Inventario/head.php';
session_start();

if (!isset($_SESSION['current_user_id'])) {
    header('Location: ../Login/Expired.php');
    exit();
}
?>

<body>
    <div id="wrapper">
        <?php include_once '../Inventario/Top-navbar.php'; ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Bienvenid@: <b><?php echo $username ?></b> </h1>
                    </div>
                </div>
                <!--Panel verde-->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-green">
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
                <!-- Copyright  -->
                <footer>
                    <p>Derechos reservados. Roberto Hernandez</p>
                </footer>
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