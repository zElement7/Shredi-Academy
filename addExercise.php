<?php
require_once "DataBaseConnection.php";
$query = "SELECT name FROM exercises";

$result = $conndb->query($query);

if (!$result) {
    $message = "Whole query " . $search;
    echo $message;
    die('Invalid query: ' . mysql_error($conndb));
}
$existingExercises = array();
while ($myExercises = $result->fetch_assoc()) {
    $existingExercises[] = $myExercises['name'];
}
$json = json_encode($existingExercises);
echo "<script> let existingExercises = $json; </script>";

if (isset($_POST['newName']) && $_POST['newName'] != "") {
    $newName = cleanInputValue($conndb, $_POST['newName']);
    $muscleGroup = cleanInputValue($conndb, $_POST['muscleGroup']);
    $reps = cleanInputValue($conndb, $_POST['reps']);
    $sets = cleanInputValue($conndb, $_POST['sets']);
    $weight = cleanInputValue($conndb, $_POST['weight']);

    $updateQuery = "INSERT INTO exercises (name, exercise_type, reps, sets, weight) VALUES('$newName'"
            . ",'$muscleGroup', '$reps', '$sets', '$weight')";
    $success = $conndb->query($updateQuery);
    header("Location:exercise.php");

    if ($success == false) {
        $failmess = "Whole query " . $insert . "<br>";
        echo $failmess;
        print('Invalid query: ' . mysqli_error($con) . "<br>");
    } else {
        echo "Exercise added<br>";
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Add Exercise</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>

            function checkIfExists()
            {
                let proposedName = document.getElementById("newName").value;
                let nameExists = false;
                for (let e = 0; e < existingExercises.length; e++)
                {
                    if (existingExercises[e] === proposedName)
                    {
                        nameExists = true;
                    }
                }

                if (nameExists === false)
                {
                    //post it
                    form = document.forms[0]; //assuming only form.
                    form.submit();
                }
                else
                {
                    //show an error
                    document.getElementById("errorMessage").innerText = "That exercise name already exists";
                    document.getElementById("errorMessage").className = "text-danger";
                    console.log("printed error");
                }

            }

        </script>
    </head>
    <body>
        <div class="container-fluid text-center w-100">
            <h1>Add Exercise</h1>

            <form id = "addExerciseForm" method="POST" action="">
                <label for="newName">Name:</label>
                <input type="text" id="newName" name="newName">
                <div id="errorMessage" class="hidden"></div>
                <br>
                <label for="newName">Muscle Group:</label>
                <select type="dropdown" id="muscleGroup" name="muscleGroup">
                    <option value="Abs">Abs</option>
                    <option value="Back">Back</option>
                    <option value="Biceps">Biceps</option>
                    <option value="Forearms">Forearms</option>
                    <option value="Full Body">Full Body</option>
                    <option value="Legs">Legs</option>
                    <option value="Shoulders">Shoulders</option>
                    <option value="Triceps">Triceps</option>
                </select>
                <br>
                <label for="sets">Sets:</label>
                <input type="number" id="sets" name="sets">
                <br>
                <label for="reps">Reps:</label>
                <input type="number" id="reps" name="reps">
                <br>
                <label for="weight">Weight:</label>
                <input type="number" id="weight" name="weight">
                <br>
                <button type="button" onclick="checkIfExists()">Add Exercise</button>
                <button name = "Cancel" value="Cancel"><a href ="exercise.php">Cancel</a></button>
            </form>

        </div>

    </body>
</html>
<?php
mysqli_close($conndb);
?>

