<?php
require_once './api/db.php';
include 'includs/header.php';

// Check if a user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to the appropriate dashboard based on the role
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin/dashboard.php');
    } elseif ($_SESSION['role'] == 'super') {
        header('Location: super/dashboard.php');
    }else{
        header('Location: client/dashboard.php');
    }
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the signup form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];

    // Check if username or email already exists
    $query = "SELECT COUNT(*) FROM user WHERE user_name = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $query);
    // Bind the parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    // Bind the result and fetch the column value
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    // Close the statement
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        // Display an error message if username or email is already taken
        displayErrorMessage('Username or email already exists');
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = "-";
        $role_id = 1;
        $shippin_id = 0;
        $billing_id = 0;
        $query = "INSERT INTO user (user_name, email, pwd, fname, lname, role_id, billing_address_id, shipping_address_id, token) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssiiis", $username, $email, $hashedPassword, $firstName, $lastName, $role_id, $billing_id , $shippin_id , $token );
        mysqli_stmt_execute($stmt);
        // Get the newly created user's ID
        $userId = mysqli_insert_id($conn);
        // Close the statement
        mysqli_stmt_close($stmt);

        // Store user information in session variables
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';

        // Redirect to the client dashboard
        header('Location: client/dashboard.php');
        exit();
    }
}
?>

<!-- HTML form for signup -->
<link rel="stylesheet" type="text/css" href="./styles/signup.css">

<div class="container mb-3 main-index">
   
    <div class="row">
    
    <section class="jumbotron ">
    <div class="container">
   		<br>
      	<h1 class="jumbotron-heading">Inscription</h1>
        <p> Créer un compte pour passer des commandes</p>

      	<br>
    </div>
	</section>

	<div id="error-message"></div>

	<form method="POST" action="signup.php">
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
 
		<button type="submit" class="btn btn-success my-4">Sign Up</button>
</form>

	<a href="login.php" class="my-4">Login</a>


</div>
</div>
<?php include 'includs/footer.php'; ?>
