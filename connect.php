<?php
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id21582268_root');
define('DB_PASSWORD', 'Riko2003;');
define('DB_NAME', 'id21582268_meditation');

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
} else {
//   // Connection successful, return a JSON message
  $response = array(
      "status" => "success",
      "message" => "Connected to the database."
  );
   
//   echo json_encode($response);
}
?>
