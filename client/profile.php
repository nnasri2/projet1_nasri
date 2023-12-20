<?php
include '../includs/header-user.php'; 

// Database connection
require_once '../api/db.php';

// Get user information
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Update
// Update user information
if (isset($_POST['update_user'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $query = "UPDATE user SET email=?, pwd=?, fname=?, lname=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $email, $pwd, $fname, $lname, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='success'>User information updated successfully.</div>";
        $user['email'] = $email;
        $user['pwd'] = $pwd;
        $user['fname'] = $fname;
        $user['lname'] = $lname;
    } else {
        echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!-- HTML content for profile page -->



<section class="jumbotron ">
    <div class="container">
   		<br>
      	<h1 class="jumbotron-heading">Dashboard Client : <?php echo $_SESSION['username']; ?> </h1>
      	<br>
    </div>
</section>
 <div class="container   content-dashboard">
    <div class="row">
      
       
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
            <div class="row"> 
            <div class="profile-form"> 
            <form method="POST" action="profile.php">
                <div class="form-group">  
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" name="pwd" id="pwd" value="<?php echo $user['pwd']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $user['fname']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $user['lname']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary mt-5" name="update_user">Update</button>
            </form>                                     
     		</div>          
     		</div>          
		</div>                   
                    
     </div>          
</div>



<?php include '../includs/footer.php'; ?>
