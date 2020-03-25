<?php
// You logged in!
session_start();
define("BREAKLINE", "<br></br>");

if(!isset($_SESSION["user"])) {
    header("Location: homepage.php");

    exit;
} 
// If the user is not signed in, return them to the homepage. Should probably be a 401 Not Authorized page https://www.restapitutorial.com/httpstatuscodes.html
else {
    echo "Welcome " . $_SESSION["user"]["name"];
    echo BREAKLINE;
    if (isset($_SESSION["user"]["accountType"])) {
        if($_SESSION["user"]["accountType"] == "student") {
            echo "<a href='editStudentAccount.php'>Edit Account</a>";
        }
        else if ($_SESSION["user"]["accountType"] == "parent") {
            echo "<a href='editParentAccount.php'>Edit Account</a>";
        }
        else {
            echo "<a href='editParentAccount.php'>Edit Account</a>";
        }
    }
    echo BREAKLINE;
    echo "<a href='homepage.php'>Homepage</a>";
}
?>
