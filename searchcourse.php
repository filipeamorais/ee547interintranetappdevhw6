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
    $sqlSelectDataInnerJoin = "SELECT * FROM courses INNER JOIN reginfo ON courses.id=course_id INNER JOIN instructors ON instructor_id=instructors.id WHERE course=? ORDER BY  ? DESC, ? DESC";
    $stmt=$connection->prepare($sqlSelectDataInnerJoin);
    $stmt->bind_param("iss", $courseId, $orderBy, $secondOrderBy);
    $stmt->execute();
    $stmt->bind_result($id1, $course, $title, $id2, $semester, $course_id, $sec, $days, $time, $cap, $act, $instructor_id, $location, $id3, $instructor);
    while ($stmt->fetch()) {
      echo "      <td>" . $semester . "</td>";
      echo "      <td>" . $course . "</td>";
      echo "      <td>" . $title . "</td>";
      echo "      <td>" . $days . "</td>";
      echo "      <td>" . $time . "</td>";
      echo "      <td>" . $act. "</td>";
      echo "      <td>" . $instructor . "</td>";
      echo "      <td>" . $location . "</td>";
      echo "    </tr>\n";
    }
    ?>
  </table>

  <p>
    <a href="coursehistory.php">Make another search</a>
  </p>