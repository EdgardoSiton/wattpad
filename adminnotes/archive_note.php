<?php
// Include the database configuration file
include_once 'database.php';

// Check if note_id is set
if(isset($_POST['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($link, $_POST['note_id']);

    // Perform the archiving operation
    $sql = "INSERT INTO archive (note_id) VALUES ('$note_id')";
    if(mysqli_query($link, $sql)) {
        echo "Note archived successfully.";
        header("Location: dashboard.php");
        exit();
       
    } else {
        echo "Error archiving note: " . mysqli_error($link);
    }
} else {
    echo "Note ID not received.";
}

// Close database connection
mysqli_close($link);
?>
