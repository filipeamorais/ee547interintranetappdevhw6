<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Course History Database</title>
  <link rel="stylesheet" href="demodb2.css" />
</head>

<body>
<h1>Select the course you want search the history</h1>

<?PHP
  
  include '../appdata/eeschedule-db.inc';

  $connection = mysqli_connect($host, $user, $password , $database);

  if (mysqli_connect_errno() ) {
    die( mysqli_connect_error() );    // not production error handling
  }

  /**
   * Make a drop down control
   * 
   * <select id='name' name='name_id'>
   * <option value="from_row_id">from_row</option>
   * ...
   * </select>
   */

  function makeDropDown($name,$sql_rows) {
    if (! $sql_rows) {
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
  $sqlListInstructors = "SELECT id, instructor FROM instructors ORDER BY instructor ASC";
  $result = mysqli_query($connection, $sqlListCourses);
  $courseListDropDown = makeDropDown("course",$result);
  mysqli_free_result($result);
  $result = mysqli_query($connection, $sqlListInstructors);
  $instructorListDropDown = makeDropDown("instructor",$result);
  mysqli_free_result($result);
  mysqli_close($connection);
?>

  <h2>Add another offering to registration history</h2>
  <form action="searchcourse.php" method="get">
    <fieldset>
      <!-- <span class="required">* <small>required value</small></span><br />
      <label for="semester">Semester<span class="required">*</span></label> <input type="text" id="semester" name="semester" required placeholder="2019-3Summer" /><br /> -->
      <label for="course_id">Course<span class="required">*</span></label> <?PHP echo $courseListDropDown ?><br />
      <!-- <label for="sec">Section<span class="required">*</span></label> <input type="text" id="sec" name="sec" placeholder="OY" required /><br />
      <label for="days">Days<span class="required">*</span></label> <input type="text" id="days" name="days" placeholder="TR" required /><br />
      <label for="time">Time<span class="required">*</span></label> <input type="text" id="time" name="time" placeholder="05:20 pm-07:20 pm" required /><br />
      <label for="cap">Capacity<span class="required">*</span></label> <input type="number" id="cap" name="cap" placeholder="25" required /><br />
      <label for="act">Actual<span class="required">*</span></label> <input type="number" id="act" name="act"  placeholder="25" required /><br />
      <label for="instructor_id">Instructor<span class="required">*</span></label> <?PHP echo $instructorListDropDown ?><br />
      <label for="location">Location<span class="required">*</span></label> <input type="text" id="location" name="location" placeholder="BEC 155" required /><br /> -->
      <input type="submit">
    </fieldset>
  </form>

</body>
</html>
