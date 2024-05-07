<?php
include_once '../admin/Course.php';
$course = new Course('courses_view');
$courses = $course->searchCourse();
echo json_encode($courses);
