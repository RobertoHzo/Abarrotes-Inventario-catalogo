
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../Inventario/head.php';
// session_start();

// if (!isset($_SESSION['current_user_id'])) { 
//     header('Location: ../Login/Expired.php');
//     exit();
// } 
 ?>
<body>
<?php
$txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
$txtUserID = (isset($_POST['txtUserID']))?$_POST['txtUserID']:"";
$txtName = (isset($_POST['txtName']))?$_POST['txtName']:"";
$txtDescription = (isset($_POST['txtDescription']))?$_POST['txtDescription']:"";
$txtPrice = (isset($_POST['txtPrice']))?$_POST['txtPrice']:"";
$txtCost = (isset($_POST['txtCost']))?$_POST['txtCost']:"";
$txtUnit = (isset($_POST['txtUnit']))?$_POST['txtUnit']:"";
$txtQuan = (isset($_POST['txtQuan']))?$_POST['txtQuan']:"";
$txtOldImg=(isset($_POST['txtOldImg']))?$_POST['txtOldImg']:"";
$txtImage = (isset($_FILES['txtImage']['name']))?$_FILES['txtImage']['name']:"";//aqui se usa $_FILES
$txtSupp = (isset($_POST['txtSupp']))?$_POST['txtSupp']:"";
$txtCat = (isset($_POST['txtCat']))?$_POST['txtCat']:"";
$accion = (isset($_POST['accion']))?$_POST['accion']:"";

//Para imprimir el id del user obtr¿enido del session
$userid = htmlentities($_SESSION['current_user_id'],ENT_QUOTES,'utf-8');

switch ($accion) {

	case 'add':
	$sentenciaSQL = $pdo->prepare("INSERT INTO products_tbl (name_prod,desc_prod,`saleprice`,`costprice`,`unitprice`,`quantity`,photo,
    datemod_prod,supplier_id,category_id,`user_id`)
     VALUES (:Name,:Descr,:Sale, :Cost_, :Unit,:Quan,:Photo_, now(),:Supp,:Cat,{$userid});"); 
    $date = new DateTime();
    $ImgFileName=($txtImage != "")?$date->getTimestamp()."_".$_FILES["txtImage"]["name"]:"image.jpg";
    $ImgTmp=$_FILES["txtImage"]["tmp_name"];
    if ($ImgTmp!=""){
        move_uploaded_file($ImgTmp, "../imagenes/img_productos/".$ImgFileName);
    }
    $sentenciaSQL->bindParam(':Name', $txtName);
    $sentenciaSQL->bindParam(':Descr', $txtDescription);
    $sentenciaSQL->bindParam(':Sale', $txtPrice);
    $sentenciaSQL->bindParam(':Cost_', $txtCost);
    $sentenciaSQL->bindParam(':Unit', $txtUnit);
    $sentenciaSQL->bindParam(':Quan', $txtQuan);
    $sentenciaSQL->bindParam(':Photo_', $ImgFileName); //imagen producto
    $sentenciaSQL->bindParam(':Supp', $txtSupp); 
    $sentenciaSQL->bindParam(':Cat', $txtCat);	    	
           
	$sentenciaSQL->execute();
    header('Location: CargarProducto.php');
	break;	

	case 'Cancel':
        header('Location: CargarProducto.php');
		break;
    case 'Select':
        $sentenciaSQL = $pdo->prepare("SELECT * FROM products_tbl WHERE product_id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $UnProducto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $txtName=$UnProducto['name_prod'];
        $txtCat=$UnProducto['category_id'];
        $txtDescription=$UnProducto['desc_prod'];
        $txtPrice=$UnProducto['saleprice'];
        $txtImage=$UnProducto['photo'];
        $txtOldImg=$UnProducto['photo'];//variable para guardar el nombre de la imagen original
        $txtSupp=$UnProducto['supplier_id'];
        $txtCost=$UnProducto['costprice'];
        $txtUnit=$UnProducto['unitprice'];
        $txtQuan=$UnProducto['quantity'];
        $txtUserID=$UnProducto['user_id'];
        
        break;
    case 'Delete':      
        //look for the image 
           //look for the image 
           $sentenciaSQL1= $pdo->prepare("SELECT photo FROM products_tbl WHERE products_tbl.`product_id` = :id");
           $sentenciaSQL1->bindParam(':id',$txtID);
           $sentenciaSQL1->execute();
           $product=$sentenciaSQL1->fetch(PDO::FETCH_LAZY);
           if(isset($product["photo"]) && ($product["photo"] != "image.jpg")){
               if(file_exists("../imagenes/img_productos/".$product["photo"])){
                   unlink("../imagenes/img_productos/".$product["photo"]);
               }
           }
   
           $sentenciaSQL = $pdo->prepare("DELETE FROM products_tbl WHERE products_tbl.`product_id` = :id");
           $sentenciaSQL->bindParam(':id', $txtID);
           $sentenciaSQL->execute();   
        break;

    case 'Modify':
        $sentenciaSQL2 = $pdo->prepare("UPDATE products_tbl 
        SET name_prod = :Nam,
        desc_prod = :Descr,
        saleprice = :Sale,
        costprice = :Cost,
        unitprice = :Unit,
        quantity = :Quan,
        datemod_prod = now(),
        supplier_id = :Supp,
        category_id = :Cat,
        user_id = $userid
        WHERE product_id =:id"); 

        $sentenciaSQL2->bindParam(':id', $txtID);
        $sentenciaSQL2->bindParam(':Nam', $txtName);
        $sentenciaSQL2->bindParam(':Descr', $txtDescription);
        $sentenciaSQL2->bindParam(':Sale', $txtPrice);
        $sentenciaSQL2->bindParam(':Cost', $txtCost);
        $sentenciaSQL2->bindParam(':Unit', $txtUnit);
        $sentenciaSQL2->bindParam(':Quan', $txtQuan);
        $sentenciaSQL2->bindParam(':Supp', $txtSupp); 
        $sentenciaSQL2->bindParam(':Cat', $txtCat);	
        $sentenciaSQL2->execute();
        if($txtImage!="")
        {
            $date = new DateTime();
            //creacion del nuevo nombre de la imagen
            $ImgFileName =($txtImage!="")?$date->getTimestamp()."_".$_FILES["txtImage"]["name"]:"image.jpg";
            $ImgTmp=$_FILES["txtImage"]["tmp_name"];
            move_uploaded_file($ImgTmp, "../imagenes/img_productos/".$ImgFileName);

            $sentenciaSQL3 = $pdo->prepare("SELECT photo FROM products_tbl WHERE product_id =:id");
            $sentenciaSQL3->bindParam(':id', $txtID);
            $sentenciaSQL3->execute();

            $product=$sentenciaSQL3->fetch(PDO::FETCH_LAZY);
            if(isset($product["photo"]) && ($product["photo"]!="image.jpg")){
                if(file_exists("../imagenes/img_productos/".$product["photo"])){
                    unlink("../imagenes/img_productos/".$product["photo"]);
                }
            }
            $sentenciaSQL4 = $pdo->prepare("UPDATE products_tbl SET photo = :Photo_ WHERE product_id=:id");
            $sentenciaSQL4->bindParam(':id', $txtID);  
            $sentenciaSQL4->bindParam(':Photo_', $ImgFileName); 
            $sentenciaSQL4->execute();
        }else
        {
            $sentenciaSQL4 = $pdo->prepare("UPDATE products_tbl SET photo = :Photo_ WHERE product_id=:id"); 
            $sentenciaSQL4->bindParam(':id', $txtID);
            $sentenciaSQL4->bindParam(':Photo_', $txtOldImg); 
            $sentenciaSQL4->execute();
        }        
        //redirigir a la misma pagina 
        header('Location: CargarProducto.php');                
        break;
	// default:
    //     echo "Invalid option";
	// 	break;
    }
    ?>
    <div id="wrapper">
        <?php include '../Inventario/Top-navbar.php'; ?>      
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Agregar / modificar productos 
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <!--Form-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Agregar / Modificar Producto
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <form role="form" method="POST" enctype="multipart/form-data">
                                        <div class="col-md-6">                                        
                                            <div class="form-group">
                                            <input type="hidden" name="txtID" value="<?php echo $txtID;?>">    
                                                    <input type="hidden" name="txtUserID" value="<?php echo $txtUserID;?>"> 

                                                <label>Nombre</label>
                                                <input type="text" class="form-control" id="txtName" name="txtName" value="<?php echo $txtName; ?>">                                                
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <input type="text" class="form-control" id="txtDescription" name="txtDescription" value="<?php echo $txtDescription; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Proveedor</label>
                                                <select class="form-control" name="txtSupp"  id="txtSupp" style="background-color: #e5dfdf;">       
                                                    <option value="">-- Seleccione --</option>
                                                    <?php 
                                                    $sentenciaSupp = $pdo->prepare("SELECT * from supplier_tbl");
                                                    $sentenciaSupp->execute();
                                                    if(!empty($txtSupp))
                                                    {
                                                        $ListSupp=$sentenciaSupp->fetchAll();
                                                        foreach ($ListSupp as $supp) { 
                                                            $selected = ($txtSupp == $supp['supplier_id']) ? ' selected' : null;
                                                            echo '<option value="'.$supp['supplier_id'].'"'.$selected.'>'.$supp['name_supp'].'</option>';                                                                
                                                        }
                                                    }else{
                                                        $ListSupp=$sentenciaSupp->fetchAll();
                                                        foreach ($ListSupp as $supp) { 
                                                        echo '<option value="'.$supp['supplier_id'].'">'.$supp['name_supp'].'</option>';
                                                        }                                                
                                                    } ?>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Agregar Imagen</label>
                                                <?php echo $txtImage; ?>
                                                <input type="hidden" name="txtOldImg" id="" value="<?php echo $txtImage; ?>" class="form-control" placeholder="Imagen">
                                                <input type="file" name="txtImage" id="txtImage" class="form-control" placeholder="Image">
                                            </div>                                                                                    
                                        </div>
                                            <!-- /.col-md-6 (nested) -->
                                        <div class="col-md-6">
                                            <div class="col-xs-12" style="padding-left: -15px;">
                                                <label>Precio de venta</label>                                   
                                                <div class="form-group input-group">                                                
                                                    <span class="input-group-addon">$</span>
                                                    <input type="number" class="form-control" id="txtPrice" name="txtPrice" value="<?php echo $txtPrice; ?>" style="background-color: #d0e5f1">
                                                    <!-- <span class="input-group-addon">.00</span> -->
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <label>Precio de compra</label>                                   
                                                <div class="form-group input-group">                                                
                                                    <span class="input-group-addon">$</span>
                                                    <input type="number" class="form-control" id="txtCost" name="txtCost" value="<?php echo $txtCost; ?>" style="background-color: #f1f9d2">
                                                </div>
                                            </div>                                                                                  
                                            <div class="col-xs-12">
                                            <label>Precio por unidad</label>
                                                <div class="form-group input-group ">                                            
                                                    <span class="input-group-addon">$</span>
                                                    <input type="number" class="form-control" name="txtUnit"  value="<?php echo $txtUnit; ?>" id="txtUnit" style="background-color: #d2f9d7">
                                                </div>
                                            </div>                                                                                                                                                                                                                                                                        
                                            <div class="form-group">
                                                    <!-- categorias -->
                                                <label>Categoria</label>
                                                <select class="form-control" name="txtCat"  id="txtCat" style="background-color: #e5dfdf;">                                                               
                                                    <option value="00">-- Seleccione --</option>
                                                    <?php $sentenciaCategories = $pdo->prepare("SELECT * from categories_tbl");
                                                        $sentenciaCategories->execute();
                                                    if(!empty($txtCat))
                                                    {
                                                        $ListCategories=$sentenciaCategories->fetchAll();
                                                        foreach ($ListCategories as $category) { 
                                                            $selected = ($txtCat == $category['category_id']) ? ' selected' : null;
                                                            echo '<option value="'.$category['category_id'].'"'.$selected.'>'.$category['name_cat'].'</option>';                                                                
                                                            }
                                                    }else{
                                                        $ListCategories=$sentenciaCategories->fetchAll();
                                                        foreach ($ListCategories as $category) { 
                                                        echo '<option value="'.$category['category_id'].'">'.$category['name_cat'].'</option>';
                                                        }
                                                            //     $ListCategories=$sentenciaCategories->fetchAll();
                                                            // foreach ($ListCategories as $category) { 
                                                            // echo '<option value="'.$category['category_id'].'">'.$category['name_cat'].'</option>';
                                                    } ?>
                                                </select>                                                
                                            </div>
                                            <!-- /categorias -->                                                                                                                                                                        
                                            <label>Cantidad</label>
                                            <div class=" form-group input-group">
                                                <span class="input-group-addon">#</span>
                                                <input type="number" class="form-control" id="txtQuan"  name="txtQuan" value="<?php echo $txtQuan; ?>" placeholder="Cantidad de productos">
                                            </div>
                                        </div>
                                        <div class="row"></div>
                                        <div class="col-md-6">
                                            <!-- <form method="POST" enctype="multipart/form-data"> -->
                                            <button type="submit" class="btn btn-success" name="accion" value="add" <?php echo($accion=='Select')?"disabled":"" ?>>Agregar</button>
                                            <button type="submit" class="btn btn-primary" name="accion"value="Modify" <?php echo($accion!=='Select')?"disabled":"" ?>>Modificar</button>
                                            <button type="submit" class="btn btn-danger" name="accion" value="Cancel" >Cancelar</button> <!-- accion cancel -->
                                        </div>                                        
                                    </form>
                                </div>
                            </div>   
                        </div>                                                                                                             
                        <!-- /.col-lg-12 -->
                    </div>                                
                    <!-- /Primer row  -->
                </div>                            
                <!-- /.panel-inner -->
                <!-- </div>                         -->
                <!--tabla -->
                <?php
                    // $sentenciaSQL = $pdo->prepare("SELECT * FROM products_tbl");
                    $sentenciaSQL=$pdo->prepare("SELECT products_tbl.*, categories_tbl.name_cat as 'nombre cat', supplier_tbl.name_supp as 'nombre supp',user_tbl.name_user as 'nombre user'
                    FROM products_tbl INNER JOIN categories_tbl ON products_tbl.category_id = categories_tbl.category_id
                    INNER JOIN supplier_tbl ON products_tbl.supplier_id = supplier_tbl.supplier_id
                    INNER JOIN user_tbl ON products_tbl.user_id = user_tbl.user_id");
                    $sentenciaSQL->execute();
                    $listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                LISTA DE PRODUCTOS RECIENTES
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table  class="table table-striped table-bordered table-hover" id="Tablex">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-0">#</th>
                                                    <th class="col-md-4">Nombre</th>
                                                    <th class="col-md-4">Descripción</th>
                                                    <th class="col-md-2">Proveedor</th>
                                                    <th class="col-md-2">Categoria</th>
                                                    <th class="col-md-0">$Compra</th>
                                                    <th class="col-md-0">$Venta</th>
                                                    <th class="col-md-0">$Unidad</th>
                                                    <th class="col-md-0">Cantidad</th>
                                                    <th class="col-md-0">Fecha de modificación</th>
                                                    <th class="col-md-0">Info</th>
                                                    <th class="col-md-0">Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            <?php
                                                foreach ($listaProductos as $producto) { ?> 
                                                <tr>
                                                    <td><?php echo $producto['product_id']; ?></td>
                                                    <td><?php echo $producto['name_prod']; ?></td>
                                                    <td><?php echo $producto['desc_prod']; ?></td>                                                
                                                    <td><?php echo $producto['nombre supp']; ?></td>
                                                    <td><?php echo $producto['nombre cat']; ?></td>
                                                    <td><?php echo $producto['costprice']; ?></td>
                                                    <td><?php echo $producto['saleprice']; ?></td>
                                                    <td><?php echo $producto['unitprice']; ?></td>
                                                    <td><?php echo $producto['quantity']; ?></td>
                                                    <td><?php echo $producto['datemod_prod']; ?></td>
                                                    <td><!--   info-->
                                                        <!--Foto, usuario que modifico, fecha de modificacion-->
                                                        <form method="post" >               
                                                            <input type="hidden" name="txtUserID" value="<?php echo $producto['user_id']?>">                                             
                                                            <input type="hidden" name="txtID" value="<?php echo $producto['product_id'];?>">
                                                        </form>
                                                        <button class="btn btn-info " data-toggle="modal" data-target="#iInfo<?php echo $producto['product_id'];?>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </button>
                                                        <div class="modal fade" id="iInfo<?php echo $producto['product_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="background-color: lightblue;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel-1">Más información de: <b><?php echo $producto['name_prod']; ?></b></h4> 
                                                                        </div>
                                                                        <!--Modal Body-->
                                                                        <div class="modal-body">
                                                                            Usuario que modificó: <b><?php echo $producto['nombre user']; ?></b> <br>
                                                                            <br>
                                                                            Imagen:
                                                                            <br>
                                                                            <div class="text-center">
                                                                                <img src="../imagenes/img_productos/<?php echo $producto['photo']; ?>" class="rounded img-thumbnail" alt="<?php echo $producto['name_prod']; ?>" style="max-width: 50%;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </td>
                                                    <td><form method="post" >
                                                            <input type="hidden" name="txtUserID" value="<?php echo $producto['user_id']?>">                                             
                                                            <input type="hidden" name="txtID" value="<?php echo $producto['product_id']?>">
                                                            <button type="submit" name="accion" value="Select" class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                                            <!-- <input type="submit" name="accion" value="Borrar" class="btn btn-danger"> -->
                                                        </form>
                                                        <!--Borrar-->
                                                        <button data-toggle="modal" data-target="#DeleProd<?php echo $producto['product_id']; ?>" class="btn btn-danger">
                                                                <i class="fa fa-eraser"></i>
                                                        </button>

                                                            <div class="modal fade" id="DeleProd<?php echo $producto['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: tomato;">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel" style="color: black;">¿Realmente desea eliminar el articulo?: </h4> 
                                                                    </div>
                                                                    <!--Modal Body-->
                                                                    <div class="modal-body">												
                                                                        <strong style="text-align: center !important ">
                                                                        <?php echo $producto['name_prod']; ?></strong>                                                               
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post">
                                                                            <input type="hidden" name="txtUserID" value="<?php echo $producto['user_id']?>">                                             
                                                                            <input type="hidden" name="txtID" value="<?php echo $producto['product_id'];?>">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                                                                            <button type="submit" name="accion" value="Delete" class="btn btn-danger">Borrar</button>
                                                                        </form>                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>                                                                                                                                                         
                                                </tr>
                                                <?php } ?>                                                                                                                                                                                                                
                                            </tbody>
                                        </table>
                                </div>                                
                            </div>
                        </div>
                        <!-- /col-md-12 -->
                    </div>
                    <!--/row -->
                </div> 
            </div>
            <!-- /Page wrapper -->
        </div>
        <!-- /wrapper -->
    </div>
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
                $('#Tablex').DataTable( {
                "order": [[ 9, "desc" ]],
                scrollX:true,
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
        