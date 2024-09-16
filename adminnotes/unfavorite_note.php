<?php
// Include the database configuration file
include_once 'database.php';

// Check if note_id is set
if(isset($_POST['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($link, $_POST['note_id']);

    // Perform the removal operation from favorites
    $sql = "DELETE FROM favorite WHERE note_id = '$note_id'";
    if(mysqli_query($link, $sql)) {
        echo json_encode(array("status" => "removed"));
        exit();
    } else {
        echo json_encode(array("status" => "error"));
        exit();
    }
} else {
    echo json_encode(array("status" => "error"));
    exit();
}

// Close database connection
mysqli_close($link);
?>