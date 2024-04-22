<?php
    session_start();
require_once "./includes/DataBaseConnection.php";

$_SESSION['lastPage'] = "exercise.php"; //let exercise edit redirect to wanted page

//if we are editing an exercise we want to let the user
//see the same screen as when they left and have it ordered by musclegroup/name
if (isset($_SESSION['exerciseSort'])) {
    $sortByName = $_SESSION['exerciseSort'];
} else {
    $sortByName = "yes";
}
//if we clicked on the order by button change the $sortByName value
if (isset($_POST['sortAlphabetically'])) {
    $sortByName = cleanInputValue($conndb, $_POST['sortAlphabetically']);
    $_SESSION['exerciseSort'] = $sortByName;
}

//use sql query to list order of exercises
if ($sortByName == "yes") {
    //$query = "SELECT name, id, custom_exercise, exercise_type FROM exercises order by name";
    $query = "SELECT name, id, exercise_type, custom_exercise FROM exercises order by name";
} else {

    $query = "SELECT name, id, custom_exercise, exercise_type FROM exercises order by exercise_type, name";
   // $query = "SELECT name, id, exercise_type FROM exercises order by custom_exercise, name";
}


$result = $conndb->query($query);

if (!$result) {
    $message = "Invalid Query";
    echo $message;
    die('Invalid query: ' . mysql_error($conndb));
}


?>
<!doctype html>
<html lang="en">
    <head>
        <title>Exercises</title>
        
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
        <?php include_once "./includes/nav.php"; ?>
        <div class="contentWrapper">
            <h1>Exercises</h1>
            <form method="post" action="">
                <?php
                if ($sortByName == "no") {
                    echo "<button name = 'sortAlphabetically' value = 'yes'>Order Alphabetically</button>";
                } else {
                    echo "<button name = 'sortAlphabetically' value = 'no'>Order by Muscle Group</button>";
                }
                ?>
            </form>

            <div class="interactiveBoxesDiv">
                <a style="text-decoration: none;" href ="addExercise.php">
                    <div id="addExerciseBox">Add Exercise</div>
                </a>
          
                <?php
                if ($result->num_rows <= 0) {
                    echo "no results";
                }
// output data of each row
                while ($myExercises = $result->fetch_assoc()) {
             
                    //if this is a custom exercise allow the user to delete it by adding a clickable trashcan
                    // icon.  If it is a default exercise do not allow this functionaility
                    if ($sortByName == "yes") {
                        if($myExercises['custom_exercise'] == 1) {
                            echo <<<HTML
                    <div class='exerciseDiv'>
                    <form method="post" action="individualExercise.php" style="width:100%;">
                            <button class='exerciseBox' type="submit" name ="exerciseId" value='{$myExercises['id']}'> 
                            <div id='exercise{$myExercises['id']}' class = 'exerciseText'>
                                {$myExercises['name']}
                            </div>
                        </button>
                         </form>
                         <form id="deleteForm" action="deleteExercise.php" method="post">
                            <input type="hidden" name="toDelete" value={$myExercises['id']}>
                            <button type="submit" class='glyphicon glyphicon-trash'></button>     
                                </form>
                    <div>
                    HTML;
                        }
                        else {

                            echo <<<HTML
                    <div class='exerciseDiv'>
                    <form method="post" action="individualExercise.php" style="width:100%;">
                        <button class='exerciseBox' type="submit" name ="exerciseId" value='{$myExercises['id']}'> 
                            <div id='exercise {$myExercises['id']}' class = 'exerciseText'>
                                {$myExercises['name']}
                                    </div>
                        </button>
                                </form>
                               
                    <div>
                    HTML;
                        }

                        echo "</div></div>";
                    } else {
                        if ($myExercises['custom_exercise'] == true) {
                            echo <<<HTML
                    <div class='exerciseDiv'>
                    <form method="post" action="individualExercise.php" style="width:100%;">
                            <button class='exerciseBox' type="submit" name ="exerciseId" value='{$myExercises['id']}'> 
                            <div id='exercise{$myExercises['id']}' class = 'exerciseText'>
                            {$myExercises['exercise_type']} - {$myExercises['name']}
                            </div>
                               
                        </button>
                         </form>
                       <form id="deleteForm" action="deleteExercise.php" method="post">
                            <input type="hidden" name="toDelete" value={$myExercises['id']}>
                            <button type="submit" class='glyphicon glyphicon-trash'></button>
                            </form>
                    <div>
                    HTML;
                        } else {

                            echo <<<HTML
                    <div class='exerciseDiv'>
                    <form method="post" action="individualExercise.php" style="width:100%;">
                        <button class='exerciseBox' type="submit" name ="exerciseId" value='{$myExercises['id']}'> 
                            <div id='exercise {$myExercises['id']}' class = 'exerciseText'>
                            {$myExercises['exercise_type']} - {$myExercises['name']}
                                    </div>
                                 
                        </button>
                                </form>
                                <span></span>
                    <div>
                    HTML;
                        }

                        echo "</div></div>";
                    }
                }
                mysqli_close($conndb);
                ?>

            </div>
           
    </body>
</html>