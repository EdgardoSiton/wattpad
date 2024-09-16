<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
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
         
            <h3 class="main-title">Dashboard</h3>
                  
                </div>  
                <div class="note-wrapper">
                    <div class="note-card ">
            

                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>