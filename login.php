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
