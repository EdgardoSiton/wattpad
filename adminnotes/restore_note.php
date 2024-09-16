<?php
// Include your database connection file
include_once "database.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'restore' button is clicked
    if (isset($_POST["restore"])) {
        // Retrieve the note ID from the form
        $note_id = $_POST["note_id"];

        // Retrieve the note details from the archive table
        $sql_select = "SELECT * FROM archivenote WHERE id = ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bind_param("i", $note_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        // Check if the note exists in the archive table
        if ($result->num_rows > 0) {
            // Fetch the note details
            $row = $result->fetch_assoc();
            $title = $row["title"];
            $description = $row["description"];
            $date = $row["date"];

            // Insert the note back into the main notes table
            $sql_insert = "INSERT INTO note (title, description, date) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $title, $description, $date);
            $stmt_insert->execute();

            // Delete the note from the archive table
            $sql_delete = "DELETE FROM archivenote WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $note_id);
            $stmt_delete->execute();

            // Redirect back to the dashboard after restoration
            header("Location: dashboard.php");
            exit();
        } else {
            // Handle the case if the note doesn't exist in the archive table
            echo "Note not found in the archive.";
        }
    }
}

// Close the database connection
$conn->close();
?>
