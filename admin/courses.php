<?php
session_start();
include '../applicant/Form.php';
include './Admin.php';
include './Course.php';
include '../applicant/includes/helper_funcs.php';
if (!isset($_SESSION['id']) && $_SESSION['id'] !== 29334778) {
    $url = './login.php';
    header("Location:" . $url);
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="./css/styles.css">
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
                        <div class="links">
                            <li><a href="logs.php">Logs</a></li>
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
                <?php include './includes/side_navigation.html'; ?>
            </div>
            <main>
                <div>

                    <div>
                        <?php
                        if (isset($_POST['submit']) && $_POST['submit'] == "Register") {
                            $table = "courses";
                            $columns = "course, abbr, department_id, level_id, exam_body_id, duration_id, requirement, description";
                            $parameters = ":course, :abbr, :department_id, :level_id, :exam_body_id, :duration_id, :requirement, :description";
                            $course = new Course($table, $columns, $parameters);
                            if ($course->create()) {
                                $message = "created successifuly";
                                header("refresh:5;url=" . $_SERVER['PHP_SELF']);
                            } else {
                                $message = 'Logic Error contact admin';
                            }
                        }

                        if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
                            $table = "courses";
                            $updateString = "course = :course, abbr = :abbr, department_id = :department_id, level_id = :level_id, exam_body_id = :exam_body_id,  duration_id = :duration_id,  requirement = :requirement, description = :description";
                            $course = new Course($table, null, null, $updateString);
                            if ($course->update()) {
                                $message = " updated successifuly";
                                header("refresh:5;url=" . $_SERVER['PHP_SELF']);
                            } else {
                                $message = 'Logic Error contact admin';
                            }
                        }

                        if (isset($_GET['deleteId'])) {
                            $course = new Course("courses");
                            $course->delete();
                        }
                        ?>

                        <?php if (isset($_GET['updateId'])) {
                            $course = new Course("courses", "course");
                            $record = $course->selectAllById()[0];
                            ?>
                            <h1>Update Course</h1>
                            <form action="" method="post" id="form">
                                <input type="hidden" name="id" value="<?php echo $_GET['updateId']; ?>">
                                <div><label for="course">Course</label></div>
                                <div><input type="text" name="course" value="<?php echo $record['course']; ?>" id="course"
                                        required /></div>
                                <div><label for="abbr">Course Abbreviation</label></div>
                                <div><input type="text" name="abbr" id="abbr" value="<?php echo $record['abbr']; ?>"
                                        placeholder="provide an abbreviation of the course, e.g. CEE, DEE etc" required>
                                </div>
                                <div><label for="department">Department</label></div>
                                <div>
                                    <?php
                                    $course = new Course("departments", "department", ":department");
                                    $departments = $course->selectAll();
                                    ?>
                                    <select name="department_id" id="department">
                                        <option value="<?php echo $record['department_id']; ?>">
                                            <?php echo $course->selectColumn($record['department_id']); ?>
                                        </option>
                                        <?php foreach ($departments as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['department']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="level">Level</label></div>
                                <div>
                                    <?php
                                    $course = new Course("levels", "level", ":level");
                                    $levels = $course->selectAll();
                                    ?>
                                    <select name="level_id" id="level">
                                        <option value="<?php echo $record['level_id']; ?>">
                                            <?php echo $course->selectColumn($record['level_id']); ?>
                                        </option>
                                        <?php foreach ($levels as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['level']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="exam_body">Exam Body</label></div>
                                <div>
                                    <?php
                                    $course = new Course("exam_bodies", "exam_body", ":exam_body");
                                    $exam_bodies = $course->selectAll();
                                    ?>
                                    <select name="exam_body_id" id="exam_body">
                                        <option value="<?php echo $record['exam_body_id']; ?>">
                                            <?php echo $course->selectColumn($record['exam_body_id']);
                                            ?>
                                        </option>
                                        <?php foreach ($exam_bodies as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['exam_body']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="duration">Duration</label></div>
                                <div>
                                    <?php
                                    $course = new Course("durations", "duration", ":duration");
                                    $durations = $course->selectAll();
                                    ?>
                                    <select name="duration_id" id="duration">
                                        <option value="<?php echo $record['duration_id']; ?>">
                                            <?php echo $course->selectColumn($record['duration_id']);
                                            ?>
                                        </option>
                                        <?php foreach ($durations as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['duration']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="requirement">Requirements</label></div>
                                <div>
                                    <textarea name="requirement" id="requirement" cols="20" rows="5"
                                        placeholder="Provide course requirements"
                                        required><?php echo (!empty($record['requirement']) ? $record['requirement'] : "Provide course requirement"); ?></textarea>
                                </div>
                                <div><label for="description">Description</label></div>
                                <div>
                                    <textarea name="description" id="description" cols="20" rows="5"
                                        placeholder="Provide course description"
                                        required><?php echo (!empty($record['description']) ? $record['description'] : "Provide course description"); ?></textarea>
                                </div>
                                <div>
                                </div>
                                <div><input type="submit" name="submit" value="Update" id="submit"></div>
                            </form>
                            <p class="message"><?php echo (isset($message) ? $message : ""); ?></p>
                        <?php } else { ?>
                            <h1>Create Course</h1>
                            <form action="" method="post" id="form">
                                <div><label for="course">Course</label></div>
                                <div><input type="text" name="course" id="course" placeholder="Provide a course name"
                                        required /></div>
                                <div><label for="abbr">Course Abbreviation</label></div>
                                <div><input type="text" name="abbr" id="abbr"
                                        placeholder="provide an abbreviation of the course, e.g. CEE, DEE etc" required>
                                </div>
                                <div><label for="department">Department</label></div>
                                <div>
                                    <?php
                                    $course = new Course("departments", "department");
                                    $departments = $course->selectAll();
                                    ?>
                                    <select name="department_id" id="department">
                                        <option value="0">--Select a Department --</option>
                                        <?php foreach ($departments as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['department']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="level">Level</label></div>
                                <div>
                                    <?php
                                    $course = new Course("levels", "level");
                                    $levels = $course->selectAll();
                                    ?>
                                    <select name="level_id" id="level">
                                        <option value="0">--Select a level --</option>
                                        <?php foreach ($levels as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['level']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="exam_body">Exam Body</label></div>
                                <div>
                                    <?php
                                    $course = new Course("exam_bodies", "exam_body");
                                    $exam_bodies = $course->selectAll();
                                    ?>
                                    <select name="exam_body_id" id="exam_body">
                                        <option value="0">--Select a exam body --</option>
                                        <?php foreach ($exam_bodies as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['exam_body']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="duration">Duration</label></div>
                                <div>
                                    <?php
                                    $course = new Course("durations", "duration");
                                    $durations = $course->selectAll();
                                    ?>
                                    <select name="duration_id" id="duration">
                                        <option value="0">--Select Duration --</option>
                                        <?php foreach ($durations as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['duration']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div><label for="requirement">Requirements</label></div>
                                <div>
                                    <textarea name="requirement" id="requirement" cols="20" rows="5"
                                        placeholder="Provide course requirements" required></textarea>
                                </div>
                                <div><label for="description">Description</label></div>
                                <div>
                                    <textarea name="description" id="description" cols="20" rows="5"
                                        placeholder="Provide a brief description of the course"></textarea>
                                </div>
                                <div></div>
                                <div><input type="submit" name="submit" value="Register" id="submit"></div>
                            </form>
                            <p class="message"><?php echo (isset($message) ? $message : ""); ?></p>
                        <?php } ?>
                        <?php
                        $course = new Course("courses_view", ""); // select from a view
                        $courses = $course->selectAll();
                        ?>
                        <h2>Course Catalogue</h2>
                        <table>
                            <thead>
                                <th>Id</th>
                                <th>Course</th>
                                <th>Department</th>
                                <th>Level</th>
                                <th>Exam Body</th>
                                <th>Duration</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['course']; ?></td>
                                        <td><?php echo $row['department']; ?></td>
                                        <td><?php echo $row['level']; ?></td>
                                        <td><?php echo $row['exam_body']; ?></td>
                                        <td><?php echo $row['duration']; ?></td>
                                        <td><a
                                                href="<?php echo $_SERVER['PHP_SELF'] . "?updateId=" . $row['id'] ?>">Update</a>
                                        </td>
                                        <td><a
                                                href="<?php echo $_SERVER['PHP_SELF'] . "?deleteId=" . $row['id'] ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <div>
                <nav>
                    <ul>
                        <li><a href="adminLogs.php">Admin Logs</a></li>
                        <li><a href="applicantLogs.php">Applicant Logs</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </body>

</html>