<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ./home");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM psu440users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
							
							// Password is correct, now check if user account is active
							$sqlactivecheck = "SELECT username FROM psu440users WHERE id = ? AND is_active = '1'";
							$stmttwo = mysqli_prepare($link, $sqlactivecheck);
							mysqli_stmt_bind_param($stmttwo, "s", $id);
								if(mysqli_stmt_execute($stmttwo)){
									mysqli_stmt_store_result($stmttwo);
										if(mysqli_stmt_num_rows($stmttwo) == 1){
											
											// User Account is verified as active, start session
											session_start();
                            
											// Store data in session variables
											$_SESSION["id"] = $id;
											$_SESSION["loggedin"] = true;
											$_SESSION["username"] = $username;                            
							
											// Redirect user to welcome page
											header("location: ./home");
											}
										else {
											// Display an error message that user account is not active
											$password_err = "Error validating account status.";	
											}
									}
						} else {
						// Display an error message if password is not valid
						$password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="bin/css.css">
</head>
<body>
	<div class="login-container">
		<div class="login-wrapper1">
			<div class="login-title1"><center>IST 440W</center></div>
			<div class="login-title2"><center>TEAM 3</center></div>
			<img src="./bin/psuEmblem.png" class="login-img"></img>
			<div class="login-title3"><center>SPRING 2021</center></div>
		</div>
		<div class="login-wrapper2">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Unable to login?  Email <b><a href="mailto:hmg7@psu.edu">hmg7@psu.edu</a></b> for access.</p>
        </form>
		</div>   
	</div>	
</body>
</html>
