<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <!---CSS Links--->
        <link rel="stylesheet" href="css/register.css">
        <link rel="stylesheet" href="css/index.css">
        <!---boxicons Link--->
        <link rel="stylesheet"
        href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    
</head>
<body>
    <header>
        <img class="logoo" src="images/Logo2-removebg-preview.png" alt="">
        <ul class="navlist">
            <li><a id="homeLink" href="index.php">HOME</a></li>
            <li><a id="loginLink" href="login.php">SIGNIN</a></li>
            <li><a id="registerLink" href="register.php">REGISTER</a></li>
        </ul>
        <div class="bx bx-menu" id="menu-icon"></div>
      </header>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the current page filename (e.g., 'login.php')
    var currentPage = window.location.pathname.split("/").pop();

    // Add 'active' class to the corresponding link
    var activeLink = document.getElementById(currentPage.split('.')[0] + "Link");
    if (activeLink) {
        activeLink.classList.add("active");
    } else {
        // Special case for the home page where window.location.pathname returns '/'
        if (currentPage === "" || currentPage === "index.php") {
            document.getElementById("homeLink").classList.add("active");
        }
    }
});
</script>
</body>
</html>