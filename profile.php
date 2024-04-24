<?php
    session_start();
    include_once('includes/functions.php');
    
    // redirect to login page if not logged in
    if (!isset($_SESSION['username']))
    {
        header("Location: index.php");
        exit();
    }
    
    // get current username from session
    $username = $_SESSION['username'];
    
    // check if the form is submitted to update profile information
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $age = $_POST['age'] ?? '';
        $height = $_POST['height'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $weight = $_POST['weight'] ?? '';
        
        $updateMessage = updateUserProfile($username, $_POST['age'], $_POST['height'], $_POST['gender'], $_POST['weight']);
    }
    
    // store profile data in an array
    $profileData = getUserProfile($username);
    
    if (!$profileData)
    {
        // handle errors
        $errorMessage = "Error fetching profile data.";
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>User Profile</title>
        <link rel="stylesheet" href="./css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include_once("includes/nav.php") ?>
        <h1>Profile Page</h1>
        <div class="contentWrapper">
            <h1>User Profile</h1>
            <?php
                if (isset($successMessage)) echo "<p>" . $updateMessage . "</p>";
                if (isset($errorMessage)) echo "<p>" . $errorMessage . "</p>";
                else {
            ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <p><strong>Username: </strong><?php echo $profileData['username']; ?></p>
                    <p><label for="age">Age: </label><input type="number" id="age" name="age" value="<?php echo $profileData['age'] ?? ''; ?>"</p>
                    <p><label for="height">Height (in): </label><input type="number" id="height" name="height" value="<?php echo $profileData['height'] ?? ''; ?>"</p>
                    <p><label for="weight">Weight (lbs): </label><input type="number" id="weight" name="weight" value="<?php echo $profileData['weight'] ?? ''; ?>"</p>
                    <p><label for="gender">Gender: </label><input type="text" id="gender" name="gender" value="<?php echo $profileData['gender'] ?? ''; ?>"</p>
                    <p><input type="submit" value="Update Profile"></p>
                </form>
            <?php } ?>
        </div>
    </body>
</html>