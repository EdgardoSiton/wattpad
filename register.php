<?php include 'header.php'; ?>
<?php 
$errors = array();

if (isset($_POST["submit"])) {
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["conpassword"];
    
    // Validation for full name
    if (empty($fullName)) {
        $errors['fullname'] = "Please enter your full name";
    }

    // Validation for email
    if (empty($email)) {
        $errors['email'] = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validation for username
    if (empty($username)) {
        $errors['username'] = "Please enter a username";
    } elseif (preg_match("/[^A-Za-z0-9\!]/", $username)) {
        $errors['username'] = "Invalid Characters!";
    }

    // Validation for password
    if (empty($password)) {
        $errors['password'] = "Please enter a password";
    } elseif (strlen($password) < 8 || strlen($password) > 16) {
        $errors['password'] = "Password should be between 8 and 16 characters";
    } elseif (!preg_match("/\d/", $password)) {
        $errors['password'] = "Password should contain at least one digit";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors['password'] = "Password should contain at least one capital letter";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $errors['password'] = "Password should contain at least one lowercase letter";
    } elseif (!preg_match("/\W/", $password)) {
        $errors['password'] = "Password should contain at least one special character";
    } elseif (preg_match("/\s/", $password)) {
        $errors['password'] = "Password should not contain any white space";
    }

    // Validation for password confirmation
    if (empty($passwordRepeat)) { 
        $errors['conpassword'] = "Please confirm your password";
    } elseif ($password != $passwordRepeat) {
        $errors['password'] = "Passwords do not match";
    }

    // Check if username already exists
    include 'database.php';
    $existingUserQuery = "SELECT * FROM user WHERE username = '$username'";
    $existingUserResult = mysqli_query($link, $existingUserQuery);
    if(mysqli_num_rows($existingUserResult) > 0) {
        $errors['username'] = "Username already exists";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        $fullName = mysqli_real_escape_string($link, $fullName);
        $email = mysqli_real_escape_string($link, $email);
        $username = mysqli_real_escape_string($link, $username);
        $password = mysqli_real_escape_string($link, $password);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = "INSERT INTO user (fullname, email, username, password) VALUES ('$fullName', '$email', '$username', '$hashedPassword')";
        if (mysqli_query($link, $insert)) {
            echo "<script>alert('Registration successful');</script>";
            header('Location: login.php');
            exit;
        } else {
            $errors['db'] = "Error: " . mysqli_error($link);
        }
    }
}
?>


<div class="register-container">
    <form action="" method="post">
        <h1>Register</h1>
    
        <div class="inputbox">
            <input type="text" name="fullname" placeholder="Full Name" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>">
            <i class='bx bxs-user'></i> 
            <?php if(isset($errors['fullname'])): ?>
                <span class="error-msg"><?php echo $errors['fullname']; ?></span>
            <?php endif; ?>
        </div>

        <div class="inputbox">
            <input type="text" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <i class='bx bxs-envelope'></i> 
            <?php if(isset($errors['email'])): ?>
                <span class="error-msg"><?php echo $errors['email']; ?></span>
            <?php elseif(isset($_POST['email']) && !strpos($_POST['email'], '@')): ?>
                <span class="error-msg">Please include '@' in the email address</span>
            <?php endif; ?>
        </div>

        <div class="inputbox">
            <input type="text" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            <i class='bx bxs-user'></i> 
            <?php if(isset($errors['username'])): ?>
                <span class="error-msg"><?php echo $errors['username']; ?></span>
            <?php endif; ?>
        </div>

        <div class="inputbox">
            <input type="password" name="password" placeholder="Password">
            <i class='bx bxs-lock-alt'></i> 
            <?php if(isset($errors['password'])): ?>
                <span class="error-msg"><?php echo $errors['password']; ?></span>
            <?php endif; ?>
        </div>

        <div class="inputbox">
            <input type="password" name="conpassword" placeholder="Confirm Password">
            <i class='bx bxs-lock-alt'></i>
            <?php if(isset($errors['conpassword'])): ?>
                <span class="error-msg"><?php echo $errors['conpassword']; ?></span>
            <?php endif; ?>
        </div>

        <input type="submit" class="btn" value="Register" name="submit">
    </form>
    <div class="register-link">
        <a href="login.php">Back to Login</a>
    </div>
</div>
