<?php
// Include the database configuration file
include_once 'database.php';

// Check if note_id is set
if(isset($_POST['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($link, $_POST['note_id']);
    
    // Check if the note is already in favorites
    $sql_check = "SELECT * FROM favorite WHERE note_id = '$note_id'";
    $result = mysqli_query($link, $sql_check);
    
    if (mysqli_num_rows($result) > 0) {
        // Note is already in favorites, so remove it
        $sql = "DELETE FROM favorite WHERE note_id = '$note_id'";
        if(mysqli_query($link, $sql)) {
            echo "removed";
            exit();
        } else {
            echo "Error removing note from favorites: " . mysqli_error($link);
            exit();
        }
    } else {
        // Note is not in favorites, so add it
        $sql = "INSERT INTO favorite (note_id) VALUES ('$note_id')";
        if(mysqli_query($link, $sql)) {
            echo "added";
            exit();
        } else {
            echo "Error adding note to favorites: " . mysqli_error($link);
            exit();
        }
    }
} else {
    echo "Note ID not received.";
    exit();
}

// Close database connection
mysqli_close($link);
?>
