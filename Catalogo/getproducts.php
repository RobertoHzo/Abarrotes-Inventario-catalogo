<?php
include '../global/ConfigServer.php';
include '../global/connection_DB.php';


 $action = $_REQUEST['action'];
 
 if($action=="showAll"){
  
  $stmt=$pdo->prepare('SELECT * FROM products_tbl ORDER BY product_id');
  $stmt->execute();
  
 }else{
  
  $stmt=$pdo->prepare('SELECT * FROM products_tbl WHERE category_id=:cid ORDER BY product_id');
  $stmt->execute(array(':cid'=>$action));
 }
 
 ?>
 <div class="row">
 <?php
 if($stmt->rowCount() > 0){
  
  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
   extract($row);
   ?>
   

   <div class="col-xs-6 col-sm-6 col-lg-4 col-md-6 text-center"> 
		<div class="single-product-item">
			<div class="product-image">
				<a ><img src="../imagenes/img_productos/<?php echo $photo ?>" alt="<?php echo $name_prod ?>"></a>
		    </div>
		    <h4><?php echo $name_prod ?></h4>
			<p class="product-price"><span>Por unidad</span> $ <?php echo $saleprice ?> </p>
		</div>
	</div>																			
  <?php  
  }
  
 }else{
  
  ?>
        <div class="col-xs-6 col-sm-6 col-lg-4 col-md-6 text-center"> 
		<div class="single-product-item">
			<div class="product-image">
				<a ><img src="../imagenes/img_productos/<?php echo $photo ?>" alt="<?php echo $name_prod ?>"></a>
		    </div>
		    <h4><?php echo $name_prod ?></h4>
			<p class="product-price"><span>Por unidad</span> $ <?php echo $saleprice ?> </p>
		</div>
	</div>
<?php  
 }
?>
 </div>