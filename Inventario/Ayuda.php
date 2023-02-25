<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../Inventario/head.php';
session_start();

if (!isset($_SESSION['current_user_id'])) { 
    header('Location: ../Login/Expired.php');
    exit();
}  ?>


<body>
    <div id="wrapper">
    <?php include '../Inventario/Top-navbar.php'; ?>

        
        
        
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Empty Page <small>Create new page.</small>
                        </h1>
                    </div>
                </div> 
                
                <!-- Copy right  -->
                <footer><p>Roberto Hernandez, 2021</a></p></footer>
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
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
    
</body>
</html>
