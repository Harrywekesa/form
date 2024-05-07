<?php
// include './process_form.php';
// include './Form.php';
include './Admin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../applicant/styles.css">
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
            <h1>Admin Registration</h1>
            <div>
                <form action="" method="post" id="form">
                    <div>
                        <label for="firstName">Firstname<span id="firstname"></span></label>
                        <input type="text" name="firstname" id="firstName" value="<?php echo (isset($_POST['firstname']) ? $_POST['firstname'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="lastName">Lastname <span id="lastname"></span></label>
                        <input type="text" name="lastname" id="lastName" value="<?php echo (isset($_POST['lastname']) ? $_POST['lastname'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="secondName">Second Name<span id="second_name"></span></label>
                        <input type="text" name="second_name" id="secondName" value="<?php echo (isset($_POST['second_name']) ? $_POST['second_name'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="emailAddress">Email<span id="email_address"></span></label>
                        <input type="email" name="email_address" id="emailAddress" value="<?php echo (isset($_POST['email_address']) ? $_POST['email_address'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="phoneNumber">Phone<span id="phone_number"></span></label>
                        <input type="tel" name="phone_number" id="phoneNumber" value="<?php echo (isset($_POST['phone_number']) ? $_POST['phone_number'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="idNumber">Id Number/Staff No<span id="id_number"></span></label>
                        <input type="tel" name="id_number" id="idNumber" value="<?php echo (isset($_POST['id_number']) ? $_POST['id_number'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="pass">Password<span id="password"></span></label>
                        <input type="password" name="password" id="pass" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : ""); ?>" required />
                    </div>
                    <div>
                        <label for="confirm_pass">Confirm Password<span id="confirm_password"></span></label>
                        <input type="password" name="confirm_password" id="confirm_pass" value="<?php echo (isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ""); ?>" required />
                    </div>
                    <div><input type="submit" name="submit" value="Register" id="submit" /></div>
                </form>
                <p id="message"></p>
                <?php
                if (isset($_POST['submit'])) {
                    $admin = new Admin();
                    $admin->registerAdmin();
                    $queryStatus = $admin->queryStatus;

                    switch ($queryStatus) {
                        case 0:
                            echo "Successful registration, you will be redirected to login";
                            $url = './login.php';
                            header("refresh:3;" . $url);
                            break;

                        case 1:
                            echo "DB Error";
                            break;
                        case 2:
                            echo "Password too short ! Password should have atleast 8 characters";
                            break;

                        case 3:
                            echo "Passwords don't match";
                            break;

                        case 4:
                            echo "User already exist's, please login";
                            break;

                        case 5:
                            echo "Supply all input fields";
                            break;
                        default:
                            echo "Contact the admin";
                            break;
                    }
                }
                ?>
            </div>
        </main>
        <div></div>
    </div>
    <script>
        // var message = document.getElementById("message");
        // var form = document.getElementById("form");
        // form.addEventListener("submit", (event) => {
        //     event.preventDefault();
        //     var formData = new FormData(form);
        //     const password = formData.get('password');
        //     const confirmPassword = formData.get('confirm_password');
        //     if (password.trim() == confirmPassword.trim()) {
        //         if (password.length >= 8) {
        //             message.textContent = "password length OK !";
        //             formData.delete('confirm_password');
        //         } else {
        //             message.textContent = "password is too short !";
        //         }
        //     } else {
        //         message.textContent = "passwords do not match !";
        //     }
        // })
    </script>
</body>

</html>