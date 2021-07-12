<?php
//Log the user out, unset, and destroy the session.
//Redirect the user to the front page.
session_start();
session_unset();
session_destroy();
unset($_SESSION['username']);
header("Location: ../index");
exit();
