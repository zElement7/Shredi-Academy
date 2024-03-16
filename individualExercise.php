<?php
//require_once './DataBaseConnection.php';

if (isset($_POST['exerciseId'])) {
   // $exerciseId = cleanInputValue($conndb, $_POST['exerciseId']);
    $exerciseId = $_POST['exerciseId'];
} else {
    $exerciseId = "Exercise not found";
}


//use exercise id to select the exercise from the database
$sqlQuery = "SELECT sets, reps, name FROM exercises WHERE id = {$exerciseId}"; //not real query
//$result = $conndb->query($sql);
//$row = $result->fetch_assoc();
//$numberOfSets = $row['sets'];

$exerciseName = "Shoulder Press";
$numberOfSets = 3;
$numberOfReps = 10;
$weightLifted = 70;
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
      <button type = "Submit" value="Save" name="Save">Save</button>
    
     </form>
      <button name = "Cancel" value="Cancel"><a href =./exercise.php>Cancel</a></button>
    
        </div>
     
     HTML;
?>

    </body>
</html>


