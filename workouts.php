<?php
    session_start();
    require_once "./includes/DataBaseConnection.php";
    include_once('includes/functions.php');
    loginRedirect();

// Check if workout deletion is requested
if(isset($_POST['delete_workout']) && isset($_POST['workout_id'])) {
    $workoutId = $_POST['workout_id'];

    // Prepare and execute deletion query
    $deleteQuery = "DELETE FROM workouts WHERE id = ?";
    $stmt = $conndb->prepare($deleteQuery);
    $stmt->bind_param("i", $workoutId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Workout deleted successfully
        $_SESSION['success_message'] = "Workout deleted successfully.";
    } else {
        // Failed to delete workout
        $_SESSION['error_message'] = "Failed to delete workout.";
    }

    // Close statement
    $stmt->close();
}

$query = "SELECT id, name, day_of_the_week, muscle_group, difficulty_level FROM workouts ORDER BY day_of_the_week, name";
$result = $conndb->query($query);

if (!$result) {
    die('Invalid query: ' . mysqli_error($conndb));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <a href="workout.php" style="text-decoration: none;">
            <div id="addExerciseBox">Add Workout</div>
        </a>

        <?php
        if ($result->num_rows <= 0) {
            echo "No workouts found.";
        } else {
            while ($myWorkouts = $result->fetch_assoc()) {
                ?>
                <div class='exerciseDiv'>
                    <form method="get" action="individualWorkout.php" style="width:90%;">
                        <button class='workoutBox' type="submit" name="workoutId" value='<?php echo $myWorkouts['id']; ?>'>
                            <div id='workout<?php echo $myWorkouts['id']; ?>' class='workoutText'>
                                <?php echo $myWorkouts['name']; ?>
                            </div>
                            <div class='workoutDetails'>
                                <?php echo $myWorkouts['day_of_the_week'] . ' ' . $myWorkouts['muscle_group']; ?>
                                Difficulty Level: <?php echo $myWorkouts['difficulty_level']; ?>
                            </div>
                        </button>
                    </form>
                    <form class="deleteForm trashForm"  action="" method="post">
                        <input type="hidden" name="workout_id" value="<?php echo $myWorkouts['id']; ?>">
                        <button type="submit" name = "delete_workout" class='glyphicon glyphicon-trash'></button>
                    </form>
                </div>
                <?php
            }
        }
        mysqli_close($conndb);
        ?>
    </div>
</div>
</body>
</html>
