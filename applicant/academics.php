<?php
ob_start();
session_start();
include './Applicant.php';
include './Application.php';
include './includes/helper_funcs.php';
if (!isset($_SESSION['id'])) {
    $url = './login.php';
    header("Location:" . $url);
}
// generate applicant information
$academicInformation = new Applicant();
$registrationInformation = new Applicant();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/styles.css">
    <!-- <script src="script.js" defer></script> -->
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
                        <li class="links"><a href="courses.php">Courses</a></li>
                    </div>
                    <div>
                        <li class="links"><a href="logout.php">Logout</a></li>
                    </div>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container">
        <div>
            <nav>
                <ul>
                    <li><a href="personal.php">Personal Information</a></li>
                    <li><a href="demographics.php">Demographic Information</a></li>
                    <li><a href="academics.php">Academic Information</a></li>
                    <li><a href="course.php<?php echo (isset($_GET['courseId']) ? '?courseId=' . $_GET['courseId'] : '') ?>">Select Course</a></li>
                    <li><a href="demographics.php">Parent/Guardian Information</a></li>
                    <li><a href="upload.php">Upload Documents</a></li>
                </ul>
            </nav>
        </div>
        <main>
            <h1>Application</h1>
            <h2>Academic Information</h2>
            <div>
                <?php
                $record = $registrationInformation->selectApplicantByPhoneNumber($_SESSION['id'])[0];
                $id = $record['id'];

                $academicInformation = new Application("academic_information", null, $applicantId = $id, null, null, null);
                if ($academicInformation->findInformationByApplicantId()) {
                    $row = $academicInformation->findInformationByApplicantId()[0];
                }
                ?>
                <h3>Primary School Academic Information</h3>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="primary_school_name">Primary School Name</label></div>
                    <div><input type="text" name="primary_school_name" value="<?php echo (isset($row['primary_school_name']) ? $row['primary_school_name'] : ''); ?>" required></div>
                    <div><label for="kcpe_index_number">KCPE index Number</label></div>
                    <div><input type="text" name="kcpe_index_number" value="<?php echo (isset($row['kcpe_index_number']) ? $row['kcpe_index_number'] : ''); ?>" id="index" required></div>
                    <div><label for="kcpe_marks">Grade/Marks</label></div>
                    <div><input type="text" name="kcpe_marks" value="<?php echo (isset($row['kcpe_marks']) ? $row['kcpe_marks'] : ''); ?>" id="grade"></div>
                    <div><label for="date_of_primary_education_completion">Date of Completion</label></div>
                    <div><input type="date" name="date_of_primary_education_completion" value="<?php echo (isset($row['date_of_primary_education_completion']) ? $row['date_of_primary_education_completion'] : ''); ?>" id="grade" placeholder="provide the date of primary education completion"></div>
                    <div><input type="submit" name="submit" value="save" id="submit"></div>
                </form>
                <h3>Secondary School Academic Information</h3>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="secondary_school_name">Secondary School Name</label></div>
                    <div><input type="text" name="secondary_school_name" value="<?php echo (isset($row['secondary_school_name']) ? $row['secondary_school_name'] : ''); ?>" id="primary" placeholder="provide the name of secondary School you attended" required></div>
                    <div><label for="kcse_index_number">KCSE index Number</label></div>
                    <div><input type="text" name="kcse_index_number" value="<?php echo (isset($row['kcse_index_number']) ? $row['kcse_index_number'] : ''); ?>" id="index" placeholder="provide your kcse index number" required></div>
                    <div><label for="grade">Grade</label></div>
                    <div><input type="text" name="kcse_grade" value="<?php echo (isset($row['kcse_grade']) ? $row['kcse_grade'] : ''); ?>" id="grade" placeholder="provide your kcse grade" required></div>
                    <div><label for="date_of_primary_education_completion">Date of Completion</label></div>
                    <div><input type="date" name="date_of_secondary_education_completion" value="<?php echo (isset($row['date_of_secondary_education_completion']) ? $row['date_of_secondary_education_completion'] : ''); ?>" id="grade" placeholder="provide the date of secondary education completion"></div>
                    <div><input type="submit" name="submit" value="save" id="submit"></div>
                </form>
                <h3>Tertiary Education Information(Optional)</h3>
                <p>If you have attended a tertiary institution fill the following form</p>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="tertiary_institute_name">Name of Institute/Polytechnic/College</label></div>
                    <div><input type="text" name="tertiary_institute_name" value="<?php echo (isset($row['tertiary_institute_name']) ? $row['tertiary_institute_name'] : ''); ?>" required></div>
                    <div><label for="tertiary_course_name">Course</label></div>
                    <div><input type="text" name="tertiary_course_name" value="<?php echo (isset($row['tertiary_course_name']) ? $row['tertiary_course_name'] : ''); ?>" id="tertiary_course_name"></div>
                    <div><label for="tertiary_classification">Grade/Classification</label></div>
                    <div><input type="text" name="tertiary_classification" value="<?php echo (isset($row['tertiary_classification']) ? $row['tertiary_classification'] : ''); ?>" id="tertiary_course_name" id="tertiary_classification"></div>
                    <div><label for="date_of_tertiary_education_completion">Date of Completion</label></div>
                    <div><input type="date" name="date_of_tertiary_education_completion" value="<?php echo (isset($row['date_of_tertiary_education_completion']) ? $row['date_of_tertiary_education_completion'] : ''); ?>" id="date_of_tertiary_education_completion"></div>
                    <div><input type="submit" name="submit" value="save" id="submit"></div>
                </form>
                <p id="message"></p>
                <?php
                if (isset($_POST["submit"]) && isset($_POST["primary_school_name"])) {
                    $columns = "applicant_id, primary_school_name, kcpe_index_number, kcpe_marks, date_of_primary_education_completion";
                    $parameters = ":applicant_id, :primary_school_name, :kcpe_index_number, :kcpe_marks, :date_of_primary_education_completion";
                    $updateString = "applicant_id = :applicant_id, primary_school_name = :primary_school_name, kcpe_index_number = :kcpe_index_number, kcpe_marks = :kcpe_marks, date_of_primary_education_completion = :date_of_primary_education_completion";
                    $application = new Application("academic_information", $_POST, $id, $columns, $parameters, $updateString);
                    if ($application->saveInformation()) {
                        echo "Saved Successifully";
                        refresh($_SERVER['PHP_SELF'], 3);
                    } else {
                        echo "Saving failure/no changes made";
                    }
                }

                if (isset($_POST["submit"]) && isset($_POST["secondary_school_name"])) {
                    $columns = "applicant_id, secondary_school_name, kcse_index_number, kcse_grade, date_of_secondary_education_completion";
                    $parameters = ":applicant_id, :secondary_school_name, :kcse_index_number, :kcse_grade, :date_of_secondary_education_completion";
                    $updateString = "secondary_school_name = :secondary_school_name, kcse_index_number = :kcse_index_number, kcse_grade = :kcse_grade, date_of_secondary_education_completion = :date_of_secondary_education_completion";
                    $application = new Application("academic_information", $_POST, $id, $columns, $parameters, $updateString);
                    if ($application->saveInformation()) {
                        echo "Saved Successifully";
                        refresh($_SERVER['PHP_SELF'], 3);
                    } else {
                        echo "Saving failure/no changes made";
                    }
                }

                if (isset($_POST["submit"]) && isset($_POST["tertiary_institute_name"])) {
                    $columns = "applicant_id, tertiary_institute_name, tertiary_course_name, tertiary_classification, date_of_tertiary_education_completion";
                    $parameters = ":applicant_id, :tertiary_institute_name, :tertiary_course_name, :tertiary_classification, :date_of_tertiary_education_completion";
                    $updateString = "tertiary_institute_name = :tertiary_institute_name, tertiary_course_name = :tertiary_course_name, tertiary_classification = :tertiary_classification, date_of_tertiary_education_completion = :date_of_tertiary_education_completion";
                    $application = new Application("academic_information", $_POST, $id, $columns, $parameters, $updateString);
                    if ($application->saveInformation()) {
                        echo "Saved Successifully";
                        refresh($_SERVER['PHP_SELF'], 3);
                    } else {
                        echo "Saving failure/no changes made";
                    }
                }


                ?>
            </div>
        </main>
        <div></div>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>