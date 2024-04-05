<?php
    session_start();
    session_destroy();
    header('location: .'); // returns user to login page upon logging out
?>