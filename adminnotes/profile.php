<?php
session_start();
include 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
$sql = "SELECT * FROM user WHERE username = ?";
if ($stmt = $link->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param("s", $_SESSION['username']);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        // Check if a row is found
        if ($result->num_rows == 1) {
            // Fetch user data
            $userData = $result->fetch_assoc();

            // Close the prepared statement
            $stmt->close();
        } else {
            // Handle error: user not found
            echo "User not found.";
            exit();
        }
    } else {
        // Handle error: query execution failed
        echo "Error executing the query: " . $stmt->error;
        exit();
    }
} else {
    // Handle error: prepared statement failed
    echo "Error preparing statement: " . $link->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f4f4;
        }

        .header {
            margin-left: 3px;
            font-weight: bold;
            font-size: 30px;
            padding-top: 4px;
            padding-bottom: 40px;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 800px;
            margin-right: 30px;
            margin-left: 220px;
            background: rgb(255, 255, 255);
        }

        .profile-wrapper {
            padding-top: 60px;
        }

        .profile-card h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-container {
            margin-bottom: 20px;
        }

        .input-container label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }

        .input-container input:focus {
            border-color: #007bff;
        }

        .error-msg {
            color: red;
            font-size: 14px;
        }

        .btn-container {
            text-align: center;
        }

        .btn-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="modal-box">
        <div class="modal">
            <div class="content">
                <header>
                    <p style="color: #724f99;">Change your password</p>
                    <i class='bx bx-x' style='color:#774ea7'></i>
                </header>
                <form action="add_note.php" method="post" class="action">
                    <div class="row">
                        <label for="title">Password</label>
                        <input placeholder="Tittle:" type="text" id="title" name="title" class="title">
                    </div>
                    <div class="row-description">
                        <label for="description">Confirm Password</label>
                        <input placeholder="Description:" id="description" name="description" class="description"></input>
                    </div>
                    <div class="row-date" class="date" id="date" name="date">

                    </div>
                    <button type="submit" class="add-note">Confirm</button>
                </form>
            </div>
        </div>
    </div>

              
<div class="container">
    <?php include 'sidebar.php' ?>
    
    <div class="profile-container">
        <div class="profile-wrapper">
            <div class="profile-card">
                <div class="header">My Profile </div>
                
                <li class="add-box">
                        <div class="add-text">
                            <p>Do you want to change your password ?</p>
                        </div>
                    </li>
                <div class="input-container">
                    <label for="fullname">Full Name</label>
                    <p><?php echo $userData['fullname']; ?></p>
                </div>
                <div class="input-container">
                    <label for="email">Email</label>
                    <p><?php echo $userData['email']; ?></p>
                </div>
                <div class="input-container">
                    <label for="username">Username</label>
                    <p><?php echo $userData['username']; ?></p>
                </div>
                <!-- Note: Avoid displaying the password -->
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
});
</script>
</body>
</html>