<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
<?php session_start(); ?>

<!DOCTYPE html>

<head>

    <title>Update Inventory</title>

</head>
<body>


<?php

//connect db
$con = mysqli_connect("localhost","root","");
mysqli_select_db($con,'login_grocery_db');

    //select query
    $sql = "SELECT * FROM products";

    //execute query
    $inventory = mysqli_query($con,$sql);

?>

<?php
    if(isset($_SESSION['status']))
    {
    echo "<h4>".$_SESSION['status']."</h4>";
    unset($_SESSION['status']);
    }
?>

<h2> Update/Delete Inventory </h2>

<table> 
    <tr>
        <th>ID Number</th>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Quantity</th>
        <th>Unit Price</th>
    </tr>
    
    <?php
        while($row = mysqli_fetch_array($inventory))
        {

            echo "<tr><form action=update.php method=post>";
            //echo "<input type=hidden name=id value=''" .$row['id']."'>";
            echo "<td><input type=text name=id value='".$row['id']."'></td>";
            echo "<td><input type=text name=product_id value='".$row['product_id']."'></td>";
            echo "<td><input type=text name=product_name value='".$row['product_name']."'></td>";
            echo "<td><input type=text name=product_qty value='".$row['product_qty']."'></td>";
            echo "<td><input type=text name=unit_price value='".$row['unit_price']."'></td>";
            echo "<td><input type=submit>";
            echo "<td><input type=submit name='delete' value='Delete'>";
            echo "</form></tr>";
        }
    ?>    

            <p>Click <a href="inventory.php">here</a> to add inventory</p>
            <p>Continue browsing? <a href="welcome.php">Home page</a></p>

</body>
</html>

