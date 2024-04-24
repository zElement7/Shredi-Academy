<?php
$host="localhost";
$user="root";
$password="Shr3dI-@caDemy";
$dbname="shredi_academy_project";

$conndb = new mysqli($host, $user, $password, $dbname)
	or die ('Could not connect to the database server' . mysqli_connect_error());

function cleanInputValue($con, $string) {
    $string = stripslashes($string);

    $string = htmlentities($string);
    return $con->real_escape_string($string);
}

//$conndb->close();
?>