<?PHP
include '../appdata/eeschedule-db.inc';

$connection = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
  die(mysqli_connect_error());    // not production error handling
}

$courseId = $_GET["course_id"];
$orderBy = $_GET["order_by"];
if ($orderBy == "reginfo.semester") {
  $secondOrderBy = "reginfo.act";
  $orderByLabel = "SEMESTER";
  $secondOrderByLabel = "ENROLLED NUMBER";
} else {
  $secondOrderBy = "reginfo.semester";
  $orderByLabel = "ENROLLED NUMBER";
  $secondOrderByLabel = "SEMESTER";
}
?>

<link rel="stylesheet" href="basesearch.css" type="text/css">

<body>
  <main>
    <h1>Course History</h1>
  </main>
  <p>
    Follow bellow your selected course history sorted first by <b> <?PHP echo htmlspecialchars($orderByLabel, ENT_QUOTES, 'UTF-8') ?> </b> and then by <b> <?PHP echo htmlspecialchars($secondOrderByLabel, ENT_QUOTES, 'UTF-8') ?> </b> in descending order:
  </p>
  <table>
    <tr>
      <th>Semester</th>
      <th>Course</th>
      <th>Title</th>
      <th>Days</th>
      <th>Time</th>
      <th>Enrolled(Act)</th>
      <th>Instructor</th>
      <th>Location</th>
    </tr>
    <?php
    echo "    <tr>\n";
    $sqlSelectDataInnerJoin = "SELECT * FROM courses INNER JOIN reginfo ON courses.id=course_id INNER JOIN instructors ON instructor_id=instructors.id WHERE course='" . htmlspecialchars($courseId, ENT_QUOTES, 'UTF-8') . "' ORDER BY " . htmlspecialchars($orderBy, ENT_QUOTES, 'UTF-8') . " DESC, " . htmlspecialchars($secondOrderBy, ENT_QUOTES, 'UTF-8') . " DESC";
    $resultCourseHistory = mysqli_query($connection, $sqlSelectDataInnerJoin);
    while ($courseHistoryRow = mysqli_fetch_assoc($resultCourseHistory)) {
      echo "      <td>" . $courseHistoryRow['semester'] . "</td>";
      echo "      <td>" . $courseHistoryRow['course'] . "</td>";
      echo "      <td>" . $courseHistoryRow['title'] . "</td>";
      echo "      <td>" . $courseHistoryRow['days'] . "</td>";
      echo "      <td>" . $courseHistoryRow['time'] . "</td>";
      echo "      <td>" . $courseHistoryRow['act'] . "</td>";
      echo "      <td>" . $courseHistoryRow['instructor'] . "</td>";
      echo "      <td>" . $courseHistoryRow['location'] . "</td>";
      echo "    </tr>\n";
    }
    ?>
  </table>

  <p>
    <a href="coursehistory.php">Make another search</a>
  </p>