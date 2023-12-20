<?php 
	require_once '../api/admin.php';
// Function to delete a product by ID
function deleteProduct($id) {
        global $conn;
        $query = "DELETE FROM product WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
        echo "Product with ID $id deleted successfully.";
        } else {
        die("Error: " . mysqli_error($conn));
        }

}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the action is "delete"
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        deleteProduct($id);
    }
}
?>

 
 <div class="container content-dashboard">
    <div class="row my-3">
       
        <div class="col-12 col-sm-3">
            <div class="card bg-light mb-3 mt-4">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Menu</div>
                <ul class="list-group category_block">
                    <li class="list-group-item">
                    	<a href="./dashboard.php">Dashboard</a>
                    </li>
                    <li class="list-group-item active">
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
  
        <div class="col mt-3 container  ">
            <div class="row "> 
                <div class="col-12">
                    <a href="/admin/ajouter-produit.php" class = "btn btn-success">Ajouter Produits</a> 
                </div>
            </div>
            <div class="row "> 
                <!--  list products -->
                <?php
                            $query = "SELECT * FROM product";
                            $result = mysqli_query($conn, $query);

                            // Fetch results
                            $results = [];
                            while ($row = mysqli_fetch_assoc($result)) {
                            $results[] = $row;
                            }

                          foreach ($results as $row) {
                                
                        ?>	
			<div class="col-lg-4  col-md-6  col-sm-12  mt-4 ">
				<div class="card product-card">
					<img class="card-img-top" src="<?php echo '../uploads/'.$row['img_url']; ?>" alt="Card image cap">
					<div class="card-body">
						<h4 class="card-title"><a href="<?php echo './view-product.php?id='.$row['id']; ?>" title="View Product"><?php echo $row['name']; ?></a></h4>
						<p class="card-text">
							<?php echo $row['description']; ?>
						</p>
						<div class="row">
							<div class="col">
								<p class="btn btn-success btn-block"><?php echo $row["price"]; ?> $</p>
							</div>
							<div class="col">
								<a href="<?php echo $_SERVER['PHP_SELF'].'?id='.$row["id"].'&action=delete'; ?>" class="btn btn-danger btn-block"><i class="fa fa-trash"></i></a>
								<a href="<?php echo  './edit-product.php?id='.$row['id']; ?>" class="btn btn-success btn-block"><i class="fa fa-pencil"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
 <?php		}	

	$pdo = null;
?>                                     
                                    
                                    
                                     
     </div>          
</div>                   
                    
     </div>          
</div>
                   
<?php include '../includs/footer.php'; ?>
                   
