<?php
session_start();
require_once "./includes/DataBaseConnection.php";

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

$_SESSION['lastPage'] = "individualWorkout.php?workoutId=$workoutId";
//use workout id to select the exercise from the database
$sqlQuery = "Select e.name as exerciseName, e.id as exerciseId, e.sets as sets, e.reps as reps, e.weight as weight, "
        . "w.name as workoutName, w.difficulty_level as difficultyLevel, "
        . "w.day_of_the_week as dayOfWeek, w.muscle_group as muscleGroup FROM workouts as w "
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    </head>
    <body>
<?php
       
echo <<<HTML
        <div class="contentWrapper">     
        <div class="editPageDiv container-fluid text-center w-100">
        <h1>{$workoutName}</h1>
        <form method = "post" action = "editWorkout.php">
        <button id="editWorkoutBox" type = "submit" name="workoutToEdit" value = '{$workoutId}'>Edit Workout</button>
        </form>   

         </br>
        <h3>Days of Week : {$workoutDays}</h3>
        <h3>Muscle Group : {$workoutMuscleGroup}</h3>
        <h3>Difficulty Level : {$workoutDifficulty}</h3>
        
        
     HTML;
       

     for($n = 0; $n < sizeof($exerciseInfo); $n++)
     {
echo <<< HTML
            <div class='exerciseDiv'>     
             <form method="post" action="individualExercise.php" style="width:100%;">
             <button class='exerciseBox' type="submit" name="exerciseId" value='{$exerciseInfo[$n][1]}'> 
          <div id='exercise{$exerciseInfo[$n][1]}' class = 'workoutText'>{$exerciseInfo[$n][0]}</div>
              <div class="individualWorkoutDetails">Sets: {$exerciseInfo[$n][2]} Reps: {$exerciseInfo[$n][3]} Weight: {$exerciseInfo[$n][4]} lbs
                  </div></button></form>
                             <form id="removeExercise" action="removeExercise.php" method="post">
                            <input type="hidden" name="toRemove" value="{$workoutId}-{$exerciseInfo[$n][1]}">
                            <button type="submit" class='glyphicon glyphicon-trash'></button>     
                                </form>
                            </div>
      HTML;         
     }
     
         
               

                        
        
mysqli_close($conndb);
?>
    </body>
</html>


