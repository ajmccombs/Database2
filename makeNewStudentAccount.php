<?php

if (isset($_POST['new_account_submitted'])) {
    $mysqli = mysqli_connect("localhost", "root", "", "db2");
    $formIsValid = true;
    $parent_id;
    // Unfortunately we need to check every case.
    // If any aren't filled out we reject them.
    if (empty($_POST["fullname"])) {
        echo "Full name is required";
        $formIsValid = false;
    }
    // TODO: this needs to be referenced with the database
    // Two students should never have the same email address
    if (empty($_POST["email"])) {
        echo "Email is required";
        $formIsValid = false;
    }
    if (empty($_POST["grade"])) {
        echo "Grade level is required";
        $formIsValid = false;
    }
    if (empty($_POST["phone"])) {
        echo "Phone is required";
        $formIsValid = false;
    }
    //Checks to see if user inputed a valid email
    if (empty($_POST["pemail"])) {
        echo "Parent email is required";
        $formIsValid = false;
    } else {
        //User entered a valid email, inserting data into database
        // 'SELECT parent_id FROM parents WHERE parent_id IN (Select id FROM users WHERE email = ?)'
        $sql = $mysqli->prepare('SELECT parent_id FROM parents WHERE parent_id IN (Select id FROM users WHERE email = ?)');
        $sql->bind_param('s', $_POST["pemail"]);
        $sql->execute();

        $result = $sql->get_result();
        $row = $result->fetch_assoc();   

        if($result->num_rows != 1) {

            echo "The parent email is not valid.";
            $formIsValid = false;

        } else {
            $parent_id = $row["parent_id"];
        }
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
        echo "<a href='createStudentAccount.php'>Try Again</a>";
        echo "<br></br>";
        echo "<a href='homepage.php'>Homepage</a>";
    } else { // Form is valid

        $fullName = $_POST['fullname'];
        $grade = $_POST["grade"];
        //$id = 694201337;
        //inserting acc into user
        $sql = $mysqli->prepare('INSERT INTO `users`(`email`, `password`, `name`, `phone`) VALUES (?,?,?,?)');
        $sql->bind_param("ssss", $_POST['email'], $_POST['password'],  $fullName,  $_POST['phone']);
        $sql->execute(); //executes insert

        $student_id = $mysqli->insert_id;

        //inserting studentid and parentid into students table
        $sql = $mysqli->prepare('INSERT INTO `students`(`student_id`, `grade`, `parent_id`) VALUES (?,?,?)');
        $sql->bind_param("sss", $student_id, $grade, $parent_id);
        $sql->execute(); //executes insert

        echo "Welcome!";
        echo "<br></br>";
        echo "<a href='homepage.php'>Homepage</a>";
    }
} else {
    header("Location: homepage.php");

    exit;
}
