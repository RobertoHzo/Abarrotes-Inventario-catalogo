<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../Inventario/head.php';
session_start();
?>


<body>

    <div id="wrapper">
        <?php include '../Inventario/Top-navbar.php'; ?>        
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header" style="text-align: center;">
                            PROHIBIDO EL ACCESO
                        </h1>
                    </div>
                </div>
                <br>
                <div class="row" style="text-align: center;">
                <h1><i class="fa fa-exclamation-triangle fa-fw"></i></h1>
                </div>
                <br>
                <div class="row">
                    <H1 style="text-align: center;">¡No tiene los permisos necesarios para acceder a esta pagina!</H1>
                </div>
                
                <!-- /. PAGE INNER  -->
            <!-- /. PAGE WRAPPER  -->
        </div>
    </div>
    </div>
        <!-- /. WRAPPER  -->
        <!-- JS Scripts-->
        <!-- jQuery Js -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- Bootstrap Js -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Metis Menu Js -->
        <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <!-- <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script> -->
        <script type="text/javascript" src="../Inventario/assets/DataTables/datatables.min.js"></script>
        <script>
             $(document).ready(function() {
                $('#example').DataTable( {
                
                "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "No se ha encontrdo ningun registro",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)"
        }
               
                } );
            } );
        </script>
        <!-- Custom Js -->
        <script src="assets/js/custom-scripts.js"></script>              
    </body>
    </html>