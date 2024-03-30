<?php
    include_once("includes/functions.php");
    
    // fetch exercises based on sorting parameter by user
    if (isset($_POST['sort']))
    {
        $sort = $_POST['sort'];
        
        if ($sort === 'muscle') $exerciseList = viewExercisesByMuscleGroup();
        else $exerciseList = viewExercisesByAlphabeticalOrder();
    }
    else
    {
        // if no sorting parameter has been selected, display the default list
        $exerciseList = viewExercises();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // retrieve form data
        $addName = $_POST["add-name"];
        $addSets = $_POST["add-sets"];
        $addReps = $_POST["add-reps"];
        $addWeight = $_POST["add-weight"];
        $addMuscleGroup = $_POST["add-muscle-group"];
        $addDifficultyLevel = $_POST["add-difficulty-level"];
        
        addExercise($addName, $addSets, $addReps, $addWeight, $addMuscleGroup, $addDifficultyLevel);
        
        header("Location: exercise.php");
        exit();
    }
?>
<!doctype html>
<html lang="en">
<head>
    <title>Exercises</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
<?php include_once("includes/nav.php"); ?>
<h1>Exercise List</h1>
<button id="add-exercise-button">Add New Exercise</button>
<div id="add-exercise-form" style="display: none;">
    <h2>Add New Exercise</h2>
    <form id="exercise-form" method="POST" action="exercise.php">
        <label for="add-name">Name:</label>
        <input type="text" id ="add-name" name="add-name" required><br>
        <label for="add-sets">Sets:</label>
        <input type="number" id ="add-sets" name="add-sets" min="1" step="1"><br>
        <label for="add-reps">Reps:</label>
        <input type="number" id ="add-reps" name="add-reps" min="1" step="1"><br>
        <label for="add-weight">Weight (lbs):</label>
        <input type="number" id ="add-weight" name="add-weight" min="1" step="1"><br>
        <label for="add-muscle-group">Muscle Group:</label>
        <select id="add-muscle-group" name="add-muscle-group" required>
            <option value="" disabled selected hidden>Select Muscle Group</option>
            <option value="Back">Back</option>
            <option value="Biceps">Biceps</option>
            <option value="Core">Core</option>
            <option value="Full Body">Full Body</option>
            <option value="Legs">Legs</option>
            <option value="Shoulders">Shoulders</option>
            <option value="Triceps">Triceps</option>
            <option value="Other">Other</option>
        </select>
        <label for="add-difficulty-level">Difficulty Level:</label>
        <select id="add-difficulty-level" name="add-difficulty-level" required>
            <option value="" disabled selected hidden>Select Difficulty Level</option>
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
        </select>
        <button type="submit">Add Exercise</button>
    </form>
</div>
<form method="POST" action="exercise.php"> <!-- change to POST after building -->
    <button type="submit" name="sort" value="muscle">Sort by Muscle Group</button>
    <button type="submit" name="sort" value="name">Sort by Name</button>
</form>
<div id="exercise-list">
    <?php
        if ($exerciseList)
        {
            echo "<ul>";
            foreach ($exerciseList as $e)
            {
                echo "<li>$e</li>";
            }
            echo "</ul>";
        }
    ?>
</div>
<script>
    document.getElementById('add-exercise-button').addEventListener('click', function() {
        document.getElementById('add-exercise-form').style.display = 'block';
    });
</script>
</body>
</html>