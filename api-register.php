<?php
    include 'connect.php';
function sanitize_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $username = sanitize_input($_POST["username"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);
    $level = 1; // default level
    $user_image = ("user_image1");
    $created_at = $updated_at = date("Y-m-d H:i:s");

    // Check if the username is already taken
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = $link->query($check_query);

    if ($result->num_rows > 0) {
        echo "Username already taken. Please choose another one.";
    } else {
        // Insert user data into the database
        $insert_query = "INSERT INTO users (username, email, password, level, user_image, created_at, updated_at) 
                         VALUES ('$username', '$email', '$password', $level, '$user_image', '$created_at', '$updated_at')";
        
        if ($link->query($insert_query) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $insert_query . "<br>" . $connect->error;
        }
    }
}