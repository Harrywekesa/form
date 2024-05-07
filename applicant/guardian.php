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
$parentInformation = new Applicant();
$registrationInformation = new Applicant();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=father" />
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
            <h2>Parent/Guardian/Sponsor Information</h2>
            <p>Provide details of your parent, a guardian or a sponsor who is supporting your education</p>
            <div>
                <?php
                $record = $registrationInformation->selectApplicantByPhoneNumber($_SESSION['id'])[0];
                $id = $record['id'];

                $parentInformation = new Application("parent_information", null, $applicantId = $id, null, null, null);
                if ($parentInformation->findInformationByApplicantId()) {
                    $row = $parentInformation->findInformationByApplicantId()[0];
                }
                ?>
                <h3>Father's Details</h3>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="father">Full name</label></div>
                    <div><input type="text" name="father" value="<?php echo ($row['father'] ?? ''); ?>"></div>
                    <div><label for="father_occupation">Occupation</label></div>
                    <div><input type="text" name="father_occupation" value="<?php echo ($row['father_occupation'] ?? ''); ?>"></div>
                    <div><label for="father_phone_number">Telephone Number</label></div>
                    <div><input type="tel" name="father_phone_number" value="<?php echo ($row['father_phone_number'] ?? ''); ?>"></div>
                    <div><label for="father_email_address">Email Address (optional)</label></div>
                    <div><input type="email" name="father_email_address" value="<?php echo ($row['father_email_address'] ?? ''); ?>" id="email_adress"></div>
                    <div><label for="father_postal_address">P.O. Box</label></div>
                    <div><input type="text" name="father_postal_address" value="<?php echo ($row['father_postal_address'] ?? ''); ?>"></div>
                    <div>
                        <input type="submit" name="submit" value="save" id="submit">
                    </div>
                </form>

                <h3>Mother's Details</h3>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="mother">Full name</label></div>
                    <div><input type="text" name="mother" value="<?php echo ($row['mother'] ?? ''); ?>"></div>
                    <div><label for="mother_occupation">Occupation</label></div>
                    <div><input type="text" name="mother_occupation" value="<?php echo ($row['mother_occupation'] ?? ''); ?>"></div>
                    <div><label for="mother_phone_number">Telephone Number</label></div>
                    <div><input type="tel" name="mother_phone_number" value="<?php echo ($row['mother_phone_number'] ?? ''); ?>"></div>
                    <div><label for="mother_email_address">Email Address (optional)</label></div>
                    <div><input type="email" name="mother_email_address" value="<?php echo ($row['mother_email_address'] ?? ''); ?>" id="email_adress"></div>
                    <div><label for="mother_postal_address">P.O. Box</label></div>
                    <div><input type="text" name="mother_postal_address" value="<?php echo ($row['mother_postal_address'] ?? ''); ?>"></div>
                    <div>
                        <input type="submit" name="submit" value="save" id="submit">
                    </div>
                </form>

                <h3>Guardian's Details</h3>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="guardian">Full name</label></div>
                    <div><input type="text" name="guardian" value="<?php echo ($row['guardian'] ?? ''); ?>"></div>
                    <div><label for="guardian_occupation">Occupation</label></div>
                    <div><input type="text" name="guardian_occupation" value="<?php echo ($row['guardian_occupation'] ?? ''); ?>"></div>
                    <div><label for="guardian_phone_number">Telephone Number</label></div>
                    <div><input type="tel" name="guardian_phone_number" value="<?php echo ($row['guardian_phone_number'] ?? ''); ?>"></div>
                    <div><label for="guardian_email_address">Email Address (optional)</label></div>
                    <div><input type="email" name="guardian_email_address" value="<?php echo ($row['guardian_email_address'] ?? ''); ?>" id="email_adress"></div>
                    <div><label for="guardian_postal_address">P.O. Box</label></div>
                    <div><input type="text" name="guardian_postal_address" value="<?php echo ($row['guardian_postal_address'] ?? ''); ?>"></div>
                    <div>
                        <input type="submit" name="submit" value="save" id="submit">
                    </div>
                </form>

                <h3>Sponsor's Details</h3>
                <form action="" method="post" id="form">
                    <input type="hidden" name="applicant_id" value="<?php echo $id; ?>">
                    <div><label for="sponsor">Full name</label></div>
                    <div><input type="text" name="sponsor" value="<?php echo ($row['sponsor'] ?? ''); ?>"></div>
                    <div><label for="sponsor_occupation">Occupation</label></div>
                    <div><input type="text" name="sponsor_occupation" value="<?php echo ($row['sponsor_occupation'] ?? ''); ?>"></div>
                    <div><label for="sponsor_phone_number">Telephone Number</label></div>
                    <div><input type="tel" name="sponsor_phone_number" value="<?php echo ($row['sponsor_phone_number'] ?? ''); ?>"></div>
                    <div><label for="sponsor_email_address">Email Address (optional)</label></div>
                    <div><input type="email" name="sponsor_email_address" value="<?php echo ($row['sponsor_email_address'] ?? ''); ?>" id="email_adress"></div>
                    <div><label for="sponsor_postal_address">P.O. Box</label></div>
                    <div><input type="text" name="sponsor_postal_address" value="<?php echo ($row['sponsor_postal_address'] ?? ''); ?>"></div>
                    <div>
                        <input type="submit" name="submit" value="save" id="submit">
                    </div>
                </form>


                <p id="message" style="color: green;">
                    <?php
                    function saveInformation($table, $id, $columns, $parameters, $updateString): void
                    {
                        $application = new Application($table, $_POST, $id, $columns, $parameters, $updateString);
                        if ($application->saveInformation()) {
                            echo "Saved Successifully";
                            refresh($_SERVER['PHP_SELF'], 3);
                        } else {
                            echo "Saving failure/no changes made";
                        }
                    }

                    if (isset($_POST["submit"])) {
                        if (isset($_POST["father"])) {
                            $table = "parent_information";
                            $columns = "applicant_id, father, father_occupation, father_phone_number, father_email_address, father_postal_address";
                            $parameters = ":applicant_id, :father, :father_occupation, :father_phone_number, :father_email_address, :father_postal_address";
                            $updateString = "applicant_id = :applicant_id, father = :father, father_occupation = :father_occupation, father_phone_number = :father_phone_number, father_email_address = :father_email_address, father_postal_address = :father_postal_address";
                            saveInformation($table, $id, $columns, $parameters, $updateString);
                        } elseif (isset($_POST["mother"])) {
                            $table = "parent_information";
                            $columns = "applicant_id, mother, mother_occupation, mother_phone_number, mother_email_address, mother_postal_address";
                            $parameters = ":applicant_id, :mother, :mother_occupation, :mother_phone_number, :mother_email_address, :mother_postal_address";
                            $updateString = "applicant_id = :applicant_id, mother = :mother, mother_occupation = :mother_occupation, mother_phone_number = :mother_phone_number, mother_email_address = :mother_email_address, mother_postal_address = :mother_postal_address";
                            saveInformation($table, $id, $columns, $parameters, $updateString);
                        } elseif (isset($_POST["guardian"])) {
                            $table = "parent_information";
                            $columns = "applicant_id, guardian, guardian_occupation, guardian_phone_number, guardian_email_address, guardian_postal_address";
                            $parameters = ":applicant_id, :guardian, :guardian_occupation, :guardian_phone_number, :guardian_email_address, :guardian_postal_address";
                            $updateString = "applicant_id = :applicant_id, guardian = :guardian, guardian_occupation = :guardian_occupation, guardian_phone_number = :guardian_phone_number, guardian_email_address = :guardian_email_address, guardian_postal_address = :guardian_postal_address";
                            saveInformation($table, $id, $columns, $parameters, $updateString);
                        } elseif (isset($_POST["sponsor"])) {
                            $table = "parent_information";
                            $columns = "applicant_id, sponsor, sponsor_occupation, sponsor_phone_number, sponsor_email_address, sponsor_postal_address";
                            $parameters = ":applicant_id, :sponsor, :sponsor_occupation, :sponsor_phone_number, :sponsor_email_address, :sponsor_postal_address";
                            $updateString = "applicant_id = :applicant_id, sponsor = :sponsor, sponsor_occupation = :sponsor_occupation, sponsor_phone_number = :sponsor_phone_number, sponsor_email_address = :sponsor_email_address, sponsor_postal_address = :sponsor_postal_address";
                            saveInformation($table, $id, $columns, $parameters, $updateString);
                        } else {
                            echo '$_POST is not set';
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