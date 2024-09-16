<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard.css">

    <!---Google Fonts Link--->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!---boxicons Link--->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        .menu li button {
            border: none;
            /* Remove border */
            background: none;
            /* Remove background */
            cursor: pointer;
            font-size: 16px;
            color: black;
            /* Set color */
            padding: 0;
            /* Remove padding */
            margin: 0;
            /* Remove margin */
        }

        .menu li button:hover {
            color: #231138;
            /* Change color on hover */
        }

        .note {
            max-width: 100%;
            word-wrap: break-word;
        }

        .title-container {
            display: flex;
            align-items: center;
            /* Align items vertically */
            justify-content: space-between;
        }

        .title {
            margin-right: 10px;
            /* Adjust spacing between title and heart icon */
        }

        .heart-icon {
            color: black;
            cursor: pointer;
        }
        .heart-icon.red {
            color: red;
        }
    </style>
</head>

<body>

    <div class="modal-box">
        <div class="modal">
            <div class="content">
                <header>
                    <p style="color: #724f99;">Add a new Note</p>
                    <i class='bx bx-x' style='color:#774ea7'></i>
                </header>
                <form action="add_note.php" method="post" class="action">
                    <div class="row">
                        <label for="title">Title</label>
                        <input placeholder="Tittle:" type="text" id="title" name="title" class="title">
                    </div>
                    <div class="row-description">
                        <label for="description">Description</label>
                        <textarea placeholder="Description:" id="description" name="description" class="description"></textarea>
                    </div>
                    <div class="row-date" class="date" id="date" name="date">

                    </div>
                    <button type="submit" class="add-note">Add Note</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Add this HTML code after the edit modal -->
    <div class="modal-box view-modal">
        <div class="modal">
            <div class="content">
                <header>
                    <p style="color: #724f99;">View Note Details</p>
                    <i class='bx bx-x' style='color:#774ea7'></i>
                </header>
                <form>
                    <div class="row">
                        <label for="view-title">Title</label>
                        <input type="text" id="view-title" name="view_title" class="title" readonly>
                    </div>
                    <div class="row-description">
                        <label for="view-description">Description</label>
                        <textarea id="view-description" name="view_description" class="description" readonly></textarea>
                    </div>
                    <div class="row-date" id="view-date" class="date" readonly>


                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal box for editing notes -->
    <div class="modal-box edit-modal">
        <div class="modal">
            <div class="content">
                <header>
                    <p style="color: #724f99;">Edit Note</p>
                    <i class='bx bx-x' style='color:#774ea7'></i>
                </header>
                <form action="edit_note.php" method="post" class="action">
                    <input type="hidden" id="edit-note-id" name="edit_note_id">
                    <!-- Hidden input field to store note ID -->
                    <div class="row">
                        <label for="edit-title">Title</label>
                        <input type="text" id="edit-title" name="edit_title" class="title">
                    </div>
                    <div class="row-description">
                        <label for="edit-description">Description</label>
                        <textarea id="edit-description" name="edit_description" class="description"></textarea>
                    </div>
                    <div class="row-date" name="edit_date" class="date" id="edit-date">
                    </div>
                    <button type="submit" class="edit-note">Update Note</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <?php include 'sidebar.php' ?>
        <div class="main-content">
        <?php

            include 'header.php';
            include 'database.php'; // Include the database connection
            include 'time.php';

            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Check if $_SESSION['user_id'] is set
            ?>
                   
            <div class="note-container">
             <div class="note-header">
             <?php include 'main_title.php' ?>
                    <li class="add-box">
                        <div class="add-icon">
                            <i class='bx bx-plus colored' style='color:#774ea7'></i>
                            <i class='bx bx-plus white' style='color:white'></i>
                        </div>
                        <div class="add-text">
                            <p>Add new note</p>
                        </div>
                    </li>
                </div>  
                <div class="note-wrapper">
                    <div class="note-card ">
                    <?php
// Include your database connection file
include_once "database.php";

function getRandomDarkColor() {
    // Generate random RGB values
    $brown = mt_rand(0, 255);
    $black = mt_rand(0, 255);
    $blue = mt_rand(0, 255);

    // Reduce brightness (by subtracting a random value)
    $reduceValue = mt_rand(80, 100); // Adjust this range as needed for darkness level
    $brown = max(0, $brown - $reduceValue);
    $black = max(0, $black - $reduceValue);
    $blue = max(0, $blue - $reduceValue);

    // Convert RGB to hex
    $hexColor = sprintf("#%02x%02x%02x", $brown, $black, $blue);
    
    return $hexColor;
}

// Prepare SQL statement to select notes for the current user
$sql = "SELECT * FROM note WHERE user_id = $user_id AND note_id NOT IN (SELECT note_id FROM archive) ORDER BY update_at DESC";


// Prepare the SQL statement
if ($stmt = $link->prepare($sql)) {
    // Execute the query
    if ($stmt->execute()) {
        // Get the result set
        $result = $stmt->get_result();

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Check for spacing in title and description
                if (trim($row['title']) === '' || trim($row['description']) === '') {
                    // If title or description contains only spaces or is empty, skip displaying this note
                    continue;
                }

                // Output each note as a card
                $randomDarkColor = getRandomDarkColor();
                echo "<li class='note' 
                style='border-inline-start-color: $randomDarkColor;
                cursor: pointer;
                '>";
                // Note details
                echo "<div class='details'>";
                echo "<div class='title-container'>";
                echo "<p class='title'>" . $row["title"] . "</p>";
                echo "<div class='heart-icon' data-note-id='" . $row["note_id"] . "'>";
                echo "<i class='bx bxs-heart'></i>";
                echo "</div>";
                echo "</div>";

                // Apply CSS styling for the description text
                // If the description length exceeds 100 characters, truncate it with '...'
                $description = $row["description"];
                if (strlen($description) > 100) {
                    $description = substr($description, 0, 100) . '...';
                }
                echo "<span class='description'>" . $description . "</span>";
                // Hidden element containing the full description
                echo "<span class='full-description' style='display: none;'>" . $row["description"] . "</span>";
                echo "</div>";

                // Settings (edit, archive)
                echo "<div class='settings'>";
                echo "<div class='bottom-content'>";
                // Convert the Unix timestamp to a human-readable date and time format
                echo "<span>" . formatUpdateTime($row['update_at']) . "</span>";
                echo "<i class='bx bx-dots-horizontal-rounded' style='color:#774ea7'></i>";
                echo "<ul class='menu'>";
                // View button
                // Edit button
               
                echo "<li><button class='edit' data-note-id='" . $row["note_id"] . "'><i class='bx bx-pencil' style='color:#774ea7'></i>Edit</button></li>";
                // Archive button
                echo "<li>";
                echo "<form action='archive_note.php' method='post'>";
                echo "<input type='hidden' name='note_id' value='" . $row["note_id"] . "'>";
                echo "<button type='submit' name='archive'><i class='bx bx-archive' style='color:#774ea7'></i>Archive</button>";
                echo "</form>";
                echo "</li>";
                echo "</ul>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
        } else {
            echo "No notes found.";
        }
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

?>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function() {
     
            const addBox = document.querySelector(".add-box");
            const modalBox = document.querySelector(".modal-box");
            const closeIcon = modalBox.querySelector("header i");

            // Show modal box when add button is clicked
            function archiveNote(note_id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // Remove the note from the DOM if archiving is successful
                var noteToRemove = document.querySelector("[data-note-id='" + note_id + "']");
                if (noteToRemove) {
                    noteToRemove.remove();
                }
            } else {
                // Handle errors if archiving fails
                console.error("Failed to archive note. Status:", xhr.status);
            }
        }
    };
    xhr.open("POST", "archive_note.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("note_id=" + note_id);
}
            addBox.addEventListener("click", () => {
                modalBox.classList.add("show");
            });

            // Close modal box when close icon is clicked
            closeIcon.addEventListener("click", () => {
                modalBox.classList.remove("show");
            });

            const editButtons = document.querySelectorAll(".edit");
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Get the note ID associated with the clicked edit button
                    const note_id = this.getAttribute("data-note-id");

                    // AJAX request to fetch note details for editing
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                // Parse the response JSON containing note details
                                const noteDetails = JSON.parse(xhr.responseText);
                                console.log("Note details:", noteDetails);
                                

                                // Populate the edit modal with note details
                                document.getElementById("edit-note-id").value = noteDetails.note_id;
                                document.getElementById("edit-title").value = noteDetails.title;
                                document.getElementById("edit-description").value = noteDetails.description;
                                document.getElementById("edit-date").value = noteDetails.update_at;

                                // Show the edit modal
                                const editModal = document.querySelector(".edit-modal");
                                editModal.classList.add("show");


                            } else {
                                
                                console.error("Failed to fetch note details. Status:", xhr.status);
                            }
                        }
                    };
                    xhr.open("POST", "fetch_note_details.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send("note_id=" + note_id);
                });
            });

            // Handle form submission for updating the note
            const editForm = document.querySelector(".edit-modal form");
            editForm.addEventListener("submit", function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const updatedNoteDetails = JSON.parse(xhr.responseText);
                            console.log("Updated note details:", updatedNoteDetails);
                            const editModal = document.querySelector(".edit-modal");
                            editModal.classList.remove("show");

                            location.reload();
                        } else {
                            console.error("Failed to update note. Status:", xhr.status);
                        }
                    }
                };
                xhr.open("POST", "edit_note.php", true);
                xhr.send(formData);
            });
            const notes = document.querySelectorAll(".note");
            notes.forEach(note => {
                note.addEventListener("click", function() {
                    // Get the note details
                    const title = this.querySelector(".details p").textContent;

                    const fullDescription = this.querySelector(".full-description").textContent;
                    const date = this.querySelector(".bottom-content span").textContent;

                    // Populate the view modal with the note details 
                    document.getElementById("view-description").textContent = fullDescription;
                    document.getElementById("view-title").value = title;

                    const description = this.querySelector(".details span").textContent;
                    document.getElementById("view-date").textContent = date;

                    // Show the view modal
                    const viewModal = document.querySelector(".view-modal");
                    viewModal.classList.add("show");
                });
            });

            // Close the view modal when the close icon is clicked
            const viewModal = document.querySelector(".view-modal");
            const closeIconView = viewModal.querySelector("header i");
            closeIconView.addEventListener("click", () => {
                viewModal.classList.remove("show");
            });
            const heartIcons = document.querySelectorAll(".note .bxs-heart");

// Load saved favorite notes from local storage
const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];

heartIcons.forEach(icon => {
    const noteId = icon.parentElement.getAttribute("data-note-id");

    // Check if the current note is in the saved favorites
    if (savedFavorites.includes(noteId)) {
        icon.style.color = "red"; // Apply red color directly to the heart icon
    }

    icon.addEventListener("click", function(event) {
       event.stopPropagation();
        // Get the note ID associated with the clicked heart icon
        const noteId = this.parentElement.getAttribute("data-note-id");

        // Toggle the heart icon color using inline styles
        if (this.style.color === "red") {
            this.style.color = ""; // Remove red color
        } else {
            this.style.color = "red"; // Make it red
        }

        // Update local storage with the new list of favorite notes
        const updatedFavorites = this.style.color === "red" ?
            [...savedFavorites, noteId] : // Add note to favorites
            savedFavorites.filter(id => id !== noteId); // Remove note from favorites

        localStorage.setItem('favorites', JSON.stringify(updatedFavorites));

        // AJAX request to add/remove note from favorites
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Handle success response
                    console.log("Note added to favorites successfully.");
                } else {
                    // Handle error response
                    console.error("Failed to add/remove note to/from favorites. Status:", xhr.status);
                }
            }
        };
        xhr.open("POST", "favorite_note.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("note_id=" + noteId);
    });
});
        });
    </script>

</body>

</html>
