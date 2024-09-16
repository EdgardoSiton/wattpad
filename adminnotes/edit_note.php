<?php
include_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the edit_note_id and edit_title fields are set
    if (isset($_POST["edit_note_id"]) && isset($_POST["edit_title"])) {
        // Sanitize and validate the input data
        $note_id = $_POST["edit_note_id"];
        $title = trim($_POST["edit_title"]); // Trim whitespace
        $description = trim($_POST["edit_description"]); // Trim whitespace
        
        // Check if title or description is empty after trimming whitespace
        if (empty($title) || empty($description)) {
            // Redirect back to the form page or display an error message
            echo json_encode(["success" => false, "error" => "Title and description are required."]);
            exit();
        }

        // Prepare SQL statement to update the note
        $sql = "UPDATE note SET title=?, description=?, update_at=CURRENT_TIMESTAMP WHERE note_id=?";

        // Prepare the SQL statement
        if ($stmt = $link->prepare($sql)) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssi", $title, $description, $note_id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Note updated successfully
                echo json_encode(["success" => true]);
            } else {
                // Error executing the statement
                echo json_encode(["success" => false, "error" => "Error executing the statement: " . $stmt->error]);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error preparing the statement
            echo json_encode(["success" => false, "error" => "Error in preparing statement: " . $link->error]);
        }
    } else {
        // Required fields not set
        echo json_encode(["success" => false, "error" => "edit_note_id and edit_title are required fields"]);
    }
} else {
    // Not a POST request
    echo json_encode(["success" => false, "error" => "This script only accepts POST requests"]);
}

// Close the database connection
$link->close();
?>
