<?php
// Include your database connection file here
include 'connect.php';

// SQL query to retrieve artikels data
$sql = "SELECT * FROM artikels";
$result = mysqli_query($link, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Create an array to hold the artikels data
    $artikelsData = array();

    // Fetch each row of data
    while ($row = mysqli_fetch_assoc($result)) {
        // Add the row to the array
        $artikelsData[] = $row;
    }

    // Add the file path for each image
    foreach ($artikelsData as &$artikel) {
        $artikel['gambar_artikel'] = 'https://forprojectk.000webhostapp.com/image/' . urlencode($artikel['gambar_artikel']);
    }

    // Send the JSON response
    // header('Content-Type: application/json');
    echo json_encode($artikelsData, JSON_PRETTY_PRINT);
} else {
    // If no results are found
    $response = array(
        'status' => 'error',
        'message' => 'No artikels data found'
    );

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

// Close the database connection
mysqli_close($link);
?>
