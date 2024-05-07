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
                <h2>Personal information</h2>
                <div>
                    <?php
                    $record = $registrationInformation->selectApplicantByPhoneNumber($_SESSION['id'])[0];
                    $id = $record['id'];

                    $personalInformation = new Application("personal_information", null, $applicantId = $id, null, null, null);
                    if ($personalInformation->findInformationByApplicantId()) {
                        $row = $personalInformation->findInformationByApplicantId()[0];
                    } else {
                        $row = $record;
                    }
                    ?>

                    <form action="" method="post" id="form">
                        <input type="hidden" name="applicant_id" value="<?php echo (isset($id) ? $id : ""); ?>">
                        <div>
                            <label for="firstName">Firstname<span id="firstname"></span></label>
                            <input type="text" name="firstname" id="firstName"
                                value="<?php echo (isset($row['firstname']) ? $row['firstname'] : ''); ?>" required />
                        </div>
                        <div>
                            <label for="lastName">Lastname <span id="lastname"></span></label>
                            <input type="text" name="lastname" id="lastName"
                                value="<?php echo (isset($row['lastname']) ? $row['lastname'] : ''); ?>" required />
                        </div>
                        <div>
                            <label for="secondName">Second name <span id="second_name"></span></label>
                            <input type="text" name="second_name" id="secondName"
                                value="<?php echo (isset($row['second_name']) ? $row['second_name'] : ''); ?>" />
                        </div>
                        <div>
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender">
                                <option
                                    value="<?php echo (isset($row['gender']) ? $row['gender'] : '--select your gender--'); ?>">
                                    <?php echo (isset($row['gender']) ? $row['gender'] : '--select your gender--'); ?>
                                </option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <div>
                            <label for="birthday">Date of Birth</label>
                            <input type="date" name="birthday" id="birthday"
                                value="<?php echo (isset($row['birthday']) ? $row['birthday'] : ''); ?>" required>
                        </div>
                        <div>
                            <label for="emailAddress">Email<span id="email_address"></span></label>
                            <input type="email" name="email_address" id="emailAddress"
                                value="<?php echo (isset($row['email_address']) ? $row['email_address'] : ''); ?>"
                                required />
                        </div>
                        <div>
                            <label for="phoneNumber">Phone<span id="phone_number"></span></label>
                            <input type="tel" name="phone_number" id="phoneNumber"
                                value="<?php echo (isset($row['phone_number']) ? $row['phone_number'] : ''); ?>"
                                required />
                        </div>
                        <div>
                            <label for="alternativePhoneNumber">Alternative Phone<span
                                    id="alternative_phone"></span></label>
                            <input type="tel" name="alternative_phone" id="alternativePhoneNumber"
                                value="<?php echo (isset($row['alternative_phone']) ? $row['alternative_phone'] : ''); ?>" />
                        </div>
                        <div><input type="submit" name="submit" id="submit" value="save" /></div>
                    </form>
                    <p id="message">
                        <?php
                        if (isset($_POST["submit"])) {
                            // var_dump($_POST);
                            $columns = "applicant_id, firstname, lastname, second_name, gender, birthday, email_address, phone_number, alternative_phone";
                            $parameters = ":applicant_id, :firstname, :lastname, :second_name, :gender, :birthday, :email_address, :phone_number, :alternative_phone";
                            $updateString = "firstname = :firstname, lastname = :lastname, second_name = :second_name, gender = :gender, birthday = :birthday, email_address = :email_address, phone_number = :phone_number, alternative_phone = :alternative_phone";
                            $application = new Application("personal_information", $_POST, $id, $columns, $parameters, $updateString);
                            if ($application->saveInformation()) {
                                echo "Saved Successifully";
                                refresh($_SERVER['PHP_SELF'], 3);
                            } else {
                                echo "Saving failure";
                            }
                        }
                        ?>
                    </p>
                </div>
            </main>
            <div></div>
        </div>

    </body>

</html>
<?php ob_end_flush(); ?>