<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
        font-family: Arial, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    form {
        margin-top: 20px;
    }

    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 8px;
        margin: 5px 0 20px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
    table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 20px;
    }
    
    th, td {
       padding: 15px;
       text-align: left;
       border-bottom: 1px solid #ddd;
    }
    
    th {
       background-color: #4CAF50;
       color: white;
    }
    
    tr:hover {
       background-color: #f5f5f5;
    }
    
    @media screen and (max-width: 600px) {
   table, thead, tbody, th, td, tr {
       display: block;
   }

   thead tr {
       position: absolute;
       top: -9999px;
       left: -9999px;
   }

   tr {
       margin: 0 0 1rem 0;
   }

   tr:nth-child(odd) {
       background: #ccc;
   }

   td {
       border: none;
       border-bottom: 1px solid #eee;
       position: relative;
       padding-left: 50%;
   }

   td:before {
       position: absolute;
       top: 6px;
       left: 6px;
       width: 45%;
       padding-right: 10px;
       white-space: nowrap;
   }

   td:nth-of-type(1):before { content: "Username"; }
   td:nth-of-type(2):before { content: "Email"; }
   /* Add more as needed */
    }


    </style>
    <title>ADMIN PAGE</title>
    <script>
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById('delete_user').value = userId;
                document.getElementById('form').submit();
            }
        }

        function deleteData(dataId, tableName) {
            if (confirm("Are you sure you want to delete this data?")) {
                document.getElementById('delete_' + tableName).value = dataId;
                document.getElementById('form').submit();
            }
        }
    </script>
</head>
<body>

<form id="form" method="post">
    <!-- Hidden input fields to store the IDs for deletion -->
    <input type="hidden" name="delete_user" id="delete_user" value="">
    <input type="hidden" name="delete_artikel" id="delete_artikel" value="">
    <input type="hidden" name="delete_music" id="delete_music" value="">
</form>

<?php
function sanitize_input($data)
{
   return htmlspecialchars(stripslashes(trim($data)));
}

function login($username, $password) {
   global $link;
   $username = sanitize_input($username);
   $password = sanitize_input($password);
   $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND level = 2";
   $result = $link->query($query);

   if ($result->num_rows > 0) {
       return true;
       
   }
   return false;
}

function displayData() {
   global $link;
   echo "Tabel Users";
   echo '<table>';
     echo '<tr><th>Id User</th><th>Username</th><th>Email</th><th>Password</th><th>User Image</th><th>Level</th><th>Created At</th><th>Updated At</th><th>Delete</th></tr>';
     $query = "SELECT * FROM users";
     $result = $link->query($query);
     while ($row = $result->fetch_assoc()) {
         echo '<tr>';
         echo '<td>' . $row['id_user'] . '</td>';
         echo '<td>' . $row['username'] . '</td>';
         echo '<td>' . $row['email'] . '</td>';
         echo '<td>' . $row['password'] . '</td>';
         echo '<td>' . $row['user_image'] . '</td>';
         echo '<td>' . $row['level'] . '</td>';
         echo '<td>' . $row['created_at'] . '</td>';
         echo '<td>' . $row['updated_at'] . '</td>';
         echo '<td><button onclick="deleteUser(' . $row['id_user'] . ', \'users\')">Delete</button></td>';
         echo '</tr>';
     }
     echo '</table>';
    
    echo "Tabel Meditasi";
   echo '<table>';
     echo '<tr><th>id_info</th><th>jumlah_meditasi</th><th>lama_meditasi</th><th>hsitory_meditasi</th><th>created_at</th><th>updated_at</th><th>id_user</th><th>id_music</th><th>id_artikel</th></tr>';
     $query = "SELECT * FROM info_meditasi";
     $result = $link->query($query);
     while ($row = $result->fetch_assoc()) {
         echo '<tr>';
         echo '<td>' . $row['id_info'] . '</td>';
         echo '<td>' . $row['jumlah_meditasi'] . '</td>';
         echo '<td>' . $row['lama_meditasi'] . '</td>';
         echo '<td>' . $row['history_meditasi'] . '</td>';
         echo '<td>' . $row['created_at'] . '</td>';
         echo '<td>' . $row['updated_at'] . '</td>';
         echo '<td>' . $row['id_user'] . '</td>';
         echo '<td>' . $row['id_music'] . '</td>';
         echo '<td>' . $row['id_artikel'] . '</td>';
         echo '</tr>';
     }
     echo '</table>';
     
      echo "Tabel Artikels";
    echo '<table>';
    echo '<tr><th>ID Artikel</th><th>Judul Artikel</th><th>Konten Artikel</th><th>Sumber Artikel</th><th>Gambar Artikel</th><th>Created At</th><th>Updated At</th></tr>';
     $query = "SELECT * FROM artikels";
     $result = $link->query($query);
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id_artikel'] . '</td>';
        echo '<td>' . $row['judul_artikel'] . '</td>';
        echo '<td>' . $row['konten_artikel'] . '</td>';
        echo '<td>' . $row['sumber_artikel'] . '</td>';
        echo '<td>' . $row['gambar_artikel'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '<td>' . $row['updated_at'] . '</td>';
        
        echo '</tr>';
    }
    echo '</table>';
     
    

    echo "Tabel Music";
    echo '<table>';
    echo '<tr><th>ID Music</th><th>Judul Musik</th><th>Penyanyi</th><th>Created At</th><th>Updated At</th</tr>';
    $query = "SELECT * FROM music";
     $result = $link->query($query);
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id_music'] . '</td>';
        echo '<td>' . $row['judul_musik'] . '</td>';
        echo '<td>' . $row['penyanyi'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '<td>' . $row['updated_at'] . '</td>';
       
        echo '</tr>';
    }
    echo '</table>';
  
}
function deleteData($id, $table) {
    global $link;
    $id = sanitize_input($id);
    $table = sanitize_input($table);
    // Add validation or security checks as needed

    $query = "DELETE FROM $table WHERE id_user = '$id'";
    $result = $link->query($query);

    if ($result) {
        echo ucfirst($table) . " data deleted successfully.";
    } else {
        echo "Error deleting $table data: " . $link->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $username = $_POST["username"];
   $password = $_POST["password"];
   if (login($username, $password)) {
       echo "Login successful!";
       displayData();
   } else {
       echo "Invalid username or password.";
   }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $userIdToDelete = $_POST['delete_user'];
    deleteData($userIdToDelete, 'users');
}


echo '<form method="post">
       Username: <input type="text" name="username"><br>
       Password: <input type="password" name="password"><br>
       <input type="submit" value="Login">
     </form>';
?>
</body>
</html>