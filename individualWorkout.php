<?php
session_start();
require_once "./includes/DataBaseConnection.php";

$_SESSION['lastPage'] = $_SERVER["REQUEST_URI"];
$wokoutName = "";
$workoutDays = "";
$workoutMuscleGroup = "";
$workoutDifficulty = "";
$exerciseInfo = array();

if (isset($_GET['workoutId'])) {
     $workoutId = cleanInputValue($conndb, $_GET['workoutId']);

} else {
    $workoutId = "Workout not found";
}


//use workout id to select the exercise from the database
$sqlQuery = "Select e.name as exerciseName, e.id as exerciseId, e.sets as sets, e.reps as reps, e.weight as weight, "
        . "w.Name as workoutName, w.Difficulty_Level as difficultyLevel, "
        . "w.Day_of_the_Week as dayOfWeek, w.Muscle_Group as muscleGroup FROM workouts as w "
."INNER JOIN workout_exercise_connection as c ON c.workoutId = w.id INNER JOIN exercises as e ON c.exerciseId = e.id WHERE w.id = {$workoutId};";

$result = $conndb->query($sqlQuery);

if (mysqli_num_rows($result) > 0) {
    while( $allInformation = $result->fetch_assoc())
    {
        $workoutDays = $allInformation['dayOfWeek'];
        $workoutName = $allInformation['workoutName'];
        $workoutDifficulty = $allInformation['difficultyLevel'];
        $workoutMuscleGroup = $allInformation['muscleGroup'];
        array_push($exerciseInfo, array($allInformation['exerciseName'], $allInformation['exerciseId'], $allInformation['sets'],
               $allInformation['reps'], $allInformation['weight'] ));
    }


} else {
    echo "Workout Not Found During Search ";
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
 include_once "./includes/nav.php";
       
echo <<<HTML
        <div class="contentWrapper">     
        <div class="editPageDiv container-fluid text-center w-100">
        <h1>{$workoutName}</h1>
        </br>
        <h3>Days of Week : {$workoutDays}</h3>
        <h3>Muscle Group : {$workoutMuscleGroup}</h3>
        <h3>Difficulty Level : {$workoutDifficulty}</h3>
        <form method="post" action="individualExercise.php" style="width:100%;">
     HTML;
       

     for($n = 0; $n < sizeof($exerciseInfo); $n++)
     {
echo <<< HTML
             <button class='exerciseBox' type="submit" name="exerciseId" value='{$exerciseInfo[$n][1]}'> 
          <div id='exercise{$exerciseInfo[$n][1]}' class = 'workoutText'>{$exerciseInfo[$n][0]}</div>
              <div class="individualWorkoutDetails">Sets: {$exerciseInfo[$n][2]} Reps: {$exerciseInfo[$n][3]} Weight: {$exerciseInfo[$n][4]} lbs
                  </div></button>
      HTML;         
     }
     
               echo"</div></div></form>";
                        
        
mysqli_close($conndb);
?>
    </body>
</html>


