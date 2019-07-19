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
echo "    <tr>\n";
$fieldName = "course_id";
$courseId = $_GET[$fieldName];
echo $courseId;
$sqlSelectCourse = "SELECT * FROM courses WHERE (course='" . $courseId . "')";
echo $sqlSelectCourse;
$resultCourse = mysqli_query($connection, $sqlSelectCourse);
$courseRow = mysqli_fetch_assoc($resultCourse);
$sqlSelectReginfo = "SELECT * FROM reginfo WHERE (course_id='" . $courseRow['id'] . "')";
echo $sqlSelectReginfo;
$resultReginfo = mysqli_query($connection, $sqlSelectReginfo);
$reginfoRow = mysqli_fetch_assoc($resultReginfo);
$sqlSelectInstructor = "SELECT * FROM instructors WHERE (id='" . $reginfoRow['instructor_id'] . "')";
echo $sqlSelectInstructor;
$resultInstructor = mysqli_query($connection, $sqlSelectInstructor);
$instructorRow = mysqli_fetch_assoc($resultInstructor);
while ($reginfoRow = mysqli_fetch_assoc($resultReginfo)) {
echo "      <td>" .$reginfoRow['semester']. "</td>";
echo "      <td>" .$courseRow['course']. "</td>";
echo "      <td>" .$courseRow['title']. "</td>";
echo "      <td>" .$reginfoRow['days']. "</td>";
echo "      <td>" .$reginfoRow['time']. "</td>";
echo "      <td>" .$reginfoRow['act']. "</td>";
echo "      <td>" .$instructorRow['instructor']. "</td>";
echo "      <td>" .$reginfoRow['location']. "</td>";
echo "    </tr>\n";
}
?>
    </table>

    <p>
    <a href="coursehistory.php">Make another search</a>
  </p>