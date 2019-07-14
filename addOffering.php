<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Add Offering</title>
  <link rel="stylesheet" href="demodb2.css">
</head>
<?PHP
  include '../appdata/eeschedule-db.inc';

  $connection = mysqli_connect($host, $user, $password , $database);

  if (mysqli_connect_errno() ) {
    die( mysqli_connect_error() );    // not production error handling
  }

  $fieldnames      = ["semester"      => "s",
                      "course_id"     => "d",
                      "sec"           => "s",
                      "days"          => "s",
                      "time"          => "s",
                      "cap"           => "d",
                      "act"           => "d",
                      "instructor_id" => "d",
                      "location"      => "s"
                    ];

  $validationRegEx = ["semester"      => "/^\d{4}-(?:1Spring|3Summer|4Fall)\b$/",
                      "course_id"     => "/^\d+$/",
                      "sec"           => "/^[\w\d]{1,3}$/",
                      "days"          => "/^\w{0,3}$/",
                      "time"          => "/^[\w\d-: ]*$/",
                      "cap"           => "/^\d{1,3}$/",
                      "act"           => "/^\d{1,3}$/",
                      "instructor_id" => "/^\d+$/",
                      "location"      => "/^\w+(?: \d*)*$/"
                    ];           
?>
<body>
  <h1>Add offering</h1>
  <p>
    The following offering was submitted.
  </p>
  <table>
    <tr>
      <th>Field</th><th>Value</th>
    </tr>
<?PHP
    $missing  = false;     # no field missing
    $fields   = '';        # build up string of fields
    $values   = [];        # build up array of corresponding values
    $inserts  = '';        # build up string of place holders
    $validationError = '';
    
    foreach ($fieldnames as $fieldName => $typeField) {
      echo "    <tr>\n";
      $value = "missing";
      if (isset($_GET[$fieldName])) {
        $value = $_GET[$fieldName];

        // does value fail compliance with regex validation?
        if ( preg_match( $validationRegEx[$fieldName], $value) != 1 ) {
          $validationError .= "invalid value for " . $fieldName . "\n";
          // clean up errant string for display
          $value = filter_var($value, FILTER_SANITIZE_STRING);
        }

        if ( $fields != '' ) {
          $fields  .= ",";
          $inserts .= ",";
        }
        $fields  .= $fieldName;
        $inserts .= "?";
        $values[$fieldName] = $value;
      } else {
        $missing = true;
      }
      echo "      <td>$fieldName</td><td>$value</td>\n";
      echo "    </tr>\n";
    }
?>
  </table>
 
<?PHP
    $sql = "INSERT INTO reginfo (" . $fields . ") VALUES (" . $inserts . ")";

    if ($validationError) {
      echo "<p class='error'>Validation errors: " . $validationError . "</p>\n" ;
    } else {
      $connection = mysqli_connect($host, $user, $password , $database);

      if (mysqli_connect_errno() ) {
        die( mysqli_connect_error() );    // TBD: not production error handling
      }

      $stmt = mysqli_stmt_init($connection);

      if ( mysqli_stmt_prepare ( $stmt , $sql ) ) {
        $bindTypes = '';

        foreach ($fieldnames as $fieldName => $typeField) {
          $bindTypes .= $typeField; 
        }
        mysqli_stmt_bind_param($stmt, $bindTypes,
                                      $values["semester"],
                                      $values["course_id"],
                                      $values["sec"],
                                      $values["days"],
                                      $values["time"],
                                      $values["cap"],
                                      $values["act"],
                                      $values["instructor_id"],
                                      $values["location"]
          );

        $result = mysqli_stmt_execute($stmt);

        $error = mysqli_stmt_error($stmt);
        if ($error) {
          echo "<p class='error'>Error in insert: ". $error . "</p>\n";
        } else {
          echo "<p>Insert succeeded</p>\n";
        }

      }
      mysqli_close($connection);    
        
    }
  ?>
  
  </code></pre>
  
  <p>
    <a href="demodb2.php">Add another offering</a>
  </p>

  <h2>Future work</h2>
  <ul>
    <li>Create button to approve submission of the data (handle state of additions desired)</li>
    <li>Create a page to store the data (after re-validation) into table</li>
    <li>Redirect user to demodb2.php for more submissions (perhaps with note about success of the last write)</li>
    <li>Add state information to ensure the whole cycle is obeyed (probably)</li>
    <li>Add appropriate styling</li>
  </ul>
</body>
</html>
