<?php 
	require_once '../api/admin.php';
?>
 

 <div class="container content-dashboard">
    <div class="row my-3">
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
                    	<a href="order.php">Orders</a>
                    </li>
                    <li class="list-group-item">
                    <a href="./list-users.php">List users</a>
                    </li>
                </ul>
            </div>
        </div>
  
        <div class="col">
            <div class="row"> 
                <div class="alert alert-info">
                    Bienvenue <b><?php echo $_SESSION['username']; ?></b>
                </div>
                                     
     		</div>          
		</div>                   
                    
     </div>          
</div>
                   
<?php include '../includs/footer.php'; ?>
                   
