<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once '../Inventario/head.php';
session_start();

if (!isset($_SESSION['current_user_id'])) {
    header('Location: ../Login/Expired.php');
    exit();
}

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtQuan = (isset($_POST['txtQuan'])) ? $_POST['txtQuan'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$userid = htmlentities($_SESSION['current_user_id'], ENT_QUOTES, 'utf-8');

switch ($accion) {
    case 'Modify':
        $sentenciaSQL = $pdo->prepare("UPDATE products_tbl SET quantity =:Quan, user_id = {$userid}
            Where product_id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->bindParam(':Quan', $txtQuan);
        $sentenciaSQL->execute();
        header('Location: VerProductos.php');
        break;
    case 'Cancel':
        header('Location: Salidas.php');
        break;
        // default:
        //     echo "Invalid option";
        //     break;
}?>

<body>
    <div id="wrapper">
        <?php include_once 'Top-navbar.php'; ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Salidas
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Añadir / Modificar Categoria
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="post">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="txtID" value="<?php echo $txtID; ?>">
                                                    <input type="hidden" name="txtUserID" value="<?php echo $txtUserID; ?>">
                                                    <label>Seleccionar producto</label>
                                                    <input class="form-control" value="<?php echo $txtName ?>" placeholder="Nombre" id="txtName" name="txtName">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <input class="form-control" value="<?php echo $txtDesc ?>" id="txtDesc" name="txtDesc">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" name="accion" value="add" class="btn btn-success" <?php echo ($accion == 'Select') ? "disabled" : "" ?>>Añadir</button>
                                                <button type="submit" name="accion" value="Modify" class="btn btn-primary" <?php echo ($accion !== 'Select') ? "disabled" : "" ?>>Modificar</button>
                                                <button type="submit" name="accion" value="Cancel" class="btn btn-danger">Cancelar</button>
                                            </div>
                                            <br>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Salidas/Entradas recientes
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="example">
                                        <thead>
                                            <tr>
                                                <th class="col-md-0">#</th>
                                                <th class="col-md-5">Articulo</th>
                                                <th class="col-md-6">Descripción</th>
                                                <th class="col-md-1">Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = $pdo->prepare("SELECT * FROM products_tbl ");
                                            $query->execute();
                                            $CategoriasLista = $query->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if ($query->rowCount() > 0) {
                                                foreach ($CategoriasLista as $categoria) {
                                                    $name = $categoria['name_prod'];
                                                    $desc = $categoria['description_prod'];    ?>
                                                    <tr>
                                                        <td><?php echo $categoria['product_id']; ?></td>
                                                        <td><?php echo $name; ?></td>
                                                        <td><?php echo $desc; ?></td>
                                                        <td><?php echo $categoria['quantity']; ?></td>
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
    </div>
</body>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom-scripts.js"></script>

</html>