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
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : ""; //['nombre/id de su input en el formulario']
    $txtName = (isset($_POST['txtName'])) ? $_POST['txtName'] : "";
    $txtDesc = (isset($_POST['txtDesc'])) ? $_POST['txtDesc'] : "";
    $txtUserID = (isset($_POST['txtUserID'])) ? $_POST['txtUserID'] : ""; //?
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    switch ($accion) {
        case 'add':
            $sentenciaSQL = $pdo->prepare("INSERT INTO supplier_tbl (name_supp, description_supp,datemod_supp)
    VALUES (:name_supp, :description_supp,now());");
            $sentenciaSQL->bindParam(':name_supp', $txtName);
            $sentenciaSQL->bindParam(':description_supp', $txtDesc);
            $sentenciaSQL->execute();
            header('Location: Proveedores.php');
            break;
        case 'Modify':
            $sentenciaSQL = $pdo->prepare("UPDATE supplier_tbl
        SET name_supp = :names,
        description_supp = :descr,
            datemod_supp = now()
            WHERE supplier_id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':names', $txtName);
            $sentenciaSQL->bindParam(':descr', $txtDesc);
            $sentenciaSQL->execute();
            header('Location: Proveedores.php');
            break;
        case 'Cancel':
            header('Location: Proveedores.php');
            break;
        case 'Select':
            $sentenciaSQL = $pdo->prepare("SELECT * FROM supplier_tbl WHERE supplier_id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $UnProv = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtName = $UnProv['name_supp'];
            $txtDesc = $UnProv['description_supp'];
            break;
        case 'Delete':
            try {

                $sentenciaSQL = $pdo->prepare("DELETE FROM supplier_tbl WHERE supplier_id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
            } catch (PDOException $e) {
                echo "<script>alert('No se puede borrar el proovedor. Pruebe que borrar o editar los productos relacionados primero');</script>";
            }
            break;
            // default:
            //     echo "Invalid option";
            //     break;
    } ?>
    <div id="wrapper">
        <?php include_once '../Inventario/Top-navbar.php'; ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Proveedores
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Añadir proveedor
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="post">
                                            <div class="form-group">
                                                <input type="hidden" name="txtID" value="<?php echo $txtID; ?>">
                                                <input type="hidden" name="txtUserID" value="<?php echo $txtUserID; ?>">
                                                <label>Nombre del proveedor</label>
                                                <input class="form-control" value="<?php echo $txtName ?>" placeholder="Nombre" id="txtName" name="txtName">
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <input class="form-control" value="<?php echo $txtDesc ?>" id="txtDesc" name="txtDesc">
                                            </div>
                                            <button type="submit" class="btn btn-success" name="accion" value="add" <?php echo ($accion == 'Select') ? "disabled" : "" ?>>Agregar</button>
                                            <button type="submit" class="btn btn-primary" name="accion" value="Modify" <?php echo ($accion !== 'Select') ? "disabled" : "" ?>>Modificar</button>
                                            <button type="submit" class="btn btn-danger" name="accion" value="Cancel">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Lista de proveedores
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="example">
                                        <thead>
                                            <tr>
                                                <th class="col-md-0">#</th>
                                                <th class="col-md-5">Nombre del proveedor</th>
                                                <th class="col-md-6">Descripción</th>
                                                <th class="col-md-1">Fecha de modificación</th>
                                                <th class="col-md-1" style="text-align:center;">Acciones</th>
                                            </tr>
                                        <tbody>
                                            <?php
                                            $query = $pdo->prepare("SELECT * FROM supplier_tbl ");
                                            $query->execute();
                                            $ProvLista = $query->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if ($query->rowCount() > 0) {
                                                foreach ($ProvLista as $prov) { ?>
                                                    <tr>
                                                        <td><?php echo $prov['supplier_id']; ?></td>
                                                        <td><?php echo $prov['name_supp']; ?></td>
                                                        <td><?php echo $prov['description_supp']; ?></td>
                                                        <td><?php echo $prov['datemod_supp']; ?></td>

                                                        <td style="text-align: center;">
                                                            <form method="post">
                                                                <input type="hidden" name="txtID" value="<?php echo $prov['supplier_id']; ?>">
                                                                <button type="submit" name="accion" value="Select" class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                            <button data-toggle="modal" data-target="#DeleSupp<?php echo $prov['supplier_id']; ?>" class="btn btn-danger">
                                                                <i class="fa fa-eraser"></i>
                                                            </button>
                                                            <div class="modal fade" id="DeleSupp<?php echo $prov['supplier_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="background-color: tomato; color:black;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">¿Realmente desea eliminar el proveedor?: </h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <strong style="text-align: center !important">
                                                                                <?php echo $prov['name_supp']; ?></strong>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form method="post">
                                                                                <input type="hidden" name="txtID" value="<?php echo $prov['supplier_id']; ?>">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
                </div>
            </div>
        </div>

</body>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script type="text/javascript" src="../Inventario/assets/DataTables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "lengthMenu": "Muestra _MENU_ registros por pagina",
                "zeroRecords": "No se ha encontrdo ningun registro",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)"
            }
        });
    });
</script>
<script src="assets/js/custom-scripts.js"></script>

</html>