<?php
ob_start();
session_start();
include './Applicant.php';
include './Application.php';
include '../admin/Course.php';
include './includes/helper_funcs.php';
if (!isset($_SESSION['id'])) {
    $url = './login.php';
    header("Location:" . $url);
}

if (isset($_GET["courseId"])) {
    $_SESSION['courseId'] = $_GET['courseId'];
}
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
            <?php include './includes/side_navigation.php'; ?>
        </div>
        <main>
            <h1>Application</h1>
            <h2>Select a Course</h2>
            <?php
            $record = $registrationInformation->selectApplicantByPhoneNumber($_SESSION['id'])[0];
            $id = $record['id'];

            $academicInformation = new Application("course_information", null, $applicantId = $id, null, null, null);
            if ($academicInformation->findInformationByApplicantId()) {
                $row = $academicInformation->findInformationByApplicantId()[0];
            }
            $courseId = $row['course_id'] ?? null;
            ?>
            <style>
                #form {
                    display: grid;
                    grid-template-columns: auto;
                }

                form #submit {
                    width: 10%;
                }
            </style>
            <form action="" method="post" id="form">
                <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                <div>
                    <label for="course">Course</label>
                </div>
                <div>
                    <select name="course_id" id="course">
                        <?php
                        if (isset($_GET["courseId"]) || isset($_SESSION["courseId"]) && !isset($row['course_id'])) {
                            $course = new Course("courses_view", "*");
                            $record = $course->selectColumnsById()[0];
                        ?>
                            <option value="<?php echo $record['id']; ?>"><?php echo $record['course'] . ', ' . $record['level'] . ', ' . $record['exam_body']; ?></option>
                            <?php
                            $course = new Course("courses_view", "*");
                            $courses = $course->selectAll();
                            foreach ($courses as $course) { ?>
                                <option value="<?php echo $course['id']; ?>"><?php echo $course['course'] . ', ' . $course['level'] . ', ' . $course['exam_body']; ?></option>
                            <?php } ?>
                        <?php } elseif (isset($row['course_id'])) {
                            $course = new Course("courses_view");
                            $course->fields = "*";
                            $courseRecord = $course->selectColumns($courseId)[0];
                        ?>
                            <option value="<?php echo $courseRecord['id']; ?>"><?php echo $courseRecord['course'] . ', ' . $courseRecord['level'] . ', ' . $courseRecord['exam_body']; ?></option>
                            <?php
                            $course = new Course("courses_view", "*");
                            $courses = $course->selectAll();
                            foreach ($courses as $course) { ?>
                                <option value="<?php echo $course['id']; ?>"><?php echo $course['course'] . ', ' . $course['level'] . ', ' . $course['exam_body']; ?></option>
                            <?php } ?>
                        <?php } else { ?>
                            <option value="">--select a course --</option>
                            <?php
                            $course = new Course("courses_view", "*");
                            $courses = $course->selectAll();
                            foreach ($courses as $course) { ?>
                                <option value="<?php echo $course['id']; ?>"><?php echo $course['course'] . ', ' . $course['level'] . ', ' . $course['exam_body']; ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
                <!-- <div></div> -->
                <div><input type="submit" name="submit" value="save" id="submit" /></div>
            </form>
            <?php
            if (isset($_POST["submit"])) {
                $columns = "applicant_id, course_id";
                $parameters = ":applicant_id, :course_id";
                $updateString = "applicant_id = :applicant_id, course_id = :course_id";
                $application = new Application("course_information", $_POST, $id, $columns, $parameters, $updateString);
                if ($application->saveInformation()) {
                    echo "Saved Successifully";
                    refresh($_SERVER['PHP_SELF'], 3);
                } else {
                    echo "Saving failure/no changes made";
                }
            }
            ?>
            <?php if (isset($courseRecord)) { ?>
                <h3>Selected Course</h3>
                <table style="margin: 0;">
                    <tr>
                        <td>Course</td>
                        <td><?php echo $courseRecord['course']; ?></td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td><?php echo $courseRecord['level']; ?></td>
                    </tr>
                    <tr>
                        <td>Exam Body</td>
                        <td><?php echo $courseRecord['exam_body']; ?></td>
                    </tr>
                    <tr>
                        <td>Course Duration</td>
                        <td><?php echo $courseRecord['duration']; ?></td>
                    </tr>
                    <tr>
                        <td>Course Requirement</td>
                        <td><?php echo $courseRecord['requirement']; ?></td>
                    </tr>
                    <tr>
                        <td>Course Description</td>
                        <td><?php echo $courseRecord['description']; ?></td>
                    </tr>
                </table>
            <?php } ?>
            <div>

            </div>
        </main>
        <div></div>
    </div>

</body>

</html>
<?php ob_end_flush(); ?>