<?php
    include_once('includes/functions.php');
    
    // check if login button has been pressed
    if(isset($_POST['login']))
    {
        // get username and password variables from the POST
        $username = (isset($_POST['username']) ? $_POST['username'] : "");
        $password = (isset($_POST['password']) ? $_POST['password'] : "");
        
        // store username and password variables in the session superglobal
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        
        // call function to attempt login
        $results = getUserFromDB($username, $password);
        
        // if the username and password pair match a username and password pair in the database, hide the form
        if(mysqli_num_rows($results) > 0)
        {
            $homeMessage = "Welcome to our store!"; // change top text
            $_SESSION['granted'] = true; // create session variable when logged in
        }
        else
        {
            $homeMessage = "Access Denied"; // change top text
            $_SESSION['granted'] = false; // user failed to log in
        }
    }
    
    // user is not logged in upon first opening page
    if(!isset($_SESSION['granted']))
    {
        $_SESSION['granted'] = false;
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <script src="js/script.js"></script>
    </head>
    <body>
        <?php include_once("includes/nav.php") ?>
        <?php
            // placing error messages above the form & below the nav bar
            if(isset($_POST['login']) && $_SESSION['granted'] === false && !isset($hideLoginForm))
            {
                if($username === "" || $password === "")
                    echo '<p class="warning">All fields must be filled.</p>'; // empty field fail warning
                else
                    echo '<p class="warning">Invalid Login.</p>'; // login fail warning message
            }
        ?>
        <div class="contentWrapper">
            <?php
                // change top text message once logged in
                $homeMessage = ($_SESSION['granted'] ? "Welcome to Shredi Academy!" : $homeMessage);
                echo "<h2>$homeMessage</h2>"; // display top text
                
                // if logged in, display the workout of the day
                if ($_SESSION['granted'] === true)
                {
                    echo getDailyWorkout();
                }
                
                // show login form if not logged in
                if($_SESSION['granted'] === false && !isset($hideLoginForm))
                {
                    ?>
                    <form method="POST" autocomplete="off">
                        <label>Username:<input type="text" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo $username; ?>"></label>
                        <label>Password:<input type="password" name="password" placeholder="Password"></label>
                        <div class="button-group">
                            <input type="submit" name="login" value="Log In">
                            <input type="reset" value="Reset" onclick="document.getElementsByName('username')[0].value = '';">
                        </div>
                    </form><br>
                    <h2>Don't have an account?</h2>
                    <form action="createAccount.php">
                        <div class="button-group">
                            <input type="submit" value="Create Account">
                        </div>
                    </form>
                    <?php
                }
            ?>
        </div>
    </body>
</html>