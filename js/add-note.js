

const addBox= document.querySelector(".add-box"),
modalBox= document.querySelector(".modal-box"),
closeIcon= modalBox.querySelector("header i"),
tittleTag= modalBox.querySelector("input"),
descTag= modalBox.querySelector("textarea"),
dateTag= modalBox.querySelector(".row-date input");
addBtn= modalBox.querySelector("buttton");

addBox.addEventListener("click", () => {
    modalBox.classList.add("show");
});

closeIcon.addEventListener("click", () => {
    modalBox.classList.remove("show");
});

addBtn.addEventListener("click", e => {
    e.preventDefault
    let noteTittle = tittleTag.value,
    noteDesc = descTag.value;
    noteDate = dateTag.value;
    console.log(noteTittle,noteDesc,noteDate)    
});
 // Get heart icons
 const heartIcons = document.querySelectorAll('.heart-icon');

 // Add click event listener to each heart icon
 heartIcons.forEach(icon => {
     icon.addEventListener('click', () => {
         // Toggle visibility of heart icons
         heartIcons.forEach(icon => icon.style.display = icon.style.display === 'none' ? 'inline-block' : 'none');
     });
 });
 document.addEventListener("DOMContentLoaded", function() {
    const addBox = document.querySelector(".add-box");
    const modalBox = document.querySelector(".modal-box");
    const closeIcon = modalBox.querySelector("header i");

    // Show modal box when add button is clicked
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
            const noteId = this.getAttribute("data-note-id");

            // AJAX request to fetch note details for editing
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Parse the response JSON containing note details
                        const noteDetails = JSON.parse(xhr.responseText);
                        console.log("Note details:", noteDetails);

                        // Populate the edit modal with note details
                        document.getElementById("edit-note-id").value = noteDetails.id;
                        document.getElementById("edit-title").value = noteDetails.title;
                        document.getElementById("edit-description").value = noteDetails.description;
                        document.getElementById("edit-date").value = noteDetails.date;
                        
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
            xhr.send("note_id=" + noteId);
        });
    });

    // Handle form submission for updating the note
    const editForm = document.querySelector(".edit-modal form");
    editForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        const formData = new FormData(this);

        // AJAX request to update the note
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the response JSON containing updated note details
                    const updatedNoteDetails = JSON.parse(xhr.responseText);
                    console.log("Updated note details:", updatedNoteDetails);

                    // Optionally, update the note details in the dashboard without refreshing the page
                    // For example, update the note card with the updated details

                    // Close the edit modal
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
});
  // Add an event listener to each note to open the view modal
  const notes = document.querySelectorAll(".note");
    notes.forEach(note => {
        note.addEventListener("click", function() {
            // Get the note details
            const title = this.querySelector(".details p").textContent;
            const description = this.querySelector(".details span").textContent;
            const date = this.querySelector(".bottom-content span").textContent;

            // Populate the view modal with the note details
            document.getElementById("view-title").value = title;
            document.getElementById("view-description").value = description;
            document.getElementById("view-date").value = date;

            // Show the view modal
            const viewModal = document.querySelector(".view-modal");
            viewModal.classList.add("show");
        });
    });

    // Close the view modal when the close icon is clicked
    const viewModal = document.querySelector(".view-modal");

    closeIcon.addEventListener("click", () => {
        viewModal.classList.remove("show");
    });

 // Add event listener to toggle the heart icon
 document.addEventListener("DOMContentLoaded", function() {
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
   