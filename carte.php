<?php 
require_once './api/db.php';
include 'includs/header-user.php'; 
?>


<!-- cart.php -->
<?php

// Initialize the cart in the session if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

	function getTotalPrice(){
		
		global $conn;

		if(!empty($_SESSION['cart'])){
			
			$productIds = array_column($_SESSION['cart'], 'id');
				
			$total = 0;
						
			foreach ($_SESSION['cart'] as &$cartItem) {
				// Prepare and execute the SELECT query
                $query = "SELECT * FROM product WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $cartItem['id']);
                mysqli_stmt_execute($stmt);

                // Fetch the results
                $result = mysqli_stmt_get_result($stmt);
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



// Function to add a product to the cart
function addToCart($productId,$quantity) {
    // Add the product ID to the cart array in the session
	$productIds = array_column($_SESSION['cart'], 'id');
	if (!in_array($productId, $productIds)) {
        // Add the product ID to the cart array in the session
		$_SESSION['cart'][] = ['id' => $productId, 'quantity' => $quantity];

    } else {
        // Product is already in the cart, you can show a message or handle it as needed
        //echo "Product with ID $productId is already in the cart.";
    }
}

// Function to remove a product from the cart
function removeFromCart($productId) {
	
	if (!empty($_SESSION['cart'])) {
        // Iterate through each item in the cart
   		foreach ($_SESSION['cart'] as $key => $cartItem) {
            // Check if the current item has the desired product ID
       		if (isset($cartItem['id']) && $cartItem['id'] == $productId) {
                // Remove the item from the cart
                unset($_SESSION['cart'][$key]);
            }
        }
	}
}

function getProductQuantity($productId) {
    // Check if the cart is not empty
    if (!empty($_SESSION['cart'])) {
        // Iterate through each item in the cart
        foreach ($_SESSION['cart'] as $cartItem) {
            // Check if the current item has the desired product ID
            if (isset($cartItem['id']) && $cartItem['id'] == $productId) {
                // Return the quantity of the item
                return $cartItem['quantity'];
            }
        }
    }

    // If the product is not in the cart or the cart is empty, return 0 or another default value
    return 0;
}

// Function to update the quantity of a product in the cart
function updateQuantity($productId, $quantity) {
	    if (!empty($_SESSION['cart'])) {
        // Iterate through each item in the cart
        foreach ($_SESSION['cart'] as &$cartItem) {
            // Check if the current item has the desired product ID
            if (isset($cartItem['id']) && $cartItem['id'] == $productId) {
                // Update the quantity of the item
                $cartItem['quantity'] = $quantity;
            }
        }
    }
}



// Check if the "action" and "id" parameters are set in the URL
if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['quantity'])) {
    $action = $_GET['action'];
    $productId = $_GET['id'];
	$quantity = $_GET['quantity'];
	

    // Check the action and perform the corresponding operation
    switch ($action) {
        case 'add':
            addToCart($productId,$quantity);
            break;
		case 'remove':
            removeFromCart($productId);
            break;
        case 'update':
            updateQuantity($productId, $quantity);
            break;
    }
	
}
?>

<!-- Display the Cart -->
<section class="jumbotron text-center">
    <div class="container">
   		<br>
      	<h1 class="jumbotron-heading">Panier</h1>
      	<br>
    </div>
</section>

<div class="container mb-4 content-dashboard">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">Product</th>
                            <th scope="col">Available</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-right">Price</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    <?php
						if(!empty($_SESSION['cart'])){
							
							$productIds = array_column($_SESSION['cart'], 'id');

						foreach ($productIds as $productId) {
						
						$query = "SELECT * FROM product WHERE id = ?";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "i", $productId);
                        mysqli_stmt_execute($stmt);

                        // Fetch the results
                        $result = mysqli_stmt_get_result($stmt);
                        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        // Close the statement
                        mysqli_stmt_close($stmt);
						foreach ($results as $row){
						
					?>
                       
                        <tr>
                            <td><img width = "50px" src="<?php echo './uploads/'.$row['img_url']; ?>" /> </td>
                            <td><?php echo $row['name']; ?></td>
                            <td>In stock</td>
                            <td>
                            	<form class = "item_quantity" action="?" method="get">
									<input class="form-control" type="number" min="1" name="quantity" value="<?php echo getProductQuantity($row['id']); ?>" width="50px" />
									<input type="hidden" name="action"  value="update" />
									<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
									<button class="btn btn-sm btn-warning mt-2"  type="submit"><i class="fa fa-check"></i> Update</button>
								</form>
                            <td class="text-right"><?php echo $row["price"]; ?> $</td>
                            <td class="text-right"><a href = "carte.php?action=remove&id=<?php echo $row['id']; ?>&quantity=<?php echo $row['quantity']; ?>"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </a> </td>
                        </tr>
                        
					<?php }}} ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right"><?php echo getTotalPrice();  ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Shipping</td>
                            <td class="text-right">Gratuit</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2" class = "item_command" >
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <a href="./index.php" class="btn btn-block btn-light">Continue Shopping</a>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="./command.php" id = "getQuantity" data-quantity = "" class="btn btn-lg btn-block btn-success text-uppercase">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'includs/footer.php'; ?>
