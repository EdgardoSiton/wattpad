<?php
// Include the database connection
include 'database.php';
// Start or resume session
session_start();

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or show error message
    echo "Error: User not authenticated.";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = trim($_POST['title']); // Trim whitespace
    $description = trim($_POST['description']); // Trim whitespace
    $user_id = $_SESSION['user_id'];

    // Check if title or description is empty after trimming whitespace
    if (empty($title) || empty($description)) {
        // Redirect back to the form page or display an error message

        echo "Error: Title and description are required.";
        header("Location: dashboard.php");
        exit();
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO note (title, description, user_id, update_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
    
    if ($stmt = $link->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssi",  $title, $description,$user_id);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Note added successfully
            // Redirect to dashboard or show success message
            header("Location: dashboard.php");
            exit();
        } else {
            // Error handling
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Error handling for failed prepare
        echo "Error in preparing statement: " . $link->error;
    }
    
    // Close connection
    $link->close();
}
?>
