<?php
include 'connect.php';

function sanitize_input($data)
{
   return htmlspecialchars(stripslashes(trim($data)));
}

function updateUserImage($link, $username, $userImage) {
 $sanitizedUsername = sanitize_input($username);
 $sanitizedUserImage = sanitize_input($userImage);
 $updateQuery = "UPDATE users SET user_image = '$sanitizedUserImage' WHERE username = '$sanitizedUsername'";
 $updateResult = $link->query($updateQuery);

 if ($updateResult) {
     return array(
         'status' => 'success',
         'message' => 'User image updated successfully.'
     );
 } else {
     return array(
         'status' => 'error',
         'message' => 'Failed to update user image.'
     );
 }
}

function getUserImage($link, $username) {
 $sanitizedUsername = sanitize_input($username);
 $query = "SELECT user_image FROM users WHERE username = '$sanitizedUsername'";
 $result = $link->query($query);

 if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     return array(
         'status' => 'success',
         'user_image' => $row['user_image']
     );
 } else {
     return array(
         'status' => 'error',
         'message' => 'User not found.'
     );
 }
}

if (isset($_REQUEST["username"])) {
 $username = sanitize_input($_REQUEST["username"]);

 if (isset($_POST["user_image"])) {
     $response = updateUserImage($link, $username, $_POST["user_image"]);
 } else {
     $response = getUserImage($link, $username);
 }

 echo json_encode($response);
} else {
 $response = array(
     'status' => 'error',
     'message' => 'Username parameter is not set.'
 );
 echo json_encode($response);
}
?>
