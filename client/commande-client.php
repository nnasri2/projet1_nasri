<?php
require_once '../api/user.php';


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
                    	<a href="./commande-client.php">Commande</a>
                    </li>
                    <li class="list-group-item">
                    <a href="./profile.php">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
  
        <div class="col">
            <div class="row my-3"> 
            
        		<div class="col-12">
            		<div class="table-responsive">
                		<table class="table table-striped">
                    		<thead>
                        		<tr>
									<th scope="col"> Order ID </th>
									<th scope="col"> Nom de produits </th>
									<th scope="col"> Quantity </th>
									<th scope="col" class="text-center"> 
                       					Price 
                       				</th>
                        		</tr>
                    		</thead>
                    	<tbody>
                      
						<?php

							$query = "SELECT order_id, name, op.quantity, p.price 
                                    FROM order_has_product AS op
                                    INNER JOIN product AS p ON op.product_id = p.id";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
							foreach ($results as $row){

						?>
                       
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td class="text-right">
                            	<a href = "#" class="btn btn-sm btn-warning">
                            		<i class="fa fa-check"></i>
                            	</a> 
                            </td>
                        </tr>
                        
					<?php } ?>

                    </tbody>
                </table>
            </div>
                                                 
     		</div>          
		</div>                   
                    
     </div>          
</div>
</div>



<?php include '../includs/footer.php'; ?>
