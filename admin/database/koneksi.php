<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'toko';

$koneksi = mysqli_connect($hostname, $username, $password, $dbname);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
