<?php
session_start();
require_once "./includes/DataBaseConnection.php";

$query = "SELECT id, Name, Day_of_the_Week, Muscle_Group, Difficulty_Level  FROM workout order by Day_of_the_Week, Name";

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
                    <form method="post" action="individualWorkout.php" style="width:100%;">
                            <button class='workoutBox' type="submit" name ="workOutId" value='{$myWorkouts['id']}'> 
                            <div id='workout{$myWorkouts['id']}' class = 'workoutText'>
                                <h4>{$myWorkouts['Name']}</h4>
                                <div class = 'workoutDetails'>    
                               <h5>{$myWorkouts['Day_of_the_Week']}</h5><h5> {$myWorkouts['Muscle_Group']}</h5> 
                                   </h5> <h5>Difficulty Level: {$myWorkouts['Difficulty_Level']}</h5>
                               </div>
                            </div>
                        </button>
                         </form>
                         <form id="deleteForm" action="deleteExercise.php" method="post">
                            <input type="hidden" name="toDelete" value={$myWorkouts['id']}>
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