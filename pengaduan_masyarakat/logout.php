<?php
//Memulai sesi
session_start();

//Menghapus semua session
session_destroy();

//Mengarahkan ke halaman login
header("location: login.php");