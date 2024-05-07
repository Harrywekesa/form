<?php
    include "./Form.php";
    $form = new Form();
    $form->insert();
    $serverResponse = ["response" => $form->queryStatus];
    echo json_encode($serverResponse);
?>