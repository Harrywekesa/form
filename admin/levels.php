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
                            $course = new Course("levels", "level", ":level");
                            if ($course->create()) {
                                $message = " created successifuly";
                                header("refresh:5;url=" . $_SERVER['PHP_SELF']);
                            }

                        }

                        if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
                            $course = new Course("levels", "level", null);
                            if ($course->update()) {
                                $message = " updated successifuly";
                                header("refresh:5;url=" . $_SERVER['PHP_SELF']);
                            }
                        }

                        if (isset($_GET['deleteId'])) {
                            $course = new Course("levels", "level");
                            $course->delete();
                        }
                        ?>

                        <?php if (isset($_GET['updateId'])) {
                            $course = new Course("levels", "level"); ?>
                            <h1>Update Course Levels</h1>
                            <form action="" method="post" id="form">
                                <input type="hidden" name="id" value="<?php echo $_GET['updateId']; ?>">
                                <div><label for="level">Course Level</label></div>
                                <div><input type="text" name="level" value="<?php echo $course->selectById(); ?>"
                                        id="department" required />
                                </div>
                                <div><input type="submit" name="submit" value="Update" id="submit"></div>
                            </form>
                            <p class="message"><?php echo (isset($message) ? $message : ""); ?></p>
                        <?php } else { ?>
                            <h1>Create Course Level</h1>
                            <form action="" method="post" id="form">
                                <div><label for="level">Course Level</label></div>
                                <div><input type="text" name="level" id="level" required />
                                </div>
                                <div><input type="submit" name="submit" value="Register" id="submit"></div>
                            </form>
                            <p class="message"><?php echo (isset($message) ? $message : ""); ?></p>
                        <?php } ?>
                        <?php
                        $course = new Course("levels", "level");
                        $departments = $course->selectAll();
                        ?>
                        <h2>Departments</h2>
                        <table>
                            <thead>
                                <th>Id</th>
                                <th>Level</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php foreach ($departments as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['level']; ?></td>
                                        <td><a
                                                href="<?php echo $_SERVER["PHP_SELF"] . "?updateId=" . $row['id'] ?>">Update</a>
                                        </td>
                                        <td><a
                                                href="<?php echo $_SERVER["PHP_SELF"] . "?deleteId=" . $row['id'] ?>">Delete</a>
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