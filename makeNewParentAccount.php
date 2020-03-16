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
        echo "Email is required <br></br>";
        $formIsValid = false;
    }
    if (empty($_POST["phone"])) {
        echo "Phone is required <br></br>";
        $formIsValid = false;
    }
    if (empty($_POST["password"]) || empty($_POST["passcheck"])) {
        echo "The password forms were not filled out <br></br>";
        $formIsValid = false;
    } else if ($_POST["password"] != $_POST["passcheck"]) {
        echo "The passwords were not the same <br></br>";
        $formIsValid = false;
    }

    if (!$formIsValid) {
        echo "<br></br>";
        echo "<a href='createParentAccount.php'>Try Again</a>";
        echo "<br></br>";
        echo "<a href='homepage.php'>Homepage</a>";
    } else { // Form is valid
        echo "Welcome!";
        echo "<br></br>";
        echo "<a href='homepage.php'>Homepage</a>";

        $fullName = $_POST['fname'] . " " . $_POST['lname'];
        //$id = 694201337;
        //inserting acc into database
        $sql = $mysqli->prepare('INSERT INTO `users`(`email`, `password`, `name`, `phone`) VALUES (?,?,?,?)');
        
        $sql->bind_param("ssss", $_POST['email'], $_POST['password'],  $fullName,  $_POST['phone']);

        $sql->execute(); //executes insert

        //inserting parent id into parent table
        $parent_id = $mysqli->insert_id; 

        $sql = $mysqli->prepare('INSERT INTO `parents`(`parent_id`) VALUES (?)'); 

        $sql->bind_param("s", $parent_id);

        $sql->execute();
    }
} else {
    header("Location: homepage.php");

    exit;
}

?>