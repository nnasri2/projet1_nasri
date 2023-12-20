<?php 

require_once 'api/db.php';
require_once 'api/site.config.php';
include 'includs/header.php'; 

	$info = [
		'street_name' => null,
		'city' => null,
		'zip_code' => null,
		'province' => null,
		'country' => null,
		'street_nb' => null,

	];

	if (isset($_SESSION['user_id'])) {

		$user_id = $_SESSION['user_id'];
		$query = "SELECT * FROM user WHERE id=?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "i", $user_id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		// Fetch the user row
		$user = mysqli_fetch_assoc($result);

		// Prepare and execute the second SELECT query
		$query = "SELECT shipping_address_id FROM user WHERE id=?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "i", $user_id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		// Fetch the result
		$result = mysqli_fetch_assoc($result);

		// Close the statements
		mysqli_stmt_close($stmt);

		if ($result !== false) {
			$id_adress = $result['shipping_address_id'];
		}

		if($id_adress != 0){
			// Get user information
			$query = "SELECT * FROM address WHERE id=?";
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "i", $id_adress);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			// Fetch the row
			$info = mysqli_fetch_assoc($result);

			// Close the statement
			mysqli_stmt_close($stmt);
		}

	}

	function AddOrder() {
		global $conn;
//		foreach ($_SESSION['cart'] as $productId) {
//			$price = getPriceById($productId);
//			$stmt = $pdo->prepare("INSERT INTO order_has_product (order_id , product_id, quantity, price) VALUES (?, ?, ? , ?)");
//			$stmt->execute([1,$productId, 1, $price]);
//		}
		
		if (!empty($_SESSION['cart'])) {
			// Iterate through each item in the cart
			foreach ($_SESSION['cart'] as &$cartItem) {
				// Check if the current item has the desired product ID
				if (isset($cartItem['id'])) {
					$price = getPriceById($productId);
					$cartItem['quantity'] = $quantity;

					$orderId = 1;

					$query = "INSERT INTO order_has_product (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
					$stmt = mysqli_prepare($conn, $query);
					mysqli_stmt_bind_param($stmt, "iiid", $orderId, $productId, $cartItem['quantity'], $price);


				}
			}
    	}
	}

	// Function to get the price of a product by ID
	function getPriceById($productId) {
		global $conn;
		// Prepare and execute the SELECT query
			$query = "SELECT price FROM product WHERE id = ?";
			$stmt = mysqli_prepare($conn, $query);
			mysqli_stmt_bind_param($stmt, "i", $productId);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			// Fetch the result
			$row = mysqli_fetch_assoc($result);

			// Close the statement
			mysqli_stmt_close($stmt);

			if ($row !== null) {
				return $row['price'];
			} else {
				return null; // Return null if the product ID is not found
			}
	}

	function getTotalPrice(){
		
		global $conn;

		if(!empty($_SESSION['cart'])){
			
			$productIds = array_column($_SESSION['cart'], 'id');
				
			$total = 0;
						
			foreach ($_SESSION['cart'] as &$cartItem) {
				
				$query = "SELECT * FROM product WHERE id = ?";
				$stmt = mysqli_prepare($conn, $query);
				mysqli_stmt_bind_param($stmt, "i", $cartItem['id']);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);

				// Fetch all results
				$results = mysqli_fetch_all($result, MYSQLI_ASSOC);

				// Close the statement
				mysqli_stmt_close($stmt);
				
				foreach ($results as $row){
					
					$total = $total + ($row['price']*$cartItem['quantity']);	
					
				}
				
			}
			return $total;
			
		}
		
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
		$user_id = $_SESSION['user_id'];
		$total = 0;
		$total = getTotalPrice();
		if($total < 1){
			echo "<script>alert('total = 0 !!')</script>";
			header('Location: '.$site_link.'command.php ' );
		}
				
		$today = date("Y-m-d");
		$ref = "#ref".rand(1, 1000);
		
		$query = "INSERT INTO user_order (ref, date, total, user_id) VALUES (?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "issi", $ref, $today, $total, $user_id);

		mysqli_stmt_execute($stmt);
		$lastInsertId = mysqli_insert_id($conn);
		mysqli_stmt_close($stmt);
	

		if(!empty($_SESSION['cart'])){
				
			foreach ($_SESSION['cart'] as &$cartItem) {
				// Check if the current item has the desired product ID
				if (isset($cartItem['id'])) {
														
					$query = "SELECT * FROM product WHERE id = ?";
					$stmt = mysqli_prepare($conn, $query);
					mysqli_stmt_bind_param($stmt, "i", $cartItem['id']);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);

					// Fetch all results
					$results = [];
					while ($row = mysqli_fetch_assoc($result)) {
						$results[] = $row;
					}

					// Close the statement
					mysqli_stmt_close($stmt);
			
					foreach ($results as $row){

						$query = "INSERT INTO order_has_product (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
						$stmt = mysqli_prepare($conn, $query);
						mysqli_stmt_bind_param($stmt, "iiid", $lastInsertId, $cartItem['id'], $cartItem['quantity'], $row['price']);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);

					}
				}
			}
		}
		
		$adress_street_name = $_POST['street_name'];
		$adress_street_nb = 25;
		$adress_city = $_POST['city'];
		$adress_zip_code = $_POST['zip_code'];	
		$adress_country = $_POST['country'];
		$province = $_POST['province'];	
	
		// Insert the user into the database
	
		$query = "INSERT INTO address (street_name, street_nb, city, province, zip_code, country) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "ssssss", $adress_street_name, $adress_street_nb, $adress_city, $province, $adress_zip_code, $adress_country);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		
		if(isset($_POST['flexRadioDefault'])){
			
			if($_POST['flexRadioDefault'] == 'paypal'){
				
				$confirmation = $site_link.'confirmation.php';
				$redirectUrl = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=client@gmail.com&item_name=Product&amount='.$total.'&currency_code=USD&return='.$confirmation;
				header('Location: ' . $redirectUrl);

			}else{
				
				header('Location: ./confirmation.php');
				exit;
				
			}
		}
		   
		unset($_SESSION['cart']);
		   


	}

?>

<div class="container mb-4">
    <div class="row">	
    	<!-- Display the Cart -->
		<section class="jumbotron text-center">
			<div class="container">
				<br>
					<h1 class="jumbotron-heading">Commande</h1>
				<br>
			</div>
		</section>
		<?php if (!isset($_SESSION['user_id'])) {?>
		<div class="alert alert-warning" role="alert">
			vous devez vous <a href="./login.php">connecter</a> pour continuer
		</div>
		<?php }else{ ?>
 <div class="container">
    <div class="row">
           
		<form class="form-horizontal" action="command.php" method="post" enctype="multipart/form-data">
       
			<div class="col-12 col-sm-3">
			
				<div class="form-check">
				  <input class="form-check-input" value="livraison" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
				  <label class="form-check-label" for="flexRadioDefault1">
					paiement à la livraison
				  </label>
				</div>
				
				<div class="form-check">
				  <input class="form-check-input" value="paypal" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
				  <label class="form-check-label" for="flexRadioDefault2">
					paiement avec Paypal
				  </label>
				</div>
				
			</div>
        	<div class="col">
            <div class="row"> 
            <div class="profile-form"> 
			<div class="container">
				<div class="row">
          		            
           		<div class="col-md-6">
              		<div class="form-group">
                    	<label for="fname">First Name:</label>
                    	<input type="text" class="form-control" name="fname" id="fname" value="<?php echo $user['fname']; ?>" readonly>
                	</div>
                	<div class="form-group">
                    	<label for="lname">Last Name:</label>
                    	<input type="text" class="form-control" name="lname" id="lname" value="<?php echo $user['lname']; ?>" readonly>
                	</div>
                	<div class="form-group">
                    	<label for="email">Email:</label>
                    	<input type="email" class="form-control" name="email" id="email" value="<?php echo $user['email']; ?>" readonly>
                	</div>             	
            	</div>
                <div class="col-md-6">
                  
                   	<div class="form-group">
                    	<label for="street_name">Rue :</label>
                    	<input type="text" class="form-control" name="street_name" id="street_name" value="<?php echo $info['street_name']; ?>" >
                	</div>
                	
                   	<div class="form-group">
                    	<label for="street_nb">N° Rue :</label>
                    	<input type="text" class="form-control" name="street_nb" id="street_nb" value="<?php echo $info['street_nb']; ?>" >
                	</div>               	
                   	
                   	<div class="form-group">
                    	<label for="city">Ville</label>
                    	<input type="text" class="form-control" name="city" id="city" value="<?php echo $info['city']; ?>" >
                	</div>               	

               	   	<div class="form-group">
                    	<label for="province">Province</label>
                    	<input type="text" class="form-control" name="province" id="province" value="<?php echo $info['province']; ?>" >
                	</div>               	

                	<div class="form-group">
                    	<label for="zip_code">zip code</label>
                    	<input type="text" class="form-control" name="zip_code" id="zip_code" value="<?php echo $info['zip_code']; ?>" >
                	</div>                  	
 
                 	<div class="form-group">
                    	<label for="country">Country</label>
                    	<input type="text" class="form-control" name="country" id="country" value="<?php echo $info['country']; ?>" >
                	</div>                	               	               	
                	               	               	             	
            	</div>
			</div>             	
          </div>                
                
                <br>
                <button type="submit" class = "btn btn-primary" name="ter_cmd">Commander</button>
                
                                                 
     		</div>          
     		</div>          
		</div>  
		                 
		</form>     
	</div>          
</div>
		<?php } ?>	
	</div>	
</div>	


<?php include 'includs/footer.php'; ?>
