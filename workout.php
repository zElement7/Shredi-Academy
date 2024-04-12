<!DOCTYPE html>
<html>
<head>
    <title>Add Workout</title>
</head>
<body>

<h2>Add Workout</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="muscle_group">Muscle Group:</label>
    <select name="muscle_group" id="muscle_group">
        <option value="chest">Chest</option>
        <option value="back">Back</option>
        <option value="legs">Legs</option>
        <option value="shoulders">Shoulders</option>
        <option value="arms">Arms</option>
        <!-- Add more options as needed -->
    </select>
    <br><br>
    <label for="exercise_name">Exercise Name:</label>
    <input type="text" name="exercise_name" id="exercise_name" required>
    <br><br>
    <input type="submit" name="submit" value="Add Workout">
</form>

<?php
// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $muscle_group = sanitize_input($_POST["muscle_group"]);
    $exercise_name = sanitize_input($_POST["exercise_name"]);

    // Open the workouts file in append mode
    $file = fopen("workouts.txt", "a") or die("Unable to open file!");

    // Write the data to the file
    fwrite($file, "$muscle_group: $exercise_name\n");

    // Close the file
    fclose($file);

    echo "<p>Workout added successfully!</p>";
}

$today = date("Y-m-d");
$dayofweek = date('w', strtotime($today));

echo $dayofweek;
?>

</body>
</html>
