<?php

session_start();
$returnPage = $_SESSION['lastPage'];
require_once "./includes/DataBaseConnection.php";

$reps = cleanInputValue($conndb, $_POST['reps']);
$sets = cleanInputValue($conndb, $_POST['sets']);
$weight = cleanInputValue($conndb, $_POST['weight']);
$exerciseId = cleanInputValue($conndb, $_POST['id']);

$weight = floatval($weight);

$updateQuery = "UPDATE exercises SET reps = {$reps}, sets = {$sets}, weight = {$weight} WHERE id = {$exerciseId}";
$success = $conndb->query($updateQuery);

if ($success == false) {
    $failmess = "Whole query " . $updateQuery . "<br>";
    echo $failmess;
    print('Invalid query: ' . mysqli_error($conndb) . "<br>");
} else {
    echo "Exercise updated<br>";
}

//check if this is the first/best addition to the database
//if it is the first mark both first_entry and personal_best as true in the progress table
//if this isn't the first, check which progress result has the personal_best.  See if this 
//edit is better than the current personal best.  If it is, make this edit the personal best
//and make the old personal best record so it is no longer the personal best.    
$pquery = "SELECT id, first_entry, personal_best, weight from progress WHERE exercise_id = '$exerciseId'";

$exerciseProgress = $conndb->query($pquery);

if ($exerciseProgress == false) {
    $failmess = "Whole query " . $pquery . "<br>";
    echo $failmess;
    print('Invalid query: ' . mysqli_error($conndb) . "<br>");
}

$progress = array();
date_default_timezone_set('America/Boise');
$todaysDate = date("Y-m-d");
$updateProgressQuery = "";

//entry doesn't exist, make this the first and personal best entry
if ($exerciseProgress->num_rows <= 0) {
    $updateProgressQuery = "INSERT INTO `progress` (`date`, `exercise_id`, `weight`, `first_entry`, "
            . "`personal_best`) VALUES ('$todaysDate', $exerciseId,$weight,1,1);";
} else {
    while ($myProgress = $exerciseProgress->fetch_assoc()) {

        $data = array("progressId" => "{$myProgress['id']}", "firstEntry" => "{$myProgress['first_entry']}",
            "personalBest" => "{$myProgress['personal_best']}", "weight" => "{$myProgress['weight']}");

        array_push($progress, $data);
    }

    $newPersonalBest = False;
    $oldPersonalBestId = "";

    foreach ($progress as $p) {
        if ($p['personalBest'] == 1) {

            if ($p['weight'] < $weight) {

                $oldPersonalBestId = $p["progressId"];
                $newPersonalBest = True;
            }
        }
    }

    //if we have a new personal best
    if ($newPersonalBest == True) {
        $updateProgressQuery = "INSERT INTO `progress` (`date`, `exercise_id`, `weight`, `first_entry`, "
                . "`personal_best`) VALUES ('$todaysDate', $exerciseId,$weight,0,1);";
        $sqlResult = $conndb->query($updateProgressQuery);
        $updateProgressQuery = "UPDATE progress SET personal_best = 0 WHERE id = $oldPersonalBestId;";
    } 
    //if not add the progress, don't set it as personal best
    else {
        $updateProgressQuery = "INSERT INTO `progress` (`date`, `exercise_id`, `weight`, `first_entry`, "
                . "`personal_best`) VALUES ('$todaysDate', $exerciseId,$weight,0,0);";
    }
}
$sqlStuff = $conndb->query($updateProgressQuery);

if ($sqlResult == false) {
    $failmess = "Whole query " . $updateProgressQuery . "<br>";
    echo $failmess;
    print('Invalid query: ' . mysqli_error($conndb) . "<br>");
}


mysqli_close($conndb);
header("Location:" . $returnPage); //redirect to exercise page




