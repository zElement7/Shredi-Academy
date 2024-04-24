<?php
    include_once('functions.php');
?>
<nav>
    <ul>
        <?php
            // index.php appears as "Home" when logged in and appears as "Log In" when not logged in
            echo ($_SESSION['granted'] ? '<li'.(isCurrentPage('index.php') ? ' class="active"' : '').'><a href=".">Home</li>' : '<li'.(isCurrentPage('index.php') ? ' class="active"' : '').'><a href=".">Log In</a></li>');
            
            // add not clickable "workout name" or "edit workout" tab to nav bar after "workouts" if it is the currently loaded page
            echo ($_SESSION['granted'] ? '<li'.(isCurrentPage('workouts.php') ? ' class="active"' : '').'><a href="./workouts.php">Workouts</a></li>' : '');
            if(isCurrentPage('individualWorkout.php')) echo '<li class="active"><a>'.getWorkoutName($_GET['workoutId']).'</a></li>';
            if(isCurrentPage('workout.php')) echo '<li class="active"><a>New Workout</a></li>';
            
            // add not clickable "exercise name" or "edit exercise" tab to nav bar after "exercises" if it is the currently loaded page
            echo ($_SESSION['granted'] ? '<li'.(isCurrentPage('exercise.php') ? ' class="active"' : '').'><a href="./exercise.php">Exercises</a></li>' : '');
            if(isCurrentPage('individualExercise.php')) echo '<li class="active"><a>'.getExerciseName($_POST['exerciseId']).'</a></li>';
            if(isCurrentPage('addExercise.php')) echo '<li class="active"><a>New Exercise</a></li>';
            
            echo ($_SESSION['granted'] ? '<li'.(isCurrentPage('progress.php') ? ' class="active"' : '').'><a href="./progress.php">Progress</a></li>' : '');
            echo ($_SESSION['granted'] ? '<li'.(isCurrentPage('profile.php') ? ' class="active"' : '').'><a href="./profile.php">Profile</a></li>' : '');
            echo ($_SESSION['granted'] ? '<li><a href="./logout.php">Log Out</a></li>' : '');
            
            // add "Create Account" to nav bar if it is the currently loaded page, it cannot be clicked and is always located at the end of the nav bar
            if(isCurrentPage('createAccount.php')) echo '<li class="active"><a>Create Account</a></li>';
        ?>
    </ul>
</nav>