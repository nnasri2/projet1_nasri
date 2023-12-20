<?php
	require_once '../api/admin.php';

	// Logout function
	if (isset($_GET['logout'])) {
		session_destroy();
		header('Location: /login.php');
		exit();
	}


    if (isset($_POST['update_product'])) {

        $id = $_GET['id'];
        if(!$id){
        header('Location: ./list-products.php');
		exit();
        }

		$name = $_POST['name'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];

            $query = "UPDATE product SET name=?, price=?, description=?, quantity=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sdssi", $name, $price, $description, $quantity, $id);

            if (mysqli_stmt_execute($stmt)) {
			echo "<div class='success'>Product information updated successfully.</div>";
            } else {
			die("<div class='error'>Error: ".mysqli_error($conn) . " </div>");

            }

		//header('Location: list-users.php');

	}
    

?>


<!-- HTML content for client dashboard -->
 
 <div class="container content-dashboard">
    <div class="row my-4">
    <?php
          // Check if the ID parameter is provided
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Fetch product details from the database
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $productId);

        if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        // Process the fetched row here
        } else {
        die("Error: " . mysqli_error($conn));
        }

        if ($row != null) {
        ?>

         <div class="container content-dashboard">
    <div class="row my-3">
        <div class="col-12 col-sm-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Menu</div>
                <ul class="list-group category_block">
                    <li class="list-group-item">
                    	<a href="./dashboard.php">Dashboard</a>
                    </li>
                    <li class="list-group-item">
                    <a href="./list-products.php">Produits</a>
                    </li>
                    <li class="list-group-item">
                    	<a href="order.php">Orders</a>
                    </li>
                    <li class="list-group-item">
                    <a href="./list-users.php">List users</a>
                    </li>
                </ul>
            </div>
        </div>
  
        <div class="col-lg-5 col-sm-12">
            <div class="row"> 
                <div class="card">
                    <div class="card-body">
                    <form method="POST" action="<?php echo "edit-product.php?id=".$row['id']; ?>" >
                
                            <div class="form-group">
                                <label for="fname">Titre :</label>
                                <input class="form-control" type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Description :</label>
                                <input class="form-control" type="text" name="description" id="description" value="<?php echo $row['description']; ?>" required>
                            </div>              
                        
                            <div class="form-group">
                                <label for="email">Prix:</label>
                                <input class="form-control" type="number" name="price" id="price" value="<?php echo $row['price']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Quantité:</label>
                                <input class="form-control" type="number" name="quantity" id="quantity" value="<?php echo $row['quantity']; ?>" required>
                            </div>
                            
                            <button type="submit" name="update_product" class=" mt-4 btn btn-success" >Update</button>
                            
                        </form> 
                       </div>
                 </div>
                 <!-- end card -->
     		</div>          
		</div>                   
             
        
        <!-- update form -->
  
        <div class="col-lg-3 col-sm-12">
            <div class="row"> 
                <div class="card">
                            <div class="card-body">
                                <div>
                                    <img src="../uploads/<?php echo $row['img_url']; ?>" class="card-img-top" alt="Product Thumbnail">
                                </div>
                                <h5 class="card-title">
                                    <b>Titre : </b>
                                    <?php echo $row['name']; ?></h5>
                                <p class="card-text">
                                    <b>Description : </b>
                                    <?php echo $row['description']; ?></p>
                                <p class="card-text">
                                    <b>Prix : </b>
                                <span class="badge bg-warning">
                                    <?php echo $row['price']; ?> $
                                </span>
                                </p>
                                <p >
                                    <b>Disponnible : </b>
                                <span class="badge bg-success">
                                    <?php echo $row['quantity']; ?>
                                </span>
                                </p>
                            </div>
                 </div>
     		</div>     
             
		</div> 
        <div class="col-12 text-center my-5">
                    <a class="btn btn-warning" href="./list-products.php"><i class="fa fa-arrow-left"></i></a>
           </div>    
        <!-- end update form -->
     </div>          
</div>

 
            <?php
 

        } else {
            echo "<div class='alert alert-warning'>No product found with the provided ID.</div>";
        }
    } else {
            echo "<div class='alert alert-warning'>No product found with the provided ID.</div>";
    }
          
    ?>

    </div>          
</div>
                   
<?php include '../includs/footer.php'; ?>



