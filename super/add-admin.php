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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $roleId = 2;
    $billingAddressId = 0;
    $shippingAddressId = 0;
    $token = '-';
	
	// Check if the username or email already exists
    $query = "SELECT COUNT(*) FROM user WHERE user_name = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

if ($count > 0) {
    // Display an error message if the username or email is already taken
    echo "Username or email already exists";
} else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (user_name, email, pwd, fname, lname, role_id, billing_address_id, shipping_address_id, token) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssiiis", $username, $email, $hashedPassword, $firstName, $lastName, $roleId,
        $billingAddressId, $shippingAddressId, $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

        // Redirect to the client dashboard
        header('Location: ./list-users.php');
    }
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

 <h1>Add Admin</h1>
<form class="form-horizontal" action="?" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Admin user</legend>

<div class="form-group">
<label for="username" class="col-md-4 control-label">Username:</label>
<div class="col-md-4">
<input class="form-control input-md" placeholder="Unique username" type="text" id="username" name="username" required>
</div>
</div>

<div class="form-group">
<label for="email" class="col-md-4 control-label">Email:</label>
<div class="col-md-4">
<input class="form-control input-md"   placeholder="Email" type="email" id="email" name="email" required>
</div>
</div>

<div class="form-group">
<label for="password" class="col-md-4 control-label">Password:</label>
<div class="col-md-4">
<input class="form-control input-md"  placeholder="Password" type="password" id="password" name="password" required>
</div>
</div>

<div class="form-group">
<label for="first_name" class="col-md-4 control-label">First Name:</label>
<div class="col-md-4">
<input class="form-control input-md"  placeholder="First Name" type="text" id="first_name" name="first_name" required>
</div>
</div>

<div class="form-group">
<label for="last_name" class="col-md-4 control-label">Last Name:</label>
<div class="col-md-4">
<input class="form-control input-md"  placeholder="Last Name" type="text" id="last_name" name="last_name" required>
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



