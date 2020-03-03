<?php

if (isset($_POST['new_account_submitted'])) {
    $mysqli = mysqli_connect("localhost", "root", "", "db2");
    $formIsValid = true;

    // Unfortunately we need to check every case.
    // If any aren't filled out we reject them.
    if (empty($_POST["fname"])) {
        echo "First Name is required";
        $formIsValid = false;
    }
    if (empty($_POST["lname"])) {
        echo "Last Name is required";
        $formIsValid = false;
    }

    // TODO: this needs to be referenced with the database
    // Two students should never have the same email address
    if (empty($_POST["email"])) {
        echo "Email is required";
        $formIsValid = false;
    }
    if (empty($_POST["password"]) || empty($_POST["passcheck"])) {
        echo "The password forms were not filled out";
        $formIsValid = false;
    } else if ($_POST["password"] != $_POST["passcheck"]) {
        echo "The passwords were not the same";
        $formIsValid = false;
    }

    if (!$formIsValid) {
        echo "<br></br>";
        echo "<a href='createAccount.php'>Try Again</a>";
        echo "<br></br>";
        echo "<a href='homepage.php'>Homepage</a>";
    } else { // Form is valid
        echo "Welcome!";
        echo "<br></br>";
        echo "<a href='homepage.php'>Homepage</a>";
    }
} else {
    header("Location: homepage.php");

    exit;
}
