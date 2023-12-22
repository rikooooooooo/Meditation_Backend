<?php
include 'connect.php';

function sanitize_input($data)
{
   return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["username"])) {
   $username = sanitize_input($_GET["username"]);
   $sql = "SELECT username, email, password FROM users WHERE username = '$username'";
   $result = $link->query($sql);

   if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();
       echo json_encode($row);
   } else {
       echo json_encode("User not found");
   }
}

if ($link->error) {
   echo "Error: " . $link->error;
}
?>
