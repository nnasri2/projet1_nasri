<?php include 'includs/header.php'; ?>

<?php 
	$data1 = isset($_GET['total']) ? urldecode($_GET['total']) : '';

	if(isset($data1) && !empty($data1)){
		
	}

?>


<!-- Your form for personal and shipping information -->
<form action="?" method="post">
    <!-- Your form fields go here -->

    <!-- Add the PayPal payment link -->
    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=YOUR_PAYPAL_EMAIL&item_name=Your_Product_Name&amount=10.00&currency_code=USD&return=RETURN_URL_AFTER_PAYMENT" target="_blank">
        <img src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="Pay with PayPal">
    </a>

    <input type="submit"  value="Place Order">
</form>


<?php include 'includs/footer.php'; ?>
