<?php
// include './process_form.php';
// include './Form.php';
include './Applicant.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/styles.css">
    <!-- <script src="../script.js" defer></script> -->
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
                        <li class="links"><a href="login.php">Login</a></li>
                    </div>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container">
        <div></div>
        <main>
            <h1>Password Reset</h1>
            <div>
                <form action="" method="post" id="form">
                    <div>
                        <label for="emailAddress">Email<span id="email_address"></span></label>
                        <input type="email" name="email_address" id="emailAddress" value="<?php echo (isset($_POST['email_address']) ? $_POST['email_address'] : ""); ?>" />
                    </div>
                    <div>
                        <label for="phoneNumber">Phone Number<span id="phone_number"></span></label>
                        <input type="tel" name="phone_number" id="phoneNumber" value="<?php echo (isset($_POST['phone_number']) ? $_POST['phone_number'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="pass">Password<span id="password"></span></label>
                        <input type="password" name="password" id="pass" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="confirm_pass">Confirm Password<span id="confirm_password"></span></label>
                        <input type="password" name="confirm_password" id="confirm_pass" value="<?php echo (isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ""); ?>" required />
                    </div>
                    <div><input type="submit" name="submit" value="Reset" id="submit" /></div>
                </form>
                <p id="message"></p>
                <?php
                if (isset($_POST['submit'])) {
                    $applicant = new Applicant();
                    $applicant->resetPassword();
                    $queryStatus = $applicant->queryStatus;
                    switch ($queryStatus) {
                        case 0:
                            echo "Password reset successiful, you will be redirected to login";
                            $url = './login.php';
                            header("refresh:3;" . $url);
                            break;

                        case 1:
                            echo "Password reset fail, contact applicant";
                            break;

                        case 2:
                            echo "Password too short ! Password should have atleast 8 characters";
                            break;

                        case 3:
                            echo "Password don't match";
                            break;

                        case 4:
                            echo "User not found";
                            break;

                        case 5:
                            echo "Provide all input fields";
                            break;

                        default:
                            echo "Contact Applicant";
                            break;
                    }
                }
                ?>
            </div>
        </main>
        <div></div>
    </div>

</body>

</html>