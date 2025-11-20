<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "reservasi_bengkel_motor_mobil";


$connect = mysqli_connect($hostname, $username, $password, $database);
if (!$connect) {
    die("koneksi gagal: " . mysqli_connect_error());
}
