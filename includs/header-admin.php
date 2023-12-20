<?php
session_start();
//// Check if user is not logged in
	if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
		session_destroy();
		header('Location: ../login.php');
		exit();
	}

//Logout function
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /index.php');
    exit();
}
function displayErrorMessage($message)
{
    echo '<div class="error">' . $message . '</div>';
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ECOM  Store: Admin DASHBOARD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/admin_dashboard.css">
  </head>
  <body>
<!-- HTML content for client dashboard -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container ">
        <a class="navbar-brand" href="/index.php">ECOM Store</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="/carte.php">Cart</a>
                </li> -->
            </ul>
            <div class="form-inline my-2 my-lg-0">
              
<!--
                <a class="btn btn-success btn-sm ml-4" href="cart.html">
                    <i class="fa fa-shopping-cart"></i> Cart
                    <span class="badge badge-light">3</span>
                </a>
-->
                <?php 

					if (isset($_SESSION['user_id']) ) {?>
                		<a class="btn btn-warning btn-sm ml-4" href="?logout=true">
                     		Logout
                    	</a>
                        <?php if (isset($_SESSION['role']) == 'admin' ) {?>
                    	<a class="btn btn-success" href="/admin/dashboard.php">
                                <i class="fa fa-home"></i> Dashboard</a>
                        <?php }?>
                    
                    <?php }else{ ?>
                		<a class="btn btn-primary btn-sm ml-4" href="/login.php">
                    	<i class="fa fa-user"></i>Login</a>
                    <?php } ?>

                     
            </div>

        </div>
    </div>
</nav>


