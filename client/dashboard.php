<?php
include '../includs/header-user.php'; 

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    session_destroy();
    header('Location: /login.php');
    exit();
}

// Logout function
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /login.php');
    exit();
}
?>


<section class="jumbotron ">
    <div class="container">
   		<br>
      	<h1 class="jumbotron-heading">Dashboard Client : <?php echo $_SESSION['username']; ?> </h1>
      	<br>
    </div>
</section>
 <div class="container content-dashboard">
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
                                     
     		</div>          
		</div>                   
                    
     </div>          
</div>



<?php include '../includs/footer.php'; ?>
