<?php
require_once "./includes/DataBaseConnection.php";
$query = "SELECT name FROM workouts";
$result = $conndb->query($query);

//send all existing workout names to js variable so we can make sure we 
//don't have duplicates
$existingWorkouts = array();

while ($myWorkouts = $result->fetch_assoc()) {
    $existingWorkouts[] = $myWorkouts['Name'];
}
$json = json_encode($existingWorkouts);
echo "<script> let existingWorkouts = $json; </script>";
echo"<script> console.log(existingWorkouts);</script>";

//get all of the exercises so that the user can select one
$query = "SELECT name, id FROM exercises order by name;";

$message = "";
$exerises = $conndb->query($query);
if (!$exerises) {
    $message = "Invalid Query";
    echo $message;
    die('Invalid query: ' . mysql_error($conndb));
}

// Function to sanitize input data
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

// Check if form is submitted, and that we have valid workout name
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['workout_name']) && $_POST['workout_name'] != "") {
            // Get and sanitize form data
            $muscle_group = sanitize_input($_POST["muscle_group"]);
            $workout_name = sanitize_input($_POST["workout_name"]);
            $exercisesToAdd = $_POST["exercises"];
            $daysOfWeek = $_POST["days_of_the_week"];
            $difficulty = sanitize_input($_POST["difficulty"]);
            
            //need to read daysOfweek as array
            $days = "";
            foreach($daysOfWeek as $d)
            {
                $d = sanitize_input($d);
                $days .= "$d ";
                
            }
            
            //add the workout
            $addQuery = "INSERT INTO workouts (name, day_of_the_week, muscle_group, difficulty_level)"
                    . " VALUES ('$workout_name', '$days', '$muscle_group', $difficulty);";
            
            $added = $conndb->query($addQuery);
            
            //get the newly created workout id so we can add exercises to it in workout_exercise_connection table
            $idQuery = "SELECT id FROM workouts WHERE name = '$workout_name'";
            
            $idResult = $conndb->query($idQuery);
            $id = $idResult->fetch_row()[0];

            foreach($exercisesToAdd as $e)
            {
                $e = sanitize_input($e);
                
               
                $addExerciseToWorkout = "INSERT INTO workout_exercise_connection (workoutId, exerciseId) VALUES ($id, $e);";
                $addConnection = $conndb->query($addExerciseToWorkout);
                    
            }
            
             if($added && $addConnection)
            {
                 $message = "<p>Workout added successfully!</p>";
            }
     //Start of Robsen's update 4/21/24		
			// Check if form is submitted to add/delete an exercise
			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['workout_id']) && isset($_POST['exercise_id'])) {
			$workout_id = sanitize_input($_POST['workout_id']);
			$exercise_id = sanitize_input($_POST['exercise_id']);

			// Check if adding or deleting exercise
			if (isset($_POST['add_exercise'])) {
           // Logic to add exercise to workout
           $addExerciseToWorkout = "INSERT INTO workout_exercise_connection (workoutId, exerciseId) VALUES ($workout_id, $exercise_id);";
           $addConnection = $conndb->query($addExerciseToWorkout);

           if ($addConnection) {
              echo "Exercise added successfully to workout.";
           } else {
              echo "Failed to add exercise to workout.";
           }
           } elseif (isset($_POST['delete_exercise'])) {
           // Logic to delete exercise from workout
           $deleteExerciseFromWorkout = "DELETE FROM workout_exercise_connection WHERE workoutId = $workout_id AND exerciseId = $exercise_id;";
           $deleteConnection = $conndb->query($deleteExerciseFromWorkout);

           if ($deleteConnection) {
             echo "Exercise deleted successfully from workout.";
           } else {
             echo "Failed to delete exercise from workout.";
          } 
    }
           
        }
        
     //end of Robsen's update 4/21/24


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Workout</title>
         <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
         <script>

            /**
            * Check our lists of existing exercises.  If the exercise name the user picks
            * already exists then display an error and prevent them from adding it.  
            * If the name does not exist add the new exercise.
            * @returns {undefined}
            */
            function checkIfExists()
            {
                let proposedName = document.getElementById("workout_name").value;
                let nameExists = false;
                for (let e = 0; e < existingWorkouts.length; e++)
                {
                    if (existingWorkouts[e] === proposedName)
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
            <h2>Add Workout</h2>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
               <label for="workout_name">Workout Name:</label>
               <input type="text" name="workout_name" id="workout_name" required>
               <br>
                <label for="muscle_group">Muscle Group:</label>
                <select name="muscle_group" id="muscle_group">
                    <option value="Chest">Chest</option>
                    <option value="Back">Back</option>
                    <option value="Legs">Legs</option>
                    <option value="Shoulders">Shoulders</option>
                    <option value="Arms">Arms</option>
                    <!-- Add more options as needed -->
                </select>
                <br>
                <label for="days_of_the_week[]">Days Doing Workout:</label>
                
                     <select name="days_of_the_week[]" id="days_of_the_week" multiple="multiple">
                    <option value="U">Sunday</option>
                    <option value="M">Monday</option>
                    <option value="T">Tuesday</option>
                    <option value="W">Wednesday</option>
                    <option value="H">Thursday</option>
                    <option value="F">Friday</option>
                    <option value="S">Saturday</option>
                
                </select>
                <br>
                <label for="difficulty">Difficulty:</label>
                 <select name="difficulty" id="difficulty" multiple>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                
                </select>
                
                
                <br>
               
                <br>
                <label for="exercises[]">Add Exercises:</label>

                <select name="exercises[]" id="exercises" multiple="multiple">
                    <?php
                    
                          while ($myExercises = $exerises->fetch_assoc()) {
                          echo "<option value = '{$myExercises['id']}'>{$myExercises['name']}</option>";
                       
                          }
                    
                    ?>
                    
            
                </select> 

                <br><br>
                <button type="button" onclick="checkIfExists()">Add Workout</button>
            </form>
            <button name = "Cancel" value="Cancel"><a href ="workouts.php">Cancel</a></button>
            <div id="errorMessage" class="hidden"></div>
           <?php 
           echo "<div id='message'>$message</div>";
           ?>
        </div>
    </body>
</html>