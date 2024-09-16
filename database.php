<?php
// Fetch database configuration from environment variables
$server = getenv('DB_HOST');          // Fetches DB_HOST from environment variables
$dbname = getenv('DB_DATABASE');      // Fetches DB_DATABASE from environment variables
$dbuser = getenv('DB_USERNAME');      // Fetches DB_USERNAME from environment variables
$dbpass = getenv('DB_PASSWORD');      // Fetches DB_PASSWORD from environment variables
$dbport = getenv('DB_PORT') ?: '3306'; // Fetches DB_PORT from environment variables or defaults to 3306

// Create a new mysqli instance with the provided credentials
$link = new mysqli($server, $dbuser, $dbpass, $dbname, $dbport);

// Check the connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Your code here

?>
