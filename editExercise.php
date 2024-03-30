<?php
session_start();
$returnPage = $_SESSION['lastPage'];
require_once "./includes/DataBaseConnection.php";

$reps = cleanInputValue($conndb, $_POST['reps']);
$sets = cleanInputValue($conndb, $_POST['sets']);
$weight = cleanInputValue($conndb, $_POST['weight']);
$exerciseId = cleanInputValue($conndb, $_POST['id']);

$updateQuery = "UPDATE exercises SET reps = {$reps}, sets = {$sets}, weight = {$weight} WHERE id = {$exerciseId}";
$success = $conndb->query($updateQuery);
    
    if($success == false)
    {
        $failmess = "Whole query " . $insert . "<br>";
        echo $failmess;
        print('Invalid query: ' . mysqli_error($con). "<br>");
        
    }
    else
    {
        echo "Exercise updated<br>";
    }
    
mysqli_close($conndb);
header("Location:" . $returnPage); //redirect to exercise page




