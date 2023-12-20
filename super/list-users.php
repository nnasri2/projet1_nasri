<?php 
	require_once '../api/super.php';
// Function to delete a product by ID
function deleteUser($id) {
	global $conn;
   $query = "DELETE FROM user WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
    echo "<div class='success'>User Deleted successfully.</div>";
    header('Location: ./list-users.php');
    } else {
    die("<div class='error'>ERROR : " . mysqli_error($conn) . "</div>");
    }
}

 
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the action is "delete"
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        deleteUser($id);
    }

    if (isset($_GET['action']) && $_GET['action'] == 'upgradeadmin') {
                $query = "UPDATE user SET role_id=2 WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
        header('Location: ./list-users.php');
        echo "<div class='success'>User information updated successfully.</div>";
        } else {
        header('Location: ./list-users.php');
        echo "<div class='error'>ERROR : " . mysqli_error($conn) . "</div>";
        }
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
                    <!-- <li class="list-group-item">
                    	<a href="./order.php">Orders</a>
                    </li> -->
                    <li class="list-group-item active">
                    <a href="./list-users.php">List users</a>
                    </li>
                </ul>
            </div>
        </div>
  
        <div class="col">
        	<div class="row"> 
           			<div class="text-center my-4 ">
                        <a href="./add-admin.php" class="btn btn-primary">
                            <i class="fa fa-plus">Add Admin</i>
                        </a>

                        <a href="./add-user.php" class="btn btn-primary">
                            <i class="fa fa-plus">Add User</i>
                        </a>
                    </div>

  					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Username</th>
								<th>Email</th>
								<th class="td-actions">Action</th>
							</tr>
						</thead>
						<tbody>        
 				<?php

    				$query = "SELECT * FROM user";
                    $result = mysqli_query($conn, $query);
                    // Fetch all results as an associative array
                    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);

					foreach ($results as $row) {
						
				?>					
					<tr>
						<td><?php echo $row['user_name']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td class="td-actions">
                        <?php if($row['role_id'] == 1) { ?>
                        <a href="?id=<?php echo $row['id']; ?>&action=upgradeadmin" class="btn btn-small btn-warning">
						<i class="fa fa-graduation-cap"></i> Make Admin
                        </a>
                        <?php } ?>

                        <?php if(($_SESSION['role'] == 'super' && $row['role_id'] == $_SESSION['user_id'])  || $row['role_id'] != 3  ) { ?>
						<a href="./update-user.php?id=<?php echo $row['id']; ?>&action=update" class="btn btn-small btn-success">
						<i class="fa fa-edit"></i>
                        </a>
                        <?php } ?>
					
                        <?php if($row['user_name'] != "superadmin" && $row['id'] != 1) { ?>
						<a href="?id=<?php echo $row['id']; ?>&action=delete" class="btn btn-small btn-danger" >
						<i class="fa fa-trash"></i>
                        </a>

                        <?php }; ?>

						</td>
					</tr>
							


    
         
         
        
 <?php		}	

					$pdo = null;
?>                                     
                                    
							</tbody>
						</table>                                     
                                     
     </div>          
</div>                   
                    
     </div>          
</div>
                   
<?php include '../includs/footer.php'; ?>
                   
