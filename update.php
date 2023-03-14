<?php

session_start();
//connect db
$con = mysqli_connect("localhost","root","");
mysqli_select_db($con,'login_grocery_db');


$product_id = $_POST['product_id'];
$product_name=$_POST['product_name'];
$product_qty=$_POST['product_qty'];
$unit_price= $_POST['unit_price'];
$id =$_POST['id'];


// if delete button was used
if(isset($_POST['delete']))
{
	// delete quesry
	$del = "DELETE from products WHERE id='$id'";
	$query_run=mysqli_query($con, $del);
	if($query_run)
	{
		echo '<script type ="text/javascript"> alert("Product Deleted") </script>';
	}
	else
	{
		echo '<script type ="text/javascript"> alert("Product Not Deleted") </script>';
	}
}

	//if submit button was used
	//update query
	$sql = "UPDATE products SET product_id='$product_id', product_name='$product_name',product_qty='$product_qty', unit_price='$unit_price' WHERE id='$id'";

	echo "$id";
	echo "$product_name";

	//execute query
	if(mysqli_query($con,$sql)){
		// successful
		echo "Product(s) updated.";
	}

	else {
		// unsuccessful
		echo "Product Not Updated";
	}

?>

<html>
<body>
	<!-- ref: https://www.studentstutorial.com/php/php-mysql-data-update -->

            <p>Click <a href="updateinv.php">here</a> to update inventory</p>
            <p>Continue browsing? <a href="welcome.php">Home page</a></p>
        </form>
    </div>    
</body>
</html>