<?php
	require_once '../api/admin.php';

 
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Retrieve the product name from the form submission
		$refOrder = $_POST['refOrder'];
		
		if(isset($refOrder) && !empty($refOrder)){
            $query = "SELECT uo.ref, uo.id, uo.total, adrs.street_name, u.user_name, uo.date 
                    FROM user_order AS uo
                    JOIN user AS u ON uo.user_id = u.id
                    JOIN address AS adrs ON u.shipping_address_id = adrs.id
                    WHERE uo.ref LIKE ?";
            $stmt = mysqli_prepare($conn, $query);
            $refOrderParam = '%' . $refOrder . '%';
            mysqli_stmt_bind_param($stmt, "s", $refOrderParam);

            if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
            // Process the fetched results here
            } else {
            die("Error: " . mysqli_error($conn));
            }
		}
	} else{
		
		$query = "SELECT uo.ref, uo.id, uo.total, adrs.street_name, u.user_name, uo.date
          FROM user_order AS uo
          JOIN user AS u ON uo.user_id = u.id
          JOIN address AS adrs ON u.shipping_address_id = adrs.id";
            $result = mysqli_query($conn, $query);

            if ($result) {
            $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
            // Process the fetched results here
            } else {
            die("Error: " . mysqli_error($conn));
            }
	}	


?>

 <div class="container  content-dashboard">
    <div class="row my-4">
       
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
                    	<a href="./order.php">Orders</a>
                    </li>
                    <li class="list-group-item">
                    <a href="./list-users.php">List users</a>
                    </li>
                </ul>
            </div>
        </div>
  
        <div class="col">

         <div class="row">
				<div class="col-6 mt-5 mx-auto">
					<!-- search -->
					<form class="row g-3" action="?" method="post">
						
						<div class="col-auto">
							<label for="refOrder" class="visually-hidden">Ref : </label>
							<input type="text" class="form-control" id="refOrder" name="refOrder" placeholder="REF ..." required>
						</div>
						<div class="col-auto">
							<button  class="btn btn-primary mb-3" type="submit">Search</button>
							<a class="btn btn-warning mb-3" href="./order.php">Cancel</a>
						</div>
						</form>
					<!-- end search -->
				</div>
		</div>



            <div class="row my-3"> 
            
        		<div class="col-12">

                    <?php
                    if (count($results) > 0){
                    ?>

            		<div class="table-responsive">
                		<table class="table table-striped">
                    		<thead>
                        		<tr>
									<th scope="col"> #REF </th>
									<th scope="col"> Total </th>
									<th scope="col">Client</th>
									<th scope="col">Date</th>
									<th scope="col" class="text-center">Order id</th>
									<th scope="col" class="text-right">Adresse</th>
									<th> </th>
                        		</tr>
                    		</thead>
                    	<tbody>
                      
						<?php
						foreach ($results as $row){
						?>
                       
                        <tr>
                            <td><b><?php echo $row['ref']; ?></b></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['street_name']; ?></td>
                            <td class="text-right">
                            	<a href = "#" class="btn btn-sm btn-success">
                            	 <b>Shipping</b> <i class="fa fa-check"></i> <i class="fa fa-arrow-right"></i>  <i class="fa fa-car"></i> 
                            	</a> 
                            </td>
                        </tr>
                        
					<?php 
                    }  
                    ?> 
                    </tbody>
                </table>
                <?php 
                    } else {  
                    ?>

                    <div class="alert alert-warning"> No orders yet on the store or not found.</div>
                <?php
                    }
                    ?>

            </div>
                                                 
     		</div>          
		</div>                   
                    
     </div>          
</div>
</div>



<?php include '../includs/footer.php'; ?>
