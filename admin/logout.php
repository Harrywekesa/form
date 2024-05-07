<?php
session_start();
unset($_SESSION['id']);
$url = './login.php';
header("Location:" . $url);
