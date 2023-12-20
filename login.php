<?php
require_once 'api/db.php';
include 'includs/header.php'; 


// Check if a user is already logged in
if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
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
    // Get user input from the login form
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    // Retrieve user data from the database based on the provided username or email
    $query = "SELECT * FROM user WHERE user_name = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username_email, $username_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user && password_verify($password, $user['pwd'])) {
        // Retrieve the user's role
        $query = "SELECT name FROM role WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $roleId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $role);
        mysqli_stmt_fetch($stmt);

        // Perform role-based redirection
        if($user['role_id'] == 3){
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['role_id']  = $user['role_id'];
            $_SESSION['role']     = 'super';
             header('Location: super/dashboard.php');
        }elseif($user['role_id'] == 2){
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['role_id']  = $user['role_id'];
            $_SESSION['role']     = 'admin';
             header('Location: admin/dashboard.php');
        }elseif($user['role_id'] == 1){
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['role_id']  = $user['role_id'];
            $_SESSION['role']     = 'admin';
             header('Location: client/dashboard.php');
        }else{
            displayErrorMessage('Invalid role');
        }
    } else {
        // Password is incorrect or user not found, display an error message
        displayErrorMessage('Invalid username/email or password');
    }
}
?>

<!-- HTML form for login -->
<link rel="stylesheet" type="text/css" href="./styles/login.css">
<div class="container mb-3 main-index">
    <div class="row">
    
    <section class="jumbotron ">
    <div class="container">
   		<br>
      	<h1 class="jumbotron-heading">Login</h1>
        <p> Connect to access your dashboard</p>
      	<br>
    </div>
	</section>
    
	<div id="error-message"></div>

	<form  method="POST" action="login.php">
        <div class="form-group">
        <label for="username_email" class="col-md-4 control-label">Username or Email:</label>
        <div class="col-md-4">
        <input class="form-control input-md" placeholder="username/email" type="text" id="username_email" name="username_email" required>
        </div>
        </div>

        <div class="form-group">
        <label for="password" class="col-md-4 control-label">Password:</label>
        <div class="col-md-4">
        <input class="form-control input-md" placeholder="Password" type="password" id="password" name="password" required>
        </div>
        </div>

		<button type="submit" class="btn btn-success">Log In</button>
	</form>


	<a href="signup.php" class="my-4">Créer un compte</a>
	
	</div>
</div>

<?php include 'includs/footer.php'; ?>
