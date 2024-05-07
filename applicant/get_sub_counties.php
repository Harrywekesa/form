<?php
include "./Applicant.php";
$applicant = new Applicant();
echo json_encode($applicant->findById());
