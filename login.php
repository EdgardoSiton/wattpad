<?php
// Include the database connection
include 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, fullname, password FROM user WHERE username = ?";
    $errors = array();  // Updated from $error to $errors

    // Validation for username
    if (empty($username)) {
        $errors['username'] = "Please enter your username";
    }

    // Validation for password
    if (empty($password)) {
        $errors['password'] = "Please enter your password";
    }

    // Proceed only if there are no errors
    if (empty($errors)) {
        // Prepare and execute the statement
        if ($stmt = $link->prepare($sql)) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("s", $username);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store the result
                $stmt->store_result();
                
                // Check if a row was returned
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($user_id, $fullname, $hashed_password);
                    
                    // Fetch the result
                    $stmt->fetch();
                    
                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start session and redirect to dashboard
                        session_start();
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $username; 
                        $_SESSION['fullname'] = $fullname;  // Set fullname correctly
                        header("Location: adminnotes/dashboard.php");
                        exit(); 
                    } else {
                        $errors['password'] = "Invalid credentials";
                    }
                } else {
                    // No user found with the given username
                    $errors['username'] = "Invalid credentials";
                }
            } else {
                // Error handling
                $errors['db'] = "Error executing the statement: " . $stmt->error;
            }
        } else {
            // Error handling
            $errors['db'] = "Error preparing statement: " . $link->error;
        }

        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $link->close();
}
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

</head>
<body>
<?php include 'header.php'; ?>
<div class="login-container">
<div class="screen">
		<div class="screen__content">
    <form class="login" action="" method="post" novalidate>
    <h1>Log in</h1>
            <div class="inputbox">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
                <?php if(isset($errors['username'])): ?>
                    <span class="error-msg"><?php echo $errors['username']; ?></span>
                <?php endif; ?>
            </div>
            <div class="inputbox">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt' ></i>
                <?php if(isset($errors['password'])): ?>
                    <span class="error-msg"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn" name="submit">Login</button>
            <div class="register-link">
                <p> Don't have an account? <a href="register.php">Register</a></p>
            </div>
    </form>
    <div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>	
</div>
</div>
</div>
</body>
</html>

