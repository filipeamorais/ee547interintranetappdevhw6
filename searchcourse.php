<?PHP
  include '../appdata/eeschedule-db.inc';

  $connection = mysqli_connect($host, $user, $password , $database);

  if (mysqli_connect_errno() ) {
    die( mysqli_connect_error() );    // not production error handling
  }
?>

<body>
  <h1>Add offering</h1>
  <p>
    The following offering was submitted.
  </p>
  <table>
    <tr>
      <th>Semester</th><th>Course</th><th>Title</th><th>Days</th><th>Time</th><th>Enrolled(Act)</th><th>Instructor</th><th>Location</th>
    </tr>
<?php
$fieldName = "course_id";
$courseId = $_GET[$fieldName];
$sqlSelectCourseIndex = "SELECT id FROM courses WHERE (" . $courseId . ")";
?>
    </table>

    <p>
    <a href="coursehistory.php">Make another search</a>
  </p>