<?php
session_start();
require_once "./includes/DataBaseConnection.php";
$returnPage = $_SESSION['lastPage'];
$workoutId = cleanInputValue($conndb, $_POST['workoutToEdit']);
//get all of the exercises so that the user can select one
$query = "SELECT id, Name, Day_of_the_Week, Muscle_Group, Difficulty_Level FROM workouts WHERE id = {$workoutId}";
$result = $conndb->query($query);

if (mysqli_num_rows($result) > 0) {
    list($id, $name, $day, $group, $difficulty) = mysqli_fetch_row($result);
} else {
    echo "Error Getting Workout Information";
}

$dayArray = array();
$dayArray = explode(" ",$day);


function checkForDay($myDayArray, $aDay) {
    foreach ($myDayArray as $d) {
        if ($aDay == $d) {
            return true;
        }
    }
    return false;
}
// Check if form is submitted, and that we have valid workout name
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['muscle_group'])) {
    // Get and sanitize form data
    $muscle_group = cleanInputValue($conndb, $_POST["muscle_group"]);
    $workoutId = cleanInputValue($conndb, $_POST['workoutToEdit']);
    $daysOfWeek = $_POST["days_of_the_week"];
    $difficulty = cleanInputValue($conndb, $_POST["difficulty"]);

    //need to read daysOfweek as array
    $days = "";
    foreach ($daysOfWeek as $d) {
        $d = cleanInputValue($conndb,$d);
        $days .= "$d ";
    }

    //add the workout
    $editQuery = "UPDATE workouts SET muscle_group = '$muscle_group', day_of_the_week = '$days', difficulty_level = $difficulty "
            . "WHERE id = $workoutId; ";
   
    
    $edited = $conndb->query($editQuery);
    
    $pageToGoTo = "individualWorkout.php?workoutId=$workoutId";
    header("Location:$pageToGoTo");
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Workout</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
        <div class="container-fluid text-center w-100">
<?php echo "<h2>Edit $name</h2>"; ?>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
               <input type="hidden" name="workoutToEdit" id="hiddenField" value="<?php echo $_POST['workoutToEdit'] ?>"
                <label for="muscle_group">Muscle Group:</label>
                <select name="muscle_group" id="muscle_group">
                    <option value="Chest" <?php if ($group == 'Chest') {
    echo "selected='selected'";
} ?> >Chest</option>
                    <option value="Back" <?php if ($group == 'Back') {
    echo "selected='selected'";
} ?>>Back</option>
                    <option value="Legs" <?php if ($group == 'Legs') {
    echo "selected='selected'";
} ?>>Legs</option>
                    <option value="Shoulders" <?php if ($group == 'Shoulders') {
    echo "selected='selected'";
} ?>>Shoulders</option>
                    <option value="Arms"<?php if ($group == 'Arms') {
    echo "selected='selected'";
} ?> >Arms</option>
                    <!-- Add more options as needed -->
                </select>
                <br>
                <label for="days_of_the_week[]">Days Doing Workout:</label>

                <select name="days_of_the_week[]" id="days_of_the_week" multiple="multiple">
                    <option value="U"<?php if(checkForDay($dayArray, "U")) {echo "selected='selected'";}?>>Sunday</option>
                    <option value="M" <?php if(checkForDay($dayArray, "M")) {echo "selected='selected'";}?>>Monday</option>
                    <option value="T" <?php if(checkForDay($dayArray, "T")) {echo "selected='selected'";}?>>Tuesday</option>
                    <option value="W"<?php if(checkForDay($dayArray, "W")) {echo "selected='selected'";}?>>Wednesday</option>
                    <option value="H"<?php if(checkForDay($dayArray, "H")) {echo "selected='selected'";}?>>Thursday</option>
                    <option value="F" <?php if(checkForDay($dayArray, "F")) {echo "selected='selected'";}?>>Friday</option>
                    <option value="S" <?php if(checkForDay($dayArray, "SF")) {echo "selected='selected'";}?>>Saturday</option>

                </select>
                <br>
                <label for="difficulty">Difficulty:</label>
                <select name="difficulty" id="difficulty" multiple>
                    <option value="1" <?php if ($difficulty == '1') {
                     echo "selected='selected'";
                        } ?>>1</option>
                    <option value="2" <?php if ($difficulty == '2') {
                       echo "selected='selected'";
                        } ?>>2</option>
                    <option value="3" <?php if ($difficulty == '3') {
                         echo "selected='selected'";
                    } ?>>3</option>
                    <option value="4" <?php if ($difficulty == '4') {
                      echo "selected='selected'";
                       } ?>>4</option>
                    <option value="5" <?php if ($difficulty == '5') {
                         echo "selected='selected'";
                       } ?>>5</option>

                </select>
                <br>
                <button type="submit" >Edit Workout</button>
            </form>
<?php echo "<button name = 'Cancel' value='Cancel'><a href ='$returnPage'>Cancel</a></button>"; ?>

        </div>
    </body>
</html>

<?php
mysqli_close($conndb);
?>
