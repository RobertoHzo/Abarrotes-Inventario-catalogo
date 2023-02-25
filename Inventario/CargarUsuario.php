<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../Inventario/head.php';
// session_start();

// if ($_SESSION['current_user_type'] == 'Empleado'){
//     header('Location: ProhibidoAcceso.php');
    
//     } 
// else if (!isset($_SESSION['current_user_id'])) { 
//     header('Location: ../Login/Expired.php');
//     exit();
// }
 ?>


<body>
<?php
//debemos revisar si los input tienen informacion
//isset(what we check)-?-if true-:-if false;
$txtID = (isset($_POST['txtID']))?$_POST['txtID']:""; //['nombre/id de su input en el formulario']
$nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";
$typ = (isset($_POST['typ']))?$_POST['typ']:"";
$email = (isset($_POST['email']))?$_POST['email']:"";
$pass = (isset($_POST['pass']))?$_POST['pass']:"";
$password_hash = password_hash($pass, PASSWORD_BCRYPT);//encriptacion
$accion = (isset($_POST['accion']))?$_POST['accion']:"";

switch ($accion) {
    case 'add':
        $sentenciaSQL = $pdo->prepare("INSERT INTO user_tbl (name_user,email_user,pass_user,type_user,datemod_user ) 
        VALUES (:name_user,:email_user,:pass_user,:type_user,NOW() );"); 
    $sentenciaSQL->bindParam(':name_user', $nombre);
    $sentenciaSQL->bindParam(':email_user', $email);
    $sentenciaSQL->bindParam(':pass_user', $password_hash);    
    $sentenciaSQL->bindParam(':type_user', $typ);

    $sentenciaSQL->execute();
    header('Location: CargarUsuario.php');
        break;
    case 'Modify':
        $sentenciaSQL = $pdo->prepare("UPDATE user_tbl 
            SET name_user = :names, 
            email_user = :email_user,
            type_user = :type_us,
            datemod_user = now()
            WHERE user_id=:id"); 
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':names', $nombre);
            $sentenciaSQL->bindParam(':email_user', $email);
            $sentenciaSQL->bindParam(':type_us', $typ);
            $sentenciaSQL->execute();
            header('Location: CargarUsuario.php'); 
        break; 
    case 'Cancel':
        header('Location: CargarUsuario.php');
        break;
    case 'Select':
        $sentenciaSQL = $pdo->prepare("SELECT * FROM user_tbl WHERE user_id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $UnUser=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $nombre=$UnUser['name_user'];
        $typ=$UnUser['type_user'];
        $email=$UnUser['email_user']; 
        $pass=$UnUser['pass_user'];         
        break;
    case 'Delete':
        try{
            $sentenciaSQL = $pdo->prepare("DELETE FROM user_tbl WHERE user_id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        catch (PDOException $e) {
            echo "<script>alert('No se puede borrar el usuario. Pruebe que borrar o editar los productos relacionados primero');</script>";
        } 
        
        break;
    
}
?>
    <div id="wrapper">
        <?php include '../Inventario/Top-navbar.php'; ?>        
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Usuarios
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Añadir usuario
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                         <form role="form" method="post">
                                            <div class="col-md-6">                                                            
                                                <div class="form-group">
                                                <input type="hidden" name="txtID" value="<?php echo $txtID;?>">    
                                                <label>Nombre</label>
                                                <input class="form-control"  name="nombre" value="<?php echo $nombre ?>">
                                                </div>                                                            
                                                <div class="form-group"> 
                                                    <label>Puesto</label>
                                                    <?php echo ': '.$typ.'' ?>
                                                    <select class="form-control" name="typ" style="background-color: #e5dfdf;">
                                                    <option value="">-- Seleccione --</option>
                                                    <option value="Empleado">Empleado</option> 
                                                    <option value="Admin">Admin</option>  
                                                                                                                                                                                                                                 
                                                    </select>                                                            
                                                </div>                                                            
                                            </div>

                                            <div class="col-md-6">   
                                                <label>Correo electronico</label>
                                                <div class="form-group input-group">                                                                    
                                                    <span class="input-group-addon">@</span>
                                                    <input type="text" class="form-control" name="email" value="<?php echo $email ?>">
                                                </div>                                                                                                                 
                                                <label>Contraseña</label>
                                                <div class=" form-group input-group">
                                                    <span class="input-group-addon">**</span>
                                                    <input type="password"  class="form-control" placeholder="Contraseña" name="pass" <?php echo($accion=='Select')?"disabled":"" ?>>
                                            </div>
                                                                                                                                                                                  
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success" name="accion" value="add" <?php echo($accion=='Select')?"disabled":"" ?>>Agregar</button>
                                                <button type="submit" class="btn btn-primary" name="accion"value="Modify" <?php echo($accion!=='Select')?"disabled":"" ?>>Modificar</button>
                                                <button type="submit" class="btn btn-danger" name="accion" value="Cancel">Cancelar</button>
                                            </div>                                                                
                                         </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                    <!--/Form-->
                                    
                    <div class="col-md-7">
                        <!--    Context Classes  -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Usuarios
                            </div>                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="example"> 
                                        <thead>
                                            <tr>
                                                <th class="col-md-0">#</th>
                                                <th class="col-md-5">Nombre</th>
                                                <th class="col-md-1" style="text-align: center;">Nivel</th>
                                                <th class="col-md-5">Correo</th>
                                                <th class="col-md-1">Fecha de modificación</th>
                                                <th class="col-md-0">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                                        
                                            $query = $pdo->prepare("SELECT * FROM user_tbl");
                                            $query -> execute();
                                            $UserLista = $query -> fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if($query -> rowCount() > 0)   { 
                                                foreach($UserLista as $users) { ?> 
                                                <tr>
                                                    <td><?php echo $users['user_id']; ?></td>
                                                    <td><?php echo $users['name_user']; ?></td>
                                                    <td><?php echo $users['type_user']; ?></td>
                                                    <td><?php echo $users['email_user']; ?></td>
                                                    <td><?php echo $users['datemod_user']; ?></td>
                                                    <td style="text-align: center;">                                                    
                                                        <form method="post" >
                                                            <input type="hidden" name="txtID" value="<?php echo $users['user_id']?>">
                                                            <button type="submit" name="accion" value="Select" class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                                        </form>
                                                            <button data-toggle="modal" data-target="#DeleUser<?php echo $users['user_id']; ?>" class="btn btn-danger">
                                                                <i class="fa fa-eraser"></i>
                                                            </button>
                                                        
                                                            <div class="modal fade" id="DeleUser<?php echo $users['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: tomato; color:black;">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">¿Realmente desea eliminar el usuario?: </h4> 
                                                                    </div>
                                                                    <!--Modal Body-->
                                                                    <div class="modal-body">												
                                                                        <strong style="text-align: center !important">
                                                                        <?php echo $users['name_user']; ?></strong>                                                               
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post">
                                                                            <input type="hidden" name="txtID" value="<?php echo $users['user_id'];?>">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                                                                            <button type="submit" name="accion" value="Delete" class="btn btn-danger">Borrar</button>
                                                                        </form>                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php }
                                            } ?>                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                                        
                    <!-- Copy right  -->
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