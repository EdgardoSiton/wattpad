<?php
// Include your database connection file

include_once "database.php";

// Check if the note ID is provided via POST
if(isset($_POST['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = $_POST['note_id'];

    // Prepare SQL statement to select note details based on note ID
    $sql = "SELECT * FROM note WHERE note_id = ?";
    
    // Prepare and bind parameters
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $note_id);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        // Check if the query returned a row
        if ($result->num_rows > 0) {
            // Fetch note details as an associative array
            $noteDetails = $result->fetch_assoc();
            
            // Convert note details to JSON format and send as response
            echo json_encode($noteDetails);
        }else {
        // No matching note found
        echo json_encode(["error" => "Failed to fetch updated note details"]);
    }
} else {
    // Query execution failed
    echo json_encode(["error" => "Failed to fetch updated note details"]);
}

    // Close prepared statement
    $stmt->close();
} else {
    // If note ID is not provided, return an empty object
    echo json_encode([]);
}

// Close the database connection
$link->close();
?>
