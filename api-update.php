<?php
include 'connect.php';

function sanitize_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $username = sanitize_input($_POST["username"]);
    $newUsername = sanitize_input($_POST["newUsername"]); // New username
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]); // Assuming you want to update the password as well
    $updated_at = date("Y-m-d H:i:s");

    // Check if the username exists in the database
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = $link->query($check_query);

    if ($result->num_rows > 0) {
        // Update user data in the database
        $update_query = "UPDATE users SET 
                         username = '$newUsername', 
                         email = '$email', 
                         password = '$password', 
                         updated_at = '$updated_at'
                         WHERE username = '$username'";
        
        if ($link->query($update_query) === TRUE) {
            echo "Update successful!";
        } else {
            echo "Error: " . $update_query . "<br>" . $link->error;
        }
    } else {
        echo "User not found. Cannot update.";
    }
}

?>
