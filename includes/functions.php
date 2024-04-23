<?php
    // start session for all pages that include this file
    session_start();
    
    /* Instantiate Global Variables */
    $homeMessage = "Welcome"; // default home message
    $currentDay = date('l'); // stores the current day of the week
    
    // default values for whether an account has been created or not, the passwords match, and if the username is unique
    $accountCreated = $passwordsMatch = $uniqueUsername = false;
    /* -------------------------------------------- */
    
    // secures inputs from user
    function cleanInputValue($con, $string)
    {
        $string = stripslashes($string);
        $string = htmlentities($string);
        
        return $con->real_escape_string($string);
    }
    
    // adds a new custom exercise to the table in the database with specified values for each column
    function addExercise($n, $s, $r, $w, $mg, $dl)
    {
        $connect = connectToDB();
        $sql = "INSERT INTO exercises (name, reps, sets, weight, muscle_group, difficulty_level, custom) VALUES ('$n', '$r', '$s', '$w', '$mg', '$dl', 1);";
        mysqli_query($connect, $sql);
        
        return mysqli_close($connect);
    }
    
    // updates a selected exercise -- the column values are from where the user makes the edits on the page
    function updateExercise($e, $r, $s, $w)
    {
        $connect = connectToDB();
        $sql = "UPDATE exercises SET reps = '$r', sets='$s', weight='$w' WHERE id='$e';";
        mysqli_query($connect, $sql);
        
        return mysqli_close($connect);
    }
    
    // deletes a selected exercise from the database -- the id is grabbed when the user selects the exercise they want to delete
    function deleteExercise($e)
    {
        $connect = connectToDB();
        $sql = "DELETE FROM exercises WHERE id='$e';";
        mysqli_query($connect, $sql);
        
        return mysqli_close($connect);
    }
    
    function getDailyWorkout()
    {
        // get the current day of the week in an index (0 for Sunday through 6 for Saturday)
        $currentDayIndex = date('w');
        
        // convert the current day index to the corresponding letter
        $daysOfWeek = array('U', 'M', 'T', 'W', 'H', 'F', 'S');
        $currentDayLetter = $daysOfWeek[$currentDayIndex];
        
        // prepare and execute the query to fetch workouts for the current day
        $connect = connectToDB();
        $sql = "SELECT * FROM workouts WHERE day_of_the_week LIKE '%$currentDayLetter%';";
        $result = mysqli_query($connect, $sql);
        
        // check if query executed successfully
        if (!$result)
        {
            // handle query errors
            echo "Error: " . mysqli_error($connect);
            mysqli_close($connect);
            return "Error: Unable to fetch workout information.";
        }
        
        $output = ""; // initiates an empty string to store the daily workout information that will be returned
        
        if (mysqli_num_rows($result) > 0)
        {
            $output .= "Workout for today:\n";
            
            // append each workout to the output string
            while ($row = mysqli_fetch_assoc($result))
            {
                $output .= "Exercise: {$row['exercise']}, Muscle Group: {$row['muscle_group']}, Difficulty Level: {$row['difficulty_level']}\n";
                
                $output .= "<a href='individualWorkout.php?workoutId={$row['id']}'>View Workout</a><br>";
            }
        }
        else
        {
            $output .= "No workout assigned for today.\n";
        }
        
        mysqli_close($connect);
        return $output;
    }
    
    // gets individual workout name from the id in the database
    function getWorkoutName($id)
    {
        $connect = connectToDB();
        $sql = "SELECT name FROM workouts WHERE id='$id' LIMIT 1;";
        $result = mysqli_query($connect, $sql);
        
        $row = mysqli_fetch_assoc($result);
        
        mysqli_close($connect);
        return $row['name'];
    }
    
    // gets individual exercise name from the id in the database
    function getExerciseName($id)
    {
        $connect = connectToDB();
        $sql = "SELECT name FROM exercises WHERE id='$id' LIMIT 1;";
        $result = mysqli_query($connect, $sql);
        
        $row = mysqli_fetch_assoc($result);
        
        mysqli_close($connect);
        return $row['name'];
    }
    
    // displays all exercises in the table ordered by the muscle group from most to least in a category
    function viewExercisesMuscleGroup()
    {
        $connect = connectToDB();
        $sql = "SELECT * FROM exercises ORDER BY exercise_type DESC;";
        $results = mysqli_query($connect, $sql);
        
        if(!mysqli_num_rows($results))
        {
            return false;
        }
        
        while($exercisesArray = mysqli_fetch_array($results, MYSQLI_ASSOC))
        {
            $return[] = $exercisesArray['name'];
        }
        mysqli_close($connect);
        
        return $return;
    }
    
    // displays all exercises in the table in alphabetical order
    function viewExercisesAlphabetical()
    {
        $connect = connectToDB();
        $sql = "SELECT * FROM exercises ORDER BY name;";
        $results = mysqli_query($connect, $sql);
        
        if(!mysqli_num_rows($results))
        {
            return false;
        }
        
        while($exercisesArray = mysqli_fetch_array($results, MYSQLI_ASSOC))
        {
            $return[] = $exercisesArray['name'];
        }
        mysqli_close($connect);
        
        return $return;
    }
    
    // gets the username of currently logged-in user -- NEEDS TO BE FINISHED
    function getCurrentUsername()
    {
        $connect = connectToDB();
        $sql = "SELECT username FROM users;";
        $results = mysqli_query($connect, $sql);
        
        mysqli_close($connect);
        return $results;
    }
    
    // used to log in to the site -- compares username and password to sets in the database
    function getUserFromDB($u, $p)
    {
        // convert input password to hashed form to be able to check
        $p = hashInput($p);
        
        $connect = connectToDB();
        $sql = "SELECT * FROM users WHERE BINARY username='$u' and BINARY password='$p';";
        $results = mysqli_query($connect, $sql);
        
        mysqli_close($connect);
        return $results;
    }
    
    // adds new user to database
    function addUserToDB($u, $p)
    {
        $connect = connectToDB();
        
        // more security for inputs
        $u = mysqli_real_escape_string($connect, $u);
        $p = mysqli_real_escape_string($connect, $p);
        
        // hash input before plugging into query
        $p = hashInput($p);
        
        $connect = connectToDB();
        $sql = 'INSERT INTO users (username, password) VALUES ("'.$u.'","'. $p.'");';
        mysqli_query($connect, $sql);
        
        // no values need to be returned, so we just close the connection and function ends
        return mysqli_close($connect);
    }
    
    // compare new username to existing values in database when creating an account to avoid duplicates
    function compareUsernameToDB($u)
    {
        $connect = connectToDB();
        $sql = "SELECT * FROM users WHERE username='$u';";
        $results = mysqli_query($connect, $sql);
        
        // check if any rows are returned
        if(mysqli_num_rows($results) == 0) $uniqueUsername = true;
        else $uniqueUsername = false;
        
        mysqli_close($connect);
        return $uniqueUsername;
    }
    
    // securely hashes the input value **DO NOT EDIT**
    function hashInput($p)
    {
        $hash1 = 'ipoaiewnekljnadsqkljnxoixzcvuoizxlad';
        $hash2 = 'wqenaklsjdlkjzvxdoimsadlkfoiqalksfno';
        
        $p = $hash1.$p.$hash2;
        $p2 = $hash1.$p.$p.$hash2;
        
        $salt1 = hash('sha512', $p);
        $salt2 = hash('sha512', $p2);
        
        $hashEnd = $salt1.$p.$salt2;
        
        return hash('sha512', $hashEnd);
    }
    
    /* DATABASE CONNECTION INFORMATION AND FUNCTION */
        // define constant connection variables
        const HOST = 'localhost';
        const USER = 'root';
        const PASS = 'Shr3dI-@caDemy';
        const DB = 'shredi_academy_project';
        
        // connect to database
        function connectToDB()
        {
            return mysqli_connect(HOST, USER, PASS, DB);
        }
    /* -------------------------------------------- */
?>