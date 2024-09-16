<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      .main-title a {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        color: black;
        transition: background-color 0.3s ease;
    }

    /* Style for the buttons when hovered */
    .main-title a:hover {
        background-color: #2f055f;

    }

    /* Style for the buttons when active */
    .main-title .active a {
        background-color: #6E66B8ff;
        border-radius: 5px;
        color: white;
    }

    /* Additional styles for specific button classes */
    .all a, .fav a, .arc a {
        padding: 10px; /* Adjust padding as needed */
        cursor: pointer; /* Optionally add pointer cursor */
        font-size: 18px;    
        border-radius: 4px;
        font-weight: 500;
        color: #774ea7;
    }

    .all a:hover, .fav a:hover, .arc a:hover {
        color: rgb(255, 255, 255); /* Change color on hover */
        background: rgba(113, 99, 186, 255);
        transition: opacity 0.9s; /* Add transition for smooth opacity change */
    }
    </style>
</head>
<body>
    <div class="main-title">
        <div id="dashboardLink" class="all"><a href="dashboard.php">All Notes</a></div>
        <div id="favoriteLink" class="fav"><a href="favorite.php">Favorite Notes</a></div>
        <div id="archiveLink" class="arc"><a href="archive.php">Archive Notes</a></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the current page filename (e.g., 'login.php')
            var currentPage = window.location.pathname.split("/").pop();

            // Remove file extension (e.g., '.php')
            currentPage = currentPage.replace(/\.[^/.]+$/, "");

            // Add 'active' class to the corresponding link
            var activeLink = document.getElementById(currentPage + "Link");
            if (activeLink) {
                activeLink.classList.add("active");
            } else {
                // Special case for the home page where window.location.pathname returns '/'
                if (currentPage === "" || currentPage === "dashboard" || currentPage === "dashboard.php") {
                    document.getElementById("dashboardLink").classList.add("active");
                } else if (currentPage === "favorite" || currentPage === "favorite.php") {
                    document.getElementById("favoriteLink").classList.add("active");
                } else if (currentPage === "archive" || currentPage === "archive.php") {
                    document.getElementById("archiveLink").classList.add("active");
                }
            }
        });
    </script>
</body>
</html>
