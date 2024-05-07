<?php
// include '../applicant/Form.php';
include './Admin.php';
include '../applicant/Applicant.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../applicant/styles.css">
    <title>Form</title>
</head>

<body>
    <div class="header-container">
        <div></div>
        <div></div>
        <div>
            <nav>
                <ul class="nav-container">
                    <div class="links">
                        <li><a href="index.php">Home</a></li>
                    </div>
                    <div>
                        <li class="links"><a href="logout.php">Logout</a></li>
                    </div>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container">
        <div></div>
        <main>
            <div>
                <h1>Logs</h1>
                <ol>
                    <?php
                    $applicant = new Applicant();
                    $logs = $applicant->showLogs(); ?>
                    <?php
                    for ($i = 0; $i < count($logs); $i++) { ?>
                        <li>
                            <?php foreach ($logs[$i] as $key => $value) {
                                echo $key . " : " . $value . " ";
                            } ?>
                        </li>
                    <?php } ?>
                </ol>
            </div>
        </main>
        <div></div>
    </div>

</body>

</html>