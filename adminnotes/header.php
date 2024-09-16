
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
    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>

<div class="header">
    <div class="search-bar-container">
        <div class="search-icon-container">
            <i class='bx bx-search-alt-2 search-icon' style='color:#774ea7; font-size: 20px; margin-top:4px'></i>
        </div>
        <input type="text" placeholder="Search" class="search-bar">
        <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector(".search-bar");
        const noteContainer = document.querySelector(".note-container");

        searchInput.addEventListener("input", function() {
            const searchValue = this.value.trim().toLowerCase();
            const notes = noteContainer.querySelectorAll(".note");

            notes.forEach(note => {
                const title = note.querySelector(".title").textContent.toLowerCase();
                const description = note.querySelector(".description").textContent.toLowerCase();
                const fullDescription = note.querySelector(".full-description").textContent.toLowerCase();

                if (title.includes(searchValue) || description.includes(searchValue) || fullDescription.includes(searchValue)) {
                    note.style.display = "block"; // Show the note if it matches the search query
                } else {
                    note.style.display = "none"; // Hide the note if it doesn't match the search query
                }
            });
        });
    });
</script>
    </div>
    <?php
    echo '<div class="user">';
    if (isset($_SESSION['username'])) {
        echo "<p> Hello, <span style='text-transform: capitalize; border-bottom: 2px solid #db2777;' class='underline-decoration-sky-500 underline-30'>" . $_SESSION['username'] ."</span> Welcome Back!". "</p>";
    }
    echo '</div>';
?>


        </div>
</body>
</html>