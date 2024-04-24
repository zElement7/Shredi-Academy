<?php
    /* Instantiate Global Variables */
    $homeMessage = "Welcome"; // default home message
    $currentDay = date('l'); // stores the current day of the week
    
    // default values for whether an account has been created or not, the passwords match, and if the username is unique
    $accountCreated = $passwordsMatch = $uniqueUsername = false;
    
    // gets all workouts that are tied to the current day and displays them on the home page
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
            $output .= "<h2>Workout for today:</h2>\n";
            
            // append each workout to the output string
            while ($row = mysqli_fetch_assoc($result))
            {
                $difficultyColor = 'yellow';
                if($row['difficulty_level'] == 5)
                {
                    $difficultyColor = 'red';
                }
                else if($row['difficulty_level'] == 1)
                {
                    $difficultyColor = 'green';
                }

                $output .= "<div class = 'workoutGroup'><div class = 'workoutHome'> Workout: {$row['name']}</div> <div class = 'workoutInfoHome'>Muscle Group: {$row['muscle_group']} </div> <div class = 'workoutInfoHome'>Difficulty Level: <span style = 'color: {$difficultyColor};'>{$row['difficulty_level']}</span></div>\n";
                
                $output .= "<a href='individualWorkout.php?workoutId={$row['id']}'>View Workout</a><br></br></div>";
            }
        }
        else
        {
            $output .= "No workout assigned for today.\n";
        }
        
        mysqli_close($connect);
        return $output;
    }
    
    // gets the profile information of the currently logged-in user
    function getUserProfile($u)
    {
        $connect = connectToDB();
        $sql = "SELECT * FROM user_info WHERE username='$u';";
        $result = mysqli_query($connect, $sql);
        
        if (!$result)
        {
            // handle query error
            return false;
        }
        else
        {
            $profileData = mysqli_fetch_assoc($result);
            mysqli_close($connect);
            return $profileData;
        }
    }
    
    // updates the user profile and returns a message saying success or error
    function updateUserProfile($u, $a, $h, $g, $w)
    {
        $connect = connectToDB();
        $sql = "UPDATE user_info SET age='$a', height='$h', gender='$g', weight='$w' WHERE username='$u';";
        $result = mysqli_query($connect, $sql);
        
        if ($result)
        {
            $output = "Profile updated successfully!";
        }
        else
        {
            $output = "Error:" . mysqli_error($connect);
        }
        
        mysqli_close($connect);
        return $output;
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
    
    // checks if a page is the currently active page
    function isCurrentPage($pageName)
    {
        return (baseName($_SERVER['PHP_SELF']) == $pageName);
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