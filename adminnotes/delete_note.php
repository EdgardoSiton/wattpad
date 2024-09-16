<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['note_id'])) {
    // Include your database connection file
    include_once "database.php";

    // Prepare SQL statement to delete the note
    $sql = "DELETE FROM note WHERE note_id = ?";

    // Prepare the SQL statement
    if ($stmt = $link->prepare($sql)) {
        // Bind the note_id parameter to the prepared statement
        $stmt->bind_param("i", $noteId);

        // Set the note ID from the POST request
        $noteId = $_POST['note_id'];

        // Execute the query
        if ($stmt->execute()) {
            // Deletion successful
            echo "Note deleted successfully.";
        } else {
            echo "Error executing the query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error handling for failed prepare
        echo "Error in preparing statement: " . $link->error;
    }

    // Close the database connection
    $link->close();
} else {
    // Redirect if the request method is not POST or note_id is not set
    header("Location: dashboard.php");
    exit();
}
?>
