<?php

include 'connect.php';

if (!empty($_GET['username']) && !empty($_GET['password'])) {
   $username = $_GET['username'];
   $password = $_GET['password'];

   $cek = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
   $mysql = mysqli_query($link,$cek);
   $result = mysqli_num_rows($mysql);

   if ($result == 0) {
       echo "0";
   } else {
       echo "Selamat Datang";
   }
} else {
   echo "Ada Data Yang Kosong";
}
