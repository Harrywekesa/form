<nav>
    <ul>
        <li><a href="personal.php">Personal Information</a></li>
        <li><a href="demographics.php">Demographic Information</a></li>
        <li><a href="academics.php">Academic Information</a></li>
        <li><a href="course.php<?php echo (isset($_GET['courseId']) ? '?courseId=' . $_GET['courseId'] : '') ?>">Select
                Course</a></li>
        <li><a href="guardian.php">Parent/Guardian Information</a></li>
        <li><a href="upload.php">Upload Documents</a></li>
        <li><a href="submit.php">View and submit your application</a></li>
        <li><a href="status.php">Application Status</a></li>
    </ul>
</nav>