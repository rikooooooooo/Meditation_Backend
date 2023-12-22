<?php
// Include your database connection file here
include 'connect.php';

// SQL query to retrieve music data
$sql = "SELECT * FROM music";
$result = $link->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Create an array to hold the music data
    $musicData = array();

    // Fetch each row of data
    while ($row = $result->fetch_assoc()) {
        // Add the row to the array
        $musicData[] = $row;
    }

    // Add the file path for each music
    foreach ($musicData as &$music) {
        $music['file_path'] = 'https://forprojectk.000webhostapp.com/music/' . urlencode($music['judul_musik']);
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($musicData);
} else {
    // If no results are found
    $response = array(
        'status' => 'error',
        'message' => 'No music data found'
    );

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
$link->close();
?>
