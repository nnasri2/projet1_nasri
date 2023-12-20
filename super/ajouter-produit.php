<?php
	require_once '../api/super.php';

	// Logout function
	if (isset($_GET['logout'])) {
		session_destroy();
		header('Location: /login.php');
		exit();
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
		// Get user input from the signup form
		$product_name = $_POST['product_name'];
		$product_desc = $_POST['product_desc'];
		$product_price = $_POST['product_price'];
		$product_quantity = $_POST['product_quantity'];
	
		//upload Images
		$target_dir = "../uploads/";
		$fileName = basename($_FILES["img_url"]["name"]); 
		$target_file = $target_dir.$fileName;
		move_uploaded_file($_FILES["img_url"]["tmp_name"], $target_file);

        // Insert the product into the database
        $query = "INSERT INTO product (name, quantity, price, img_url, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sisss", $product_name, $product_quantity, $product_price, $fileName, $product_desc);
        mysqli_stmt_execute($stmt);

        // Redirect to the list of products
        header('Location: ./list-products.php');
        exit();
		
    }

?>


<!-- HTML content for client dashboard -->
 
 <div class="container content-dashboard">
    <div class="row my-4">
        <div class="col-12 col-sm-3 ">
            <div class="card bg-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Menu</div>
                <ul class="list-group category_block">
                    <li class="list-group-item">
                    	<a href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="list-group-item">
                    <a href="list-products.php">Produits</a>
                    </li>
                    <!-- <li class="list-group-item">
                    	<a href="order.php">Orders</a>
                    </li> -->
                    <li class="list-group-item">
                    <a href="list-users.php">List users</a>
                    </li>
                </ul>
            </div>
        </div>
  
        <div class="col">
            <div class="row"> 

 <h1>Add product</h1>
<form class="form-horizontal" action="./ajouter-produit.php" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>PRODUCTS</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">PRODUCT NAME</label>  
  <div class="col-md-4">
  <input id="product_name" name="product_name" placeholder="PRODUCT NAME" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_price">
  	Price 
  </label>  
  <div class="col-md-4">
  <input id="product_price" name="product_price" placeholder="PRODUCT Price" class="form-control input-md" min="1" required="" type="number">
    
  </div>
</div>
<!-- Select Basic -->
<!--
<div class="form-group">
  <label class="col-md-4 control-label" for="product_categorie">PRODUCT CATEGORY</label>
  <div class="col-md-4">
    <select id="product_categorie" name="product_categorie" class="form-control">
    </select>
  </div>
</div>
-->

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_quantity">AVAILABLE QUANTITY</label>  
  <div class="col-md-4">
  <input id="product_quantity" name="product_quantity" placeholder="AVAILABLE QUANTITY" class="form-control input-md" required="" type="number" min="1">
  </div>
</div>


<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="product_desc">PRODUCT DESCRIPTION</label>
  <div class="col-md-4">                     
    <textarea required="" class="form-control" id="product_desc" name="product_desc"></textarea>
  </div>
</div>
    
 <!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="img_url">Image</label>
  <div class="col-md-4">
    <input id="img_url" name="img_url" class="input-file" required="" type="file">
  </div>
</div>

<!-- Button -->
<div class="form-group my-4">
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
  </div>
</div>
	</fieldset>
</form>        
                                                                              
                                    
                                     
     		</div>          
		</div>                   
                    
     </div>          
</div>
                   
<?php include '../includs/footer.php'; ?>



