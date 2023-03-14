<?php
session_start();


$con = mysqli_connect("localhost","root","");
mysqli_select_db($con,'login_grocery_db');


if(isset($_POST['add_to_cart'])){

    if(isset($_SESSION['cart'])){

        $session_array_id = array_column( $_SESSION['cart'],'id');

        if(!in_array($_GET['id'], $session_array_id)){
            $count = count($_SESSION['cart']);
            $session_array = array(
            'id' => $_GET['id'],
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "quantity" => $_POST['quantity']);

        $_SESSION['cart'][$count] = $session_array;

        }

    }else{

        // store the data here
        $session_array = array(
            'id' => $_GET['id'],
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "quantity" => $_POST['quantity']);

        $_SESSION['cart'][] = $session_array;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>

        body {
     font-family: "Roboto", sans-serif;
     letter-spacing: 3px;
}
    </style>
</head>

<body>
    <center>
    <a href="welcome.php" class="btn btn-danger ml-3">Return to Home Page</a> 
    <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h2 class ="text-center">Order Page</h2>        
                        <div class="col-md-12">
                            <div class="row">

                    <?php

                    // display products from products database

                    $query= "SELECT * from products"; 
                    $result= mysqli_query($con,$query);
                    while($row = mysqli_fetch_array($result)){?>
                        <div class="col-md-4">
                        <form method="post" action="index.php?id=<?=$row['id'] ?>">
                  <!--          <img src="img/<?= $row ['image'] ?>" style='height: 150px;'> -->
                          <td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['img']).'" alt="Image" style="width: 150px; height: 150px;" > '; ?></td>
                            <h5 class="text-center"><?= $row['product_name']; ?></h5>
                            <h5 class="text-center"><?= number_format($row['unit_price'],2); ?></h5>
                            <input type="hidden" name="name" value="<?= $row['product_name']; ?>">
                            <input type="hidden" name="price" value="<?= $row['unit_price']; ?>">
                            <input type="number" name="quantity" value="1" class="form-control">
                            <input type="submit" name="add_to_cart" class="btn btn-warning btn-block my-2" value="Add to Cart">
                        </form>
                        </div>        
                    <?php }

                    ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">            
                    <h2 class ="text-center">Items Selected</h2>
                      <?php 

                      // show items added to cart 

                      $total = 0;  
                      $output = "";
                      $output .= "
                        <table class='table table-bordered table-striped'>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Product Price</th>
                            <th>Item Quantity</th>  
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>   
                       ";

                       if(!empty($_SESSION['cart'])){
                            foreach ($_SESSION['cart'] as $key => $value) {
                                $output .= "
                                <tr>
                                    <td>".$value['id']."</td>
                                    <td>".$value['name']."</td>
                                    <td><center>".$value['price']."</center></td>
                                    <td><center>".$value['quantity']."</center></td>
                                    <td><center>".number_format(($value['price']) * ($value['quantity']),2)."</center></td>
                                    <td>
                                        <a href='index.php?action=remove&id=".$value['id']."':
                                        <button class='btn btn-danget btn block'>Remove</button></a>
                                    </td>
                                    <td>
                                        <a href='index.php?action=order&id=".$value['id']."'>
                                        <button class='btn btn-warning'>Order Product</button></a>
                                        
                                    </td>

                                ";

                                $total = $total + $value['quantity'] * $value['price'];
                            }

                             $output .= "
                                <tr>
                                <td colspan='3'></td>
                                <td><b>Total Price</b></td>
                                <td>".number_format($total,2)."</td>
                                <td>
                                    <a href='index.php?action=clearall'>
                                    <button class='btn btn-warning'>Clear</button>
                                </td>
                                
                                </form>
                                </tr>
                            ";

                       }

                       echo $output;
                    ?>
                    
                </div>

            </div>
        </div>
    </div>

    <?php



    if(isset($_GET['action']))
    {
        if($_GET['action'] == "clearall"){
            unset($_SESSION['cart']);
        }
        if($_GET['action'] == "remove"){

            foreach ($_SESSION['cart'] as $key => $value) {

                if($value["id"] == $_GET['id']){

                unset($_SESSION['cart'][$key]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="index.php"</script>';

                }
            }
        }

        if($_GET['action'] == "order")
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

                        if(mysqli_query($con,$sql))
                        {
                        // successful
                            echo '<script>alert("Success. Your Order# is: #'.$order_id.'")</script>';
                            echo '<script>window.location="confirmation.php"</script>';  
                        }
                }
                else 
                {
                    // unsuccessful
                    echo "Product Not Ordered";
                }     
            }
        }
    }

?>
</center>
</body>
</html>


<!-- OLD PLACE ORDER BUTTON <td><input type='submit' name='placeorder' value='Place Order' class='btn btn-warning'></td> -->