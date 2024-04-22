<?php

session_start();
require_once "./includes/DataBaseConnection.php";
$returnPage = $_SESSION['lastPage'];

//parse out the workout id from the exercise id

$toParse = cleanInputValue($conndb, $_POST['toRemove']);
$exerciseRemoveInfo = array();
$exerciseRemoveInfo = explode('-', $toParse);
$workoutId = $exerciseRemoveInfo[0];
$exerciseId = $exerciseRemoveInfo[1];


 $removeQuery = "Delete FROM workout_exercise_connection WHERE workoutId = $workoutId and exerciseId = $exerciseId;";
     
    $result = $conndb->query($removeQuery);

if (!$result) {
    $message = "Invalid Query";
    echo $message;
    die('Invalid query: ' . mysql_error($conndb));
}

mysqli_close($conndb);

header("Location:$returnPage");
?>