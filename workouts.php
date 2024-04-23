<?php
session_start();
require_once "./includes/DataBaseConnection.php";
        
$query = "SELECT id, name, day_of_the_week, muscle_group, difficulty_level  FROM workouts order by day_of_the_week, name";

$result = $conndb->query($query);

if (!$result) {
    $message = "Invalid Query";
    echo $message;
    die('Invalid query: ' . mysql_error($conndb));
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Workouts</title>

        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
<?php include_once "./includes/nav.php"; ?>
        <div class="contentWrapper">
            <h1>Workouts</h1>
            <div class="interactiveBoxesDiv">
                <a style="text-decoration: none;" href ="workout.php">
                    <div id="addExerciseBox">Add Workout</div>
                </a>

<?php
if ($result->num_rows <= 0) {
    echo "Workouts Created";
}
// output data of each row
while ($myWorkouts = $result->fetch_assoc()) {


    echo <<<HTML
                    <div class='exerciseDiv'>
                    <form method="get" action="individualWorkout.php" style="width:100%;">
                            <button class='workoutBox' type="submit" name ="workoutId" value='{$myWorkouts['id']}'> 
                            <div id='workout{$myWorkouts['id']}' class = 'workoutText'>
                                {$myWorkouts['name']}</div>
                                <div class = 'workoutDetails'>    
                               {$myWorkouts['day_of_the_week']} {$myWorkouts['muscle_group']}
                                   Difficulty Level: {$myWorkouts['difficulty_level']}
                               
                            </div>
                        </button>
                         </form>
                         <form id="deleteForm" action="deleteExercise.php" method="post">
                            <input type="hidden" name="'workout_id'" value={$myWorkouts['id']}>
                            <button type="submit" class='glyphicon glyphicon-trash'></button>     
                                </form>
                    </div>
        HTML;
}
    mysqli_close($conndb);
echo "</div>";
?>



    </body>
</html>