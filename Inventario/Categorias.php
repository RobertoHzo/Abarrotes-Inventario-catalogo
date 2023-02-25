<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../Inventario/head.php';
session_start();

if (!isset($_SESSION['current_user_id'])) { 
    header('Location: ../Login/Expired.php');
    exit();
}  ?>

<body>
<?php
//debemos revisar si los input tienen informacion
//isset(what we check)-?-if true-:-if false;
$txtID = (isset($_POST['txtID']))?$_POST['txtID']:""; //['nombre/id de su input en el formulario']
$txtName = (isset($_POST['txtName']))?$_POST['txtName']:"";
$txtDesc = (isset($_POST['txtDesc']))?$_POST['txtDesc']:"";
$txtUserID = (isset($_POST['txtUserID']))?$_POST['txtUserID']:"";//?

$accion = (isset($_POST['accion']))?$_POST['accion']:"";

switch ($accion) {
    case 'add':
    $sentenciaSQL = $pdo->prepare("INSERT INTO categories_tbl (name_cat, description_cat,datemod_cat) 
    VALUES (:Name, :Descr,now());");

    $sentenciaSQL->bindParam(':Name', $txtName);
    $sentenciaSQL->bindParam(':Descr', $txtDesc);    
    $sentenciaSQL->execute();
    header('Location: Categorias.php');
        break;
    case 'Modify':
        $sentenciaSQL = $pdo->prepare("UPDATE categories_tbl 
        SET name_cat = :names, 
        description_cat = :descr,
            datemod_cat = now()
            WHERE category_id=:id"); 
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':names', $txtName);
            $sentenciaSQL->bindParam(':descr', $txtDesc);
            $sentenciaSQL->execute();
            header('Location: Categorias.php');    
        break;
    case 'Cancel':
        header('Location: Categorias.php');
        break;
    case 'Select':
        $sentenciaSQL = $pdo->prepare("SELECT * FROM categories_tbl WHERE category_id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $UnCat=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $txtName=$UnCat['name_cat'];
        $txtDesc=$UnCat['description_cat'];        
        // echo "Click on Select";
        break;
    case 'Delete':
        try{
            $sentenciaSQL = $pdo->prepare("DELETE FROM categories_tbl WHERE category_id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        catch (PDOException $e) {
            // echo "<script>alert('No se puede borrar el usuario. Pruebe que borrar o editar los productos relacionados primero');</script>";
            echo("<script>alert('No se puede borrar el usuario. Pruebe que borrar o editar los productos relacionados primero');</script>");
        } 
        
        break;
    // default:
    //     echo "Invalid option";
    //     break;
} 
?>
    <div id="wrapper">
    <?php include '../Inventario/Top-navbar.php'; ?>
       
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Categorias
                        </h1>
                    </div>
                </div>
                <!-- Row form  -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Añadir / Modificar Categoria
                            </div>
                            <!--ROW -->                          
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="post">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <input type="hidden" name="txtID" value="<?php echo $txtID;?>">    
                                                    <input type="hidden" name="txtUserID" value="<?php echo $txtUserID;?>">
                                                    <label>Nombre de la categoria</label>
                                                    <input class="form-control" value="<?php echo $txtName ?>" placeholder="Nombre" id="txtName" name="txtName">
                                                </div>                                                                                                                             
                                            </div>
                                            <div class="col-md-12">                                        
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <input class="form-control" value="<?php echo $txtDesc ?>"  id="txtDesc" name="txtDesc">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">		
                                                <button type="submit" name="accion" value="add" class="btn btn-success" <?php echo($accion=='Select')?"disabled":"" ?>>Añadir</button>
                                                <button type="submit" name="accion" value="Modify" class="btn btn-primary" <?php echo($accion!=='Select')?"disabled":"" ?>>Modificar</button>
                                                <button type="submit" name="accion" value="Cancel" class="btn btn-danger">Cancelar</button>
                                            </div>
                                            <br>
                                        </form>                                        
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tabla-->
                    <div class="col-md-8">                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Lista de categorias
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="example">
                                        <thead>
                                            <tr>
                                                <th class="col-md-0">#</th> 
                                                <th class="col-md-5">Categoria</th>
                                                <th class="col-md-6">Descripción</th>
                                                <th class="col-md-1">Fecha de modificación</th>
                                                <th class="col-md-0" style="text-align: center;">Seleccionar</th>
                                                <th class="col-md-0">Borrar</th>                                                
                                            </tr>                                            
                                        </thead>                                       
                                        <tbody>
                                        <?php                                        
                                        $query = $pdo->prepare("SELECT * FROM categories_tbl ");
                                        $query -> execute();
                                        $CategoriasLista = $query -> fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php if($query -> rowCount() > 0)   { 
                                            foreach($CategoriasLista as $categoria) { 
                                                $name=$categoria['name_cat'];
                                                $desc=$categoria['description_cat'];    ?>                                                                                                                                
                                                <tr>
                                                    <td><?php echo $categoria['category_id']; ?></td>
                                                    <td><?php echo $name; ?></td>
                                                    <td><?php echo $desc; ?></td>
                                                    <td><?php echo $categoria['datemod_cat']; ?></td>
                                                    <td style="text-align: center;">
                                                    <!--editar-->                                                    
                                                    <form method="post">
                                                    <input type="hidden" name="txtID" value="<?php echo $categoria['category_id']?>">
                                                    <button type="submit" name="accion" value="Select" class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                    
                                                    </td>
                                                    <td style="text-align: center;"> <!-- Borrar -->
                                                    <button class="btn btn-danger " data-toggle="modal" data-target="#DeleCat<?php echo $categoria['category_id']; ?>">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                    <div class="modal fade" id="DeleCat<?php echo $categoria['category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: tomato;">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">¿Realmente desea eliminar la categoria?: </h4> <!-- hacer que muestre el nombre del producto-->
                                                                </div>
                                                                <!--Modal Body-->
                                                                <div class="modal-body">												
                                                                    <strong style="text-align: center !important">
                                                                    <?php echo $name ?></strong>                                                               
                                                                </div>
                                                                <div class="modal-footer">
                                                                <form method="post">
                                                                    <input type="hidden" name="txtID" value="<?php echo $categoria['category_id']?>">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                                                                    <button type="submit" name="accion" value="Delete" class="btn btn-danger">Borrar</button>
                                                                </form>                                                                
                                                                <!-- <button type="submit" class="btn btn-danger" data-dismiss="modal" name="accion" value="Delete">Borrar</button>												 -->
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
                        <!--End Advanced Tables -->
                    </div>
                </div>                                                
                <!-- <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer> -->
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
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
            "lengthMenu": "Muestra _MENU_ registros por pagina",
            "zeroRecords": "No se ha encontrdo ningun registro ",
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