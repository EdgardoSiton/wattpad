<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <!---Google Fonts Link--->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!---boxicons Link--->
    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        .container .sidebar ul li:hover{
            border-radius: 5px;
            border-left: 5px solid white;
            background-color: rgb(108, 100, 185);
        }

        .container .sidebar ul li.active {
            background-color: #6E66B8ff;
            border-left: 5px solid white;
            border-radius: 5px;
            color: white;
        }

        .container .sidebar ul li:hover a{
            color:  #ffffff;
        }

        .sidebar .active ul li {
            background-color: #6E66B8ff;
            border-radius: 5px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img class="logoo" src="images/Logo2-removebg-preview.png" alt="">
        <ul>
            <li><a id="noteLink" href="dashboard.php"><i class='bx bx-note' style='color:#ffffff'></i>Notes</a></li>
            <li><a id="profileLink" href="profile.php"><i class='bx bx-user' style='color:#ffffff'></i>Profile</a></li>
            <li><a href="../index.php"><i class='bx bx-log-out-circle' style='color:#ffffff'></i>Log out</a></li>
        </ul>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Remove 'active' class from all <li> elements
            var allLiElements = document.querySelectorAll(".container .sidebar ul li");
            allLiElements.forEach(function(li) {
                li.classList.remove("active");
            });

            // Get the current page filename (e.g., 'login.php')
            var currentPage = window.location.pathname.split("/").pop();

            // Remove file extension (e.g., '.php')
            currentPage = currentPage.replace(/\.[^/.]+$/, "");

            // Add 'active' class to the corresponding link's parent <li> element
            var activeLink = document.getElementById(currentPage + "Link");
            if (activeLink) {
                activeLink.parentNode.classList.add("active");
            }
        });
    </script>
</body>
</html>
