<?php


// establish database connection
$con = mysqli_connect("localhost","root","");
mysqli_select_db($con,'login_grocery_db');


session_start();


    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }





if(isset($_POST['placeorder']))
{
        if(isset($_SESSION["cart"]))
        {
            foreach($_SESSION["cart"] as $key => $value)
        {
          if($value["id"] == $_GET['id']){
                $order_id = random_int(1000, 9999);
                $order_product_id = $_GET['id'];
                $date = date("Y-m-d H:i:s");
                $qty = $value['quantity'];
                $total_amt = (($value['price']) * ($value['quantity']));

                echo $order_product_id;
                echo $qty;
                echo $total_amt;

                $sql="INSERT INTO orders(order_id,order_product_id,order_date,qty,total_amt) VALUES ('$order_id','$order_product_id', now(),'$qty','$total_amt')";

        if(mysqli_query($con,$sql)){
        // successful
        echo "Product(s) updated.";
    }
  }

    else {
        // unsuccessful
        echo "Product Not Updated";
    }
    }
   //  $order_product_id=$_GET['id'];
   //  $qty=$_GET['quantity'];
   //  $query="INSERT into orders(order_product_id,qty) values($order_product_id,$qty)";

   // //    $query = "INSERT into orders values order_product_id='$id',qty='$quantity', total_amt='$total' WHERE id='$id'";
   //  if(mysqli_query($con,$query))
   //  {
   //      echo '<script>alert("Order Placed. Your order will be ready in 2 hours.")</script>';
   //      echo '<script>window.location="index.php"</script>';
   //  } else
   //  {
   //      echo "Order Not Placed.";
   //  }
}
}
?>

<html>
<body>

            <p><a href="welcome.php">Return to Home</a></p>
            <p><a href="logout.php">Logout</a></p>
        </form>
    </div>    
</body>
</html>

