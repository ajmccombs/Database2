<?php
// You logged in!
session_start();

if(isset($_SESSION["user"])) {
    echo "Welcome " . $_SESSION["user"]["name"];
} 
// If the user is not signed in, return them to the homepage. Should probably be a 401 Not Authorized page https://www.restapitutorial.com/httpstatuscodes.html
else {
    header("Location: homepage.php");

    exit;
}
?>

You logged in!<br></br>

<a href='homepage.php'>Homepage</a>