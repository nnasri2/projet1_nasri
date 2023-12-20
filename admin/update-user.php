<?php

	require_once '../api/admin.php';

	if (isset($_GET['id'])) {

		$user_id = $_GET['id'];
		$query = "SELECT * FROM user JOIN role ON user.role_id = role.id WHERE user.id = ?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "i", $user_id);

		if (mysqli_stmt_execute($stmt)) {
		$result = mysqli_stmt_get_result($stmt);
		$user = mysqli_fetch_assoc($result);
		// return var_dump($result);
		// Process the fetched user data here
		} else {
		die("Error: " . mysqli_error($conn));
		}

	}


	if (isset($_POST['update_user'])) {

		$email = $_POST['email'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];

		$query = "UPDATE user SET email=?, fname=?, lname=? WHERE id=?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "sssi", $email, $fname, $lname, $user_id);

		if (mysqli_stmt_execute($stmt)) {
		echo "<div class='success'>User information updated successfully.</div>";
		
		// Update the user data in the $user array
		$user['email'] = $email;
		
		// if ($role_user == 1) {
		// 	$user['name'] = 'super';
		// } elseif ($role_user == 2) {
		// 	$user['name'] = 'admin';
		// } else {
		// 	$user['name'] = 'user';
		// }
		
		// $user['role_id'] = $role_user;
		$user['fname'] = $fname;
		$user['lname'] = $lname;
		} else {
		echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
		}

	}

?>

<!-- HTML content for profile page -->
 
 <div class="container content-dashboard">
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
            <div class="profile-form"> 
            <form method="POST">
                
                 <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input class="form-control" type="text" name="fname" id="fname" value="<?php echo $user['fname']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input class="form-control" type="text" name="lname" id="lname" value="<?php echo $user['lname']; ?>" required>
                </div>              
               
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>
                </div>
                
                <button type="submit" class="mt-5 btn btn-success" name="update_user">Update</button>
                
            </form>                                     
     		</div>          
     		</div>          
		</div>                   
                    
     </div>          
</div>



<?php include '../includs/footer.php'; ?>
