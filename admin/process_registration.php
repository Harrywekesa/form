<?php
include "./Admin.php";
$form = new Admin();
$form->registerAdmin();
$serverResponse = ["response" => $form->queryStatus];
echo json_encode($serverResponse);
