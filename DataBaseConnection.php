
<?php
$host="localhost";
$user="root";
$password="";
$dbname="test";

$conndb = new mysqli($host, $user, $password, $dbname)
	or die ('Could not connect to the database server' . mysqli_connect_error());

function cleanInputValue($con, $string) {
    
    if (get_magic_quotes_gpc()) 
    {
        $string = stripslashes($string);

    }
    $string = htmlentities($string);
    return $con->real_escape_string($string);
}

//$conndb->close();
?>


