<?php
ob_start(); // Start output buffering
session_start();
include './Applicant.php';
include './FileUpload.php';
include './includes/helper_funcs.php';
if (!isset($_SESSION['id'])) {
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
                        <li class="links"><a href="">About</a></li>
                    </div>
                    <div>
                        <li class="links"><a href="">Contact Us</a></li>
                    </div>
                    <div>
                        <li class="links"><a href="../admin/">Admin</a></li>
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
            <div class="main-content">
                <div>
                    <h1>Application</h1>
                    <h2>Upload Documents</h2>
                </div>
                <div class="form-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="form-field"><label for="birth_certificate">Birth Certificate</label></div>
                            <div class="form-field"><input type="file" name="birth_certificate" id="birth_certificate" />
                            </div class="form-field">
                            <div class="form-field"><input type="submit" name="submit" value="Upload" id="submit" /></div>
                            <?php
                            if (isset($_POST['submit'])) {
                                $uploadMessage = upload("birth_certificate"); // upload() from helper function
                                refresh($_SERVER['PHP_SELF'], 5);
                            }
                            ?>
                        </div>
                        <?php if (isset($uploadMessage)) { ?>
                            <div>
                                <p class="status-message"><?php echo $uploadMessage; ?></p>
                            </div>
                        <?php } ?>
                        <div class="file-info">
                            <div>
                                <?php
                                $upload = new FileUpload("birth_certificate");
                                if (!empty($upload->uploadRecord)) { ?>
                                    <p><a href=<?php echo "./uploads/" . $upload->uploadRecord; ?> target="_blank"><?php echo $upload->uploadRecord; ?><span id="button"><a href="<?php echo "upload.php?filename=birth_certificate"; ?>">Delete</a></span></a></p>
                                <?php
                                }
                                if (isset($_GET['filename']) && $_GET['filename'] == 'birth_certificate') {
                                    $deleteMessage = delete();
                                    refresh($_SERVER['PHP_SELF'], 5);
                                }
                                ?>
                                <?php if (isset($deleteMessage)) { ?>
                                    <div>
                                        <p class="status-message"><?php echo $deleteMessage; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="form-field"><label for="kcse">Kenya Certificate of Secondary Education (KCSE)</label></div>
                            <div class="form-field"><input type="file" name="kcse" id="kcse" />
                            </div class="form-field">
                            <div class="form-field"><input type="submit" name="submit" value="Upload" id="submit" /></div>
                            <?php
                            if (isset($_POST['submit'])) {
                                $uploadMessage2 = upload("kcse");
                                refresh($_SERVER['PHP_SELF'], 5);
                            }
                            ?>
                        </div>
                        <?php if (isset($uploadMessage2)) { ?>
                            <div>
                                <p class="status-message"><?php echo $uploadMessage2; ?></p>
                            </div>
                        <?php } ?>
                        <div class="file-info">
                            <div>
                                <?php
                                $upload = new FileUpload("kcse");
                                if (!empty($upload->uploadRecord)) { ?>
                                    <p><a href=<?php echo "./uploads/" . $upload->uploadRecord; ?> target="_blank"><?php echo $upload->uploadRecord; ?><span id="button"><a href="<?php echo "upload.php?filename=kcse"; ?>">Delete</a></span></a></p>
                                <?php
                                }
                                if (isset($_GET['filename']) && $_GET['filename'] == 'kcse') {
                                    $deleteMessage2 = delete();
                                    refresh($_SERVER['PHP_SELF'], 5);
                                }
                                ?>
                                <?php if (isset($deleteMessage2)) { ?>
                                    <div>
                                        <p class="status-message"><?php echo $deleteMessage2; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="form-field"><label for="kcpe">Kenya Certificate of Primary Education (KCPE)</label></div>
                            <div class="form-field"><input type="file" name="kcpe" id="kcpe" />
                            </div class="form-field">
                            <div class="form-field"><input type="submit" name="submit" value="Upload" id="submit" /></div>
                            <?php
                            if (isset($_POST['submit'])) {
                                $uploadMessage3 = upload("kcpe");
                                refresh($_SERVER['PHP_SELF'], 5);
                            }
                            ?>
                        </div>
                        <?php if (isset($uploadMessage3)) { ?>
                            <div>
                                <p class="status-message"><?php echo $uploadMessage3; ?></p>
                            </div>
                        <?php } ?>
                        <div class="file-info">
                            <div>
                                <?php
                                $upload = new FileUpload("kcpe");
                                if (!empty($upload->uploadRecord)) { ?>
                                    <p><a href=<?php echo "./uploads/" . $upload->uploadRecord; ?> target="_blank"><?php echo $upload->uploadRecord; ?><span id="button"><a href="<?php echo "upload.php?filename=kcpe"; ?>">Delete</a></span></a></p>
                                <?php
                                }
                                if (isset($_GET['filename']) && $_GET['filename'] == 'kcpe') {
                                    $deleteMessage3 = delete();
                                    refresh($_SERVER['PHP_SELF'], 5);
                                }
                                ?>
                                <?php if (isset($deleteMessage3)) { ?>
                                    <div>
                                        <p class="status-message"><?php echo $deleteMessage3; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="form-field"><label for="id_card">Identity Card</label></div>
                            <div class="form-field"><input type="file" name="id_card" id="id_card" />
                            </div class="form-field">
                            <div class="form-field"><input type="submit" name="submit" value="Upload" id="submit" /></div>
                            <?php
                            if (isset($_POST['submit'])) {
                                $uploadMessage4 = upload("id_card");
                                refresh($_SERVER['PHP_SELF'], 5);
                            }
                            ?>
                        </div>
                        <?php if (isset($uploadMessage4)) { ?>
                            <div>
                                <p class="status-message"><?php echo $uploadMessage4; ?></p>
                            </div>
                        <?php } ?>
                        <div class="file-info">
                            <div>
                                <?php
                                $upload = new FileUpload("id_card");
                                if (!empty($upload->uploadRecord)) { ?>
                                    <p><a href=<?php echo "./uploads/" . $upload->uploadRecord; ?> target="_blank"><?php echo $upload->uploadRecord; ?><span id="button"><a href="<?php echo "upload.php?filename=id_card"; ?>">Delete</a></span></a></p>
                                <?php
                                }
                                if (isset($_GET['filename']) && $_GET['filename'] == 'id_card') {
                                    $deleteMessage4 = delete();
                                    refresh($_SERVER['PHP_SELF'], 5);
                                }
                                ?>
                                <?php if (isset($deleteMessage4)) { ?>
                                    <div>
                                        <p class="status-message"><?php echo $deleteMessage4; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="form-field"><label for="leaving_certificate">School Leaving Certificate</label></div>
                            <div class="form-field"><input type="file" name="leaving_certificate" id="leaving_certificate" />
                            </div class="form-field">
                            <div class="form-field"><input type="submit" name="submit" value="Upload" id="submit" /></div>
                            <?php
                            if (isset($_POST['submit'])) {
                                $uploadMessage5 = upload("leaving_certificate");
                                refresh($_SERVER['PHP_SELF'], 5);
                            }
                            ?>
                        </div>
                        <?php if (isset($uploadMessage5)) { ?>
                            <div>
                                <p class="status-message"><?php echo $uploadMessage5; ?></p>
                            </div>
                        <?php } ?>
                        <div class="file-info">
                            <div>
                                <?php
                                $upload = new FileUpload("leaving_certificate");
                                if (!empty($upload->uploadRecord)) { ?>
                                    <p><a href=<?php echo "./uploads/" . $upload->uploadRecord; ?> target="_blank"><?php echo $upload->uploadRecord; ?><span id="button"><a href="<?php echo "upload.php?filename=leaving_certificate"; ?>">Delete</a></span></a></p>
                                <?php
                                }
                                if (isset($_GET['filename']) && $_GET['filename'] == 'leaving_certificate') {
                                    $deleteMessage5 = delete();
                                    refresh($_SERVER['PHP_SELF'], 5);
                                }
                                ?>
                                <?php if (isset($deleteMessage5)) { ?>
                                    <div>
                                        <p class="status-message"><?php echo $deleteMessage5; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <p id="message"></p>
        </main>
        <div></div>
    </div>

</body>

</html>
<?php ob_end_flush(); // Send buffered output to the browser
?>