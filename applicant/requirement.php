<?php
require '../admin/Course.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/application_styles.css">
    <link rel="stylesheet" href="css/course_details_styles.css">
    </style>
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
                        <li class="links"><a href="#">About</a></li>
                    </div>
                    <div>
                        <li class="links"><a href="#">Contact Us</a></li>
                    </div>
                </ul>
            </nav>
        </div>
    </div>
    <style>
        .container {
            display: grid;
            grid-template-columns: 2fr 2fr 2fr;
        }
    </style>
    <div class="container">
        <div></div>
        <main>
            <h1>Course Details</h1>
            <div class="course">
                <?php
                $courses = new Course("courses_view", "course, level, exam_body, requirement, description"); // select from a view
                $course = $courses->selectColumnsById(); // select column
                ?>

                <?php
                if (!empty($course)) {
                    foreach ($course as $row) { ?>
                        <h2>Course Title</h2>
                        <p><?php echo (!empty($row['course']) ? $row['course'] : "Will be updated in due course ..."); ?></p>
                        <h3>Course Level</h3>
                        <p><?php echo (!empty($row['level']) ? $row['level'] : "Will be updated in due course ..."); ?></p>
                        <h3>Examination Body</h3>
                        <p><?php echo (!empty($row['exam_body']) ? $row['exam_body'] : "Will be updated in due course ..."); ?></p>
                        <h3>Requirements</h3>
                        <p><?php echo (!empty($row['requirement']) ? $row['requirement'] : "Will be updated in due course ..."); ?></p>
                        <h3>Description</h3>
                        <p><?php echo (!empty($row['description']) ? $row['description'] : "Will be updated in due course ..."); ?></p>
                <?php }
                } else {
                    echo "Course not available !";
                } ?>
            </div>
            <div>
        </main>
        <div></div>
    </div>

</body>

</html>