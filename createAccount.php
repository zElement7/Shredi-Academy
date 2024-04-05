<?php
    include_once("includes/functions.php");
    
    // if the user has submitted the form for creating an account
    if (isset($_POST['createSubmit']))
    {
        // pull values for creating an account from the POST
        $createUsername = ((isset($_POST['createUsername']) ? $_POST['createUsername'] : false));
        $createPassword = ((isset($_POST['createPassword']) ? $_POST['createPassword'] : false));
        $confirmPassword = ((isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : false));
        
        // prevents inputs that could cause a security breach
        $createUsername = htmlentities($createUsername);
        $createPassword = htmlentities($createPassword);
        $confirmPassword = htmlentities($confirmPassword);
        
        // check to see if the entered username already exists in database or not
        if (isset($createUsername)) $uniqueUsername = compareUsernameToDB($createUsername);
        
        if ($uniqueUsername) // if the username is unique
        {
            if ($createPassword === $confirmPassword) $passwordsMatch = true;
            
            // only insert into database if passwords match
            if($passwordsMatch && ($createUsername !== "") && ($createPassword !== ""))
            {
                addUserToDB($createUsername, $createPassword); // uses function to add user to database
                $accountCreated = true;  // tells the site that an account has been created
            }
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Create Account</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <script src="js/script.js"></script>
    </head>
    <body>
        <?php include_once("includes/nav.php") ?>
        <?php
            // placing error message above the form & below the nav bar
            if(isset($createUsername) && !$uniqueUsername)
            {
                // warning message for non-unique username
                echo '<p class="warning">Entered username already exists, please choose a different one.</p>';
            }
        ?>
        <div class="form-container">
            <?php if (!$accountCreated) { ?>
                <h2>Create an Account</h2>
                <form method="POST" autocomplete="off">
                    <label>Username:<input type="text" name="createUsername" placeholder="Create a Username" id="create-username"></label>
                    <label>Password:<input type="password" name="createPassword" placeholder="Create a Password" id="create-password"></label>
                    <div id="password-message1" class="form-message"></div>
                    <div id="password-message2" class="form-message"></div>
                    <label>Verify Password:<input type="password" name="confirmPassword" placeholder="Confirm Password" id="confirm-password"></label>
                    <div id="password-message3" class="form-message"></div>
                    <div class="button-group">
                        <input type="reset" value="Reset">
                        <input type="submit" name="createSubmit" value="Create Account" id="submit-button" disabled>
                    </div><br>
                    <div class="button-group">
                        <a href="."><button type="button">Return To Login</button></a>
                    </div>
                </form>
            <?php }
            else { ?>
                <h2>Account has been created!</h2><br>
                <div class="button-group">
                    <a href=".">
                        <button type="button">Return To Login</button>
                    </a>
                </div>
                <br>
            <?php } ?>
        </div>
    </body>
</html>