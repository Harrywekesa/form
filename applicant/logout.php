<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['courseId']);
$url = './login.php';
header("Location:" . $url);
