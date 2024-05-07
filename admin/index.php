<?php
session_start();
include '../applicant/Form.php';
include './Admin.php';
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
          <h1>Create Courses</h1>
          <p>
            Courses are study areas in which an applicant is applying for. So as to create a course, the admin will need
            to create departments and examining bodies. Then create courses for each department with the corresponding
            examining body.
          </p>
          <p>Finaly he/she will then create a course belongin to given departments with the corresponding examining
            bodies</p>
          <p>Instructions will be provided</p>
        </div>
      </main>
      <div>
        <nav>
          <ul>
            <li><a href="adminLogs.php">Admin Logs</a></li>
            <li><a href="applicantLogs.php">Applicant Logs</a></li>
            <li><a href="applications.php">Applications</a></li>
          </ul>
        </nav>
      </div>
    </div>
    <style>
      .container {
        height: 800px;
      }

      footer {
        margin: -10px -10px -10px;
      }

      .footer-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        background-color: black;
        color: white;
        /* margin-left: -10px; */
      }

      .copyright {
        text-align: center;
      }
    </style>
    <footer>
      <div class="footer-container">
        <div></div>
        <div class="copyright">
          <p>&copy; Wallace.Inc <i>Softwares</i> <?php echo "2023 - " . date("Y") ?></p>
        </div>
        <div></div>
      </div>
    </footer>
  </body>

</html>