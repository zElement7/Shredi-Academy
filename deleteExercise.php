<?php
require_once "./includes/DataBaseConnection.php";

$toDelete = cleanInputValue($conndb, $_POST['toDelete']);

echo "To delete " . $toDelete;

$deleteQuery = "Delete FROM exercises WHERE id=$toDelete";
$success = $conndb->query($deleteQuery);
    
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
header('Location:./exercise.php'); //redirect to exercise page