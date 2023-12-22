<?php
// Include your database connection file here
include 'connect.php';

// Check if the necessary parameters are set
if (isset($_POST['username'])) {

    // Assign values to variables
    $username = $_POST['username'];

    // Get id_user associated with the provided username
    $sqlGetUserId = "SELECT id_user FROM users WHERE username = '$username'";
    $resultGetUserId = $link->query($sqlGetUserId);

    if ($resultGetUserId->num_rows > 0) {
        $row = $resultGetUserId->fetch_assoc();
        $id_user = $row['id_user'];

        // Get the current value of jumlah_meditasi, lama_meditasi, and history_meditasi for the given user
        $sqlGetData = "SELECT jumlah_meditasi, lama_meditasi, history_meditasi FROM info_meditasi WHERE id_user = '$id_user'";
        $resultGetData = $link->query($sqlGetData);

        if ($resultGetData->num_rows > 0) {
            $row = $resultGetData->fetch_assoc();
            $jumlah_meditasi = $row['jumlah_meditasi'];

            // Convert HH:MM:SS to minutes
            $lama_meditasi = $row['lama_meditasi'];
            $timeArray = explode(":", $lama_meditasi);
            $lama_meditasi_minutes = $timeArray[0] * 60 + $timeArray[1];

            // Get history_meditasi
            $history_meditasi = $row['history_meditasi'];

            // Prepare response array
            $response = array(
                'status' => 'success',
                'jumlah_meditasi' => $jumlah_meditasi,
                'lama_meditasi' => $lama_meditasi_minutes,
                'history_meditasi' => $history_meditasi
            );

            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // If there is no existing entry for the user, set values to 0 or empty
            $jumlah_meditasi = 0;
            $lama_meditasi_minutes = 0;
            $history_meditasi = "No meditation history";

            // Prepare response array
            $response = array(
                'status' => 'success',
                'jumlah_meditasi' => $jumlah_meditasi,
                'lama_meditasi' => $lama_meditasi_minutes,
                'history_meditasi' => $history_meditasi
            );

            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    } else {
        // If user not found
        $response = array(
            'status' => 'error',
            'message' => 'User not found'
        );

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Close the database connection
    $link->close();
} else {
    // If invalid parameters
    $response = array(
        'status' => 'error',
        'message' => 'Invalid parameters'
    );

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
