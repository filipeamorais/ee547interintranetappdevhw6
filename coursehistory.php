<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Course History Database</title>
  <link rel="stylesheet" href="basesearch.css" type="text/css">
</head>

<body>
  <main>
    <div>
      <h1>Course History</h1>

      <?PHP

      include '../appdata/eeschedule-db.inc';

      $connection = mysqli_connect($host, $user, $password, $database);

      if (mysqli_connect_errno()) {
        die(mysqli_connect_error());    // not production error handling
      }

      function makeDropDown($name, $sql_rows)
      {
        if (!$sql_rows) {
          return "No Values for Control";
        }

        $name_id = $name . '_id';
        $control = "<select id='$name' name='$name_id'>\n";

        while ($row = mysqli_fetch_assoc($sql_rows)) {
          $control .= ("  <option value =" . $row[$name] . ">" . $row[$name] . "</option>\n");
        }
        $control .= "</select>\n";
        return $control;
      }

      $sqlListCourses = "SELECT id, course FROM courses ORDER BY course ASC";
      $result = mysqli_query($connection, $sqlListCourses);
      $courseListDropDown = makeDropDown("course", $result);
      mysqli_free_result($result);
      mysqli_close($connection);
      ?>

      <h2>Select the course you want to search the history:</h2>
      <form action="searchcourse.php" method="get">
        <fieldset>
          <label for="course_id">Course<span class="required">*</span></label> <?PHP echo $courseListDropDown ?><br />
          <label for="order_by">Order By<span class="required">*</span></label>
          <select id='order_by' name='order_by'>
            <option value="reginfo.semester">Semester</option>
            <option value="reginfo.act">Enrolled Number</option>
          </select>
          <br/>
          <input type="submit">
        </fieldset>
      </form>

</body>

</html>