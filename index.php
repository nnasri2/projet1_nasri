<?php 

	require_once 'api/db.php';
	include 'includs/header.php'; 

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Retrieve the product name from the form submission
		$productName = $_POST['productName'];
		
		if(isset($productName) && !empty($productName)){
		   $query = "SELECT * FROM product WHERE name LIKE ?";
			$stmt = mysqli_prepare($conn, $query);
			$productNameParam = '%' . $productName . '%';
			mysqli_stmt_bind_param($stmt, "s", $productNameParam);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$results = mysqli_fetch_all($result, MYSQLI_ASSOC);

			// Close the statement and connection
			mysqli_stmt_close($stmt);

		}
	}
	else{
		
		// SQL query to retrieve all products
    $query = "SELECT * FROM product";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement and connection
    mysqli_stmt_close($stmt);
		
	}	


?>


<section class="jumbotron ">
    <div class="container">
   		<br>
      	<h1 class="jumbotron-heading">List des produits</h1>
		<p> Welcome to our store</p>
      	<br>
    </div>
</section>

<div class="container main-index">
    <div class="row my-5">
        <div class="col">
            <div class="row">
				<div class="col-12">
					<!-- search -->
					<form class="row g-3" action="?" method="post">
						
						<div class="col-auto">
							<label for="search" class="visually-hidden">Product name : </label>
							<input type="text" class="form-control" id="productName" name="productName" placeholder="Product ..." required>
						</div>
						<div class="col-auto">
							<button  class="btn btn-primary mb-3" type="submit">Search</button>
							<a class="btn btn-warning mb-3" href="./index.php">Cancel search</a>
						</div>
						</form>
					<!-- end search -->
				</div>
          	<?php 
				
				if (count($results) > 0) { 
					foreach ($results as $row) {
						
			?>
               
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card my-3 card-product">
                        <img class="card-img-top" src="<?php echo 'uploads/'.$row['img_url']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title"><a href="./product.php?id=<?php echo $row['id']; ?>" title="View Product"><?php echo $row['name']; ?></a></h4>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <div class="row">
                                <div class="col">
                                    <p class="btn btn-danger btn-block"><?php echo $row["price"]; ?> $</p>
                                </div>
                                <div class="col">

                                    <a href="carte.php?action=add&id=<?php echo $row['id']; ?>&quantity=1" class="btn btn-success btn-block">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
 			<?php	
					} } else {
					echo "No products found";
				}

				$pdo = null;
			?>                

            </div>
        </div>

    </div>
</div>



<?php include 'includs/footer.php'; ?>
