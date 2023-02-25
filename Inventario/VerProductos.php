<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../Inventario/head.php'; ?>

<body>
    <?php
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $txtQuan = (isset($_POST['txtQuan'])) ? $_POST['txtQuan'] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
    $userid = htmlentities($_SESSION['current_user_id'], ENT_QUOTES, 'utf-8');

    switch ($accion) {
        case 'Delete':
            $sentenciaSQL1 = $pdo->prepare("SELECT photo FROM products_tbl WHERE products_tbl.`product_id` = :id");
            $sentenciaSQL1->bindParam(':id', $txtID);
            $sentenciaSQL1->execute();
            $product = $sentenciaSQL1->fetch(PDO::FETCH_LAZY);
            if (isset($product["photo"]) && ($product["photo"] != "image.jpg")) {
                if (file_exists("../imagenes/img_productos/" . $product["photo"])) {
                    unlink("../imagenes/img_productos/" . $product["photo"]);
                }
            }
            $sentenciaSQL = $pdo->prepare("DELETE FROM products_tbl WHERE products_tbl.`product_id` = :id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            break;
        case 'Modify':
            $sentenciaSQL = $pdo->prepare("UPDATE products_tbl SET quantity =:Quan, datemod_prod=now() , user_id = {$userid}
            Where product_id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':Quan', $txtQuan);
            $sentenciaSQL->execute();
            header('Location: VerProductos.php');
            break;
            // default:
            //     echo "Invalid option";
            //     break;
    }
    ?>
    <div id="wrapper">
        <?php include_once '../Inventario/Top-navbar.php'; ?>
        <?php
        $query = $pdo->prepare("SELECT products_tbl.*, categories_tbl.name_cat as 'nombre cat', supplier_tbl.name_supp as 'nombre supp',user_tbl.name_user as 'nombre user'
        FROM products_tbl INNER JOIN categories_tbl ON products_tbl.category_id = categories_tbl.category_id
        INNER JOIN supplier_tbl ON products_tbl.supplier_id = supplier_tbl.supplier_id
        INNER JOIN user_tbl ON products_tbl.user_id = user_tbl.user_id ");
        $query->execute();
        $RowList = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12"><br></div>
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                LISTA DE PRODUCTOS
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="example">
                                        <thead>
                                            <tr>
                                                <th class="col-md-0">#</th>
                                                <th class="col-md-3">Nombre</th>
                                                <th class="col-md-4">Descripción</th>
                                                <th class="col-md-2">Proveedor</th>
                                                <th class="col-md-2">Categoria</th>
                                                <th class="col-md-0">$Compra</th>
                                                <th class="col-md-0">$Venta</th>
                                                <th class="col-md-0">$Pieza</th>
                                                <th class="col-md-0">Cantidad</th>
                                                <th class="col-md-1">Fecha de modificación</th>
                                                <th class="col-md-0">Info</th>
                                                <th class="col-md-0">Borrar</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if ($query->rowCount() > 0) {
                                                foreach ($RowList as $row) { ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['product_id']; ?></td>
                                                        <td><?php echo $row['name_prod']; ?></td>
                                                        <td><?php echo $row['desc_prod']; ?></td>
                                                        <td><?php echo $row['nombre supp']; ?></td>
                                                        <td><?php echo $row['nombre cat']; ?></td>
                                                        <td><?php echo $row['costprice']; ?></td>
                                                        <td><?php echo $row['saleprice']; ?></td>
                                                        <td><?php echo $row['unitprice']; ?></td>
                                                        <td style="text-align: center;"><?php echo $row['quantity']; ?>
                                                            <form method="post">
                                                                <input type="hidden" name="txtID" value="<?php echo $row['product_id']; ?>">
                                                            </form>
                                                            <button class="btn btn-success " data-toggle="modal" data-target="#ModQuan<?php echo $row['product_id']; ?>">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                            <div class="modal fade" id="ModQuan<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="background-color:chartreuse;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel"> Modificar cantidad de: <b><?php echo $row['name_prod']; ?></b></h4>
                                                                        </div>
                                                                        <!--Modal Body-->
                                                                        <div class="modal-body">
                                                                            <div class="col-md-12">
                                                                                <form role="form" method="post">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <h5><b>Cantidad actual:</b> <?php echo $row['quantity']; ?></h5>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Nueva cantidad:</label>
                                                                                            <input type="number" class="form-control" name="txtQuan" id="txtQuan">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <br>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                            <form method="post">
                                                                                <input type="hidden" name="txtID" value="<?php echo $row['product_id']; ?>">
                                                                                <button type="submit" class="btn btn-success" name="accion" value="Modify">Guardar cambios</button>
                                                                            </form>

                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $row['datemod_prod']; ?></td>
                                                        <td><!--   info-->
                                                            <!--Foto, usuario que modifico-->
                                                            <form method="post">
                                                                <input type="hidden" name="txtID" value="<?php echo $row['product_id']; ?>">
                                                            </form>
                                                            <button class="btn btn-info " data-toggle="modal" data-target="#Info<?php echo $row['product_id']; ?>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </button>
                                                            <div class="modal fade" id="Info<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="background-color: lightblue;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel-1">Más información: <b><?php echo $row['name_prod']; ?></b></h4>
                                                                        </div>
                                                                        <!--Modal Body-->
                                                                        <div class="modal-body">
                                                                            Usuario que modificó: <b><?php echo $row['nombre user']; ?></b> <br>
                                                                            <br>
                                                                            <div class="text-center">
                                                                                <img src="../imagenes/img_productos/<?php echo $row['photo']; ?>" class="rounded img-thumbnail" alt="<?php echo $row['name_prod']; ?>" style="max-width: 50%;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <form method="post">
                                                                <input type="hidden" name="txtID" value="<?php echo $row['product_id']; ?>">
                                                            </form>
                                                            <button data-toggle="modal" data-target="#DeleSupp<?php echo $row['product_id']; ?>" class="btn btn-danger">
                                                                <i class="fa fa-eraser"></i>
                                                            </button>

                                                            <div class="modal fade" id="DeleSupp<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="background-color: tomato;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel" style="color: black;">¿Realmente desea eliminar el articulo?: </h4>
                                                                        </div>
                                                                        <!--Modal Body-->
                                                                        <div class="modal-body">
                                                                            <strong style="text-align: center !important">
                                                                                <?php echo $row['name_prod']; ?></strong>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form method="post">
                                                                                <input type="hidden" name="txtID" value="<?php echo $row['product_id']; ?>">
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
            scrollX: true,
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