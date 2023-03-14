<link rel="stylesheet" href="style.css">
<?php
// initialize the session
session_start();
 
// if user is logged in go to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo '<script type="text/javascript"> alert("You are already logged in.") </script>';
    header("location: home.html");

    exit;
}
 
// for config file
require_once "config.php";
 
// define and initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // validate user credentials!
    if(empty($username_err) && empty($password_err)){
        // select statement to pull from table
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // add parameters to statement above
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // parameters
            $param_username = $username;
            
            // execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // store the result
                mysqli_stmt_store_result($stmt);
                
                // if username exists, verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // start a new session when password is correct
                            session_start();
                            
                            // store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // user is redirected to welcome page
                            header("location: welcome.php");
                        } else{
                            // password error message if incorrect
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // if username doesnt exist, display error
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Something went wrong. Please try again.";
            }

            // close the statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // close sql connection
    mysqli_close($link);
}

session_destroy();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        <link rel="stylesheet" href="style.css">
    </style>
</head>
<body>
    <div class="wrapper">
    <center>   
        <h2>Login</h2>
        <p>Please enter your details.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a></p>
            <a href="home.html" class="btn btn-danger ml-3"> Return to Home Page</a>
        </form>
    </div>
</center>
</body>
</html>