    <?php
    session_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Archived Notes</title>
        <link rel="stylesheet" href="css/dashboard.css"> <!-- Assuming you have a CSS file for dashboard styles -->
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
                /* Change heart icon color */
            }
        </style>
    </head>
    <body>
        <!-- Add this HTML code after the edit modal -->
        
        <!-- Add this HTML code after the edit modal -->
        <div class="modal-box view-modal">
            <div class="modal">
                <div class="content">
                    <header>
                        <p>View Note Details</p>
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

    
        <div class="container">
            <?php include 'sidebar.php'; ?> 
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
                    </div>
                    <div class="note-wrapper">
                    <div class="note-card">
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
    $sql = "SELECT archive.note_id, note.title, note.description, note.update_at FROM archive 
    INNER JOIN note 
    ON archive.note_id = note.note_id
    WHERE user_id = ? ";

    // Prepare the SQL statement
    if ($stmt = $link->prepare($sql)) {
        // Bind the user_id parameter to the prepared statement
        $stmt->bind_param("i", $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Get the result set
            $result = $stmt->get_result();

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
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

// Settings (edit, archive, delete)
echo "<div class='settings'>";
echo "<div class='bottom-content'>";
// Convert the Unix timestamp to a human-readable date and time format
echo "<span>" . formatUpdateTime($row['update_at']) . "</span>";
echo "<i class='bx bx-dots-horizontal-rounded' style='color:#774ea7'></i>";
echo "<ul class='menu'>";
// Edit button
echo "<li><button class='edit' data-note-id='" . $row["note_id"] . "'><i class='bx bx-trash' style='color:#774ea7'></i>Delete</button></li>";
// Archive button
echo "<li>";
echo "<form action='unarchive.php' method='post'>";
echo "<input type='hidden' name='note_id' value='" . $row["note_id"] . "'>";
echo "<button type='submit' name='unarchive'><i class='bx bx-archive' style='color:#774ea7'></i>Unarchive</button>";
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
            <script>
            document.addEventListener("DOMContentLoaded", function() {
      
// Call the function when the page loads
window.onload = setActivePage;    const addBox = document.querySelector(".add-box");
                const modalBox = document.querySelector(".modal-box");
                const closeIcon = modalBox.querySelector("header i");

                function unarchiveNote(note_id) {
                // AJAX request to unarchive note
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "unarchivenote.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Reload page after unarchiving note
                        window.location.reload();
                    }
                };
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

                // Add event listener to toggle the heart icon
                const heartIcons = document.querySelectorAll(".note .bx-heart");
                heartIcons.forEach(icon => {
                    icon.addEventListener("click", function() {
                        // Toggle the heart icon color
                        if (icon.style.color === "red") {
                            icon.style.color = ""; // Remove red color
                        } else {
                            icon.style.color = "red"; // Make it red
                        }
                    });
                });
            });
            const deleteButtons = document.querySelectorAll(".note .bx-trash");
deleteButtons.forEach(button => {
    button.addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent parent click event from firing
        // Get the note ID associated with the clicked delete button
        const noteId = this.parentElement.getAttribute("data-note-id");

        // Display confirmation modal
        const confirmation = confirm("Are you sure you want to permanently delete this note?");
        if (confirmation) {
            // User confirmed, send AJAX request to delete note
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Note deleted successfully, reload the page
                        location.reload();
                    } else {
                        console.error("Failed to delete note. Status:", xhr.status);
                    }
                }
            };
            xhr.open("POST", "delete_note.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("note_id=" + noteId);
        }
    });
});
        </script>

    </body>
    </html>