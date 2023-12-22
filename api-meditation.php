<?php
// Include your database connection file here
include 'connect.php';

// Function to get a random quote
function getRandomQuote() {
    $quotes = [
        "“Do not let the behavior of others destroy your inner peace.” —Dalai Lama",
        "“Nobody can bring you peace but yourself.” —Ralph Waldo Emerson",
        "“When things change inside you, things change around you.” —Unknown",
        "“Peace of mind for five minutes, that's what I crave.” —Alanis Morissette",
        "“Peace is liberty in tranquility.” —Marcus Tullius Cicero",
        "“Let go of the thoughts that don’t make you strong.” —Karen Salmansohn",
        "“Peace begins with a smile.” —Mother Teresa",
        "“An eye for an eye only ends up making the whole world blind.” —Mahatma Gandhi",
        "“Peace is not absence of conflict, it is the ability to handle conflict by peaceful means.” —Ronald Reagan",
        "“Not one of us can rest, be happy, be at home, be at peace with ourselves, until we end hatred and division.” —John Lewis",
        "“You cannot shake hands with a clenched fist.” ―Indira Gandhi",
        "“When you make peace with yourself, you make peace with the world.” —Maha Ghosananda"
    ];

    // Get a random index
    $randomIndex = array_rand($quotes);

    // Return the randomly selected quote
    return $quotes[$randomIndex];
}

// Check if the necessary parameters are set
if (isset($_POST['username'], $_POST['lama_meditasi'])) {

    // Assign values to variables
    $username = $_POST['username'];
    $lama_meditasi = $_POST['lama_meditasi'];
    
     // Convert the new time to seconds
   list($hours, $minutes, $seconds) = explode(':', $lama_meditasi);
   $newSeconds = $hours * 3600 + $minutes * 60 + $seconds;

    // Get id_user associated with the provided username
    $sqlGetUserId = "SELECT id_user FROM users WHERE username = '$username'";
    $resultGetUserId = $link->query($sqlGetUserId);

    if ($resultGetUserId->num_rows > 0) {
        $row = $resultGetUserId->fetch_assoc();
        $id_user = $row['id_user'];

        // Get the current value of jumlah_meditasi for the given user
        $sqlGetCount = "SELECT jumlah_meditasi FROM info_meditasi WHERE id_user = '$id_user'";
        $resultGetCount = $link->query($sqlGetCount);

        if ($resultGetCount->num_rows > 0) {
            $row = $resultGetCount->fetch_assoc();
            $jumlah_meditasi = $row['jumlah_meditasi'] + 1;
        } else {
            // If there is no existing entry for the user, set jumlah_meditasi to 1
            $jumlah_meditasi = 1;
        }

        // Get the current timestamp
        $timestamp = date('Y-m-d H:i:s');

        // Default values for id_music and id_artikel
        $id_music = 1; // You can change this default value based on your database
        $id_artikel = 1; // You can change this default value based on your database

        // SQL query to insert data into the 'meditasi' table
        $sqlCheckRow = "SELECT id_info, history_meditasi FROM info_meditasi WHERE id_user = '$id_user'";
        $resultCheckRow = $link->query($sqlCheckRow);

        if ($resultCheckRow->num_rows > 0) {
            // If the row exists, update it
            $row = $resultCheckRow->fetch_assoc();
            $id_info = $row['id_info'];
            $history_meditasi = $row['history_meditasi'];

            // If history_meditasi, get a random quote
                $history_meditasi = getRandomQuote();

            // Get the current value of lama_meditasi for the given user
            $sqlGetTime = "SELECT lama_meditasi FROM info_meditasi WHERE id_user = '$id_user'";
            $resultGetTime = $link->query($sqlGetTime);

            if ($resultGetTime->num_rows > 0) {
                $row = $resultGetTime->fetch_assoc();
                $currentTime = $row['lama_meditasi'];
                // Convert the current time to seconds
                list($hours, $minutes, $seconds) = explode(':', $currentTime);
                $currentSeconds = $hours * 3600 + $minutes * 60 + $seconds;
                // Convert the new time to seconds
                list($hours, $minutes, $seconds) = explode(':', $lama_meditasi);
                $newSeconds = $hours * 3600 + $minutes * 60 + $seconds;
                // Add the new seconds to the current seconds
                $totalSeconds = $currentSeconds + $newSeconds;
                // Convert the total seconds back to the format HH:MM:SS
                $lama_meditasi = sprintf('%02d:%02d:%02d', ($totalSeconds / 3600), ($totalSeconds / 60) % 60, $totalSeconds % 60);
            }

            // SQL query to update the row
            $sqlUpdate = "UPDATE info_meditasi SET jumlah_meditasi = '$jumlah_meditasi', lama_meditasi = '$lama_meditasi', history_meditasi = '$history_meditasi', updated_at = '$timestamp', id_music = '$id_music', id_artikel = '$id_artikel' WHERE id_info = '$id_info'";

            // Execute the query
            if ($link->query($sqlUpdate) === TRUE) {
                echo "Meditation data updated successfully";
            } else {
                echo "Error: " . $sqlUpdate . "<br>" . $link->error;
            }
        } else {
            // If the row does not exist, insert a new row
            $history_meditasi = getRandomQuote();

             $sqlInsert = "INSERT INTO info_meditasi (jumlah_meditasi, lama_meditasi, history_meditasi, created_at, updated_at, id_user, id_music, id_artikel)
                VALUES ('$jumlah_meditasi', '$lama_meditasi', '$history_meditasi', '$timestamp', '$timestamp', '$id_user', '$id_music', '$id_artikel')";

            // Execute the query
            if ($link->query($sqlInsert) === TRUE) {
                echo "Meditation data inserted successfully";
            } else {
                echo "Error: " . $sqlInsert . "<br>" . $link->error;
            }
        }
    } else {
        echo "User not found";
    }

    // Close the database connection
    $link->close();
} else {
    echo "Invalid parameters";
}
?>
