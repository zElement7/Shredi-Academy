<?php
//require_once './DataBaseConnection.php';
require_once "DataBaseConnection.php";

session_start();
$returnPage = $_SESSION['lastPage'];

if (isset($_POST['exerciseId'])) {
   // $exerciseId = cleanInputValue($conndb, $_POST['exerciseId']);
    $exerciseId = $_POST['exerciseId'];
} else {
    $exerciseId = "Exercise not found";
}


//use exercise id to select the exercise from the database
$sqlQuery = "SELECT sets, reps, weight, name FROM exercises WHERE id = {$exerciseId}"; //not real query
$result = $conndb->query($sqlQuery);

if (mysqli_num_rows($result) > 0) {
            list($numberOfSets, $numberOfReps, $weightLifted, $exerciseName) = mysqli_fetch_row($result);
}
else{
    echo "Error Getting Exercise Information";
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Exercises</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    </head>
    <body>
<?php
echo <<<HTML
        <div class="editPageDiv">
       <h1>{$exerciseName}</h1>
     <form method="post" action="editExercise.php">
     <label for="sets">Sets:</label>
        <input type="number" id="sets" name="sets" min="" max="" value="{$numberOfSets}" />
     <br>
     <label for="reps">Reps:</label>
     <input type="number" id="reps" name="reps" min="" max="" value={$numberOfReps} />
     <br>
     <label for="weight">Weight:</label>
     <input type="number" id="weight" name="weight" min="" max="" value={$weightLifted} />
      <input type = "hidden" name ="id" value = "{$exerciseId}" />
      <button type = "Submit" value="Save" name="Save">Save</button>
    
    
     </form>
      <button name = "Cancel" value="Cancel"><a href =./{$returnPage}>Cancel</a></button>
    
        </div>
     
     HTML;
     mysqli_close($conndb);
?>

    </body>
</html>


