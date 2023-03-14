<link rel="stylesheet" href="style.css">
<?php
session_start();
// for config file
 require_once "config.php";
 

if(isset($_POST['upload'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_qty = $_POST['product_qty'];
    $unit_price = $_POST['unit_price'];   
    $file = addslashes(file_get_contents($_FILES['img']['tmp_name']));

    $query = "INSERT into products(product_id,product_name,product_qty,unit_price,img) VALUES ('$product_id','$product_name','$product_qty','$unit_price','$file')";
    $query_run = mysqli_query($link,$query);
    if($query_run)
    {
        echo '<script type="text/javascript"> alert("Product Added.") </script>';
    } else {
        echo '<script type="text/javascript"> alert("Error: Product Not Added.") </script>';
    }
}



?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Inventory</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
        
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Page 2</h2>
        <p>Inventory</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product ID</label>
                <input type="text" name="product_id" class="form-control" required>
            </div>    
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>  
            <div class="form-group">
                <label>Product Quantity</label>
                <input type="text" name="product_qty" class="form-control" required>
            </div>  
            <div class="form-group">
                <label>Unit Price</label>
                <input type="text" name="unit_price" class="form-control" required> 
            </div>            
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="img" id="img" required>  
            </div>
            <div class="form-group">
                <input type="submit" name="upload" class="btn btn-primary" value="Submit">
            </div>
            <p>Click <a href="updateinv.php">here</a> to update inventory</p>
            <p>Continue browsing? <a href="welcome.php">Home page</a></p>
        </form>
    </div>    
</body>
</html>