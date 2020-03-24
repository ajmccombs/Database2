<?php

session_start();

$LOGIN_FAIL = "<p>Your login failed please try again.</p>";
$EMAIL_MISSING = "<p>The email field was left blank.</p>";
$LOGIN_LINK = "<a href='login.php'>Login</a>";

if (isset($_POST['login_submitted'])) {
    $mysqli = mysqli_connect("localhost", "root", "", "db2");

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        //prepare a new query where we get the use with specified email
        $sql = $mysqli->prepare('SELECT * FROM users WHERE email = ?');
        $sql->bind_param('s', $email);

        //get the result of the select query
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows == 1) {
            $password = $_POST["password"];

            $sql = $mysqli->prepare('SELECT * FROM users WHERE email = ?');
            $sql->bind_param('s', $email);

            $row = $result->fetch_assoc();

            if ($row["password"] == $password) {

                $accountType = "student";
                // insert user into session to signify the user has successfully  
                unset($row["password"]);

                $sql = $mysqli->prepare('SELECT admin_id FROM admins WHERE admin_id IN (SELECT id FROM users WHERE email = ?)');
                $sql->bind_param('s', $row["email"]);
                $sql->execute();

                if ($sql->get_result()->num_rows == 1) {
                    $accountType = "admin";
                } else {

                    $sql = $mysqli->prepare('SELECT parent_id FROM parents WHERE parent_id IN (SELECT id FROM users WHERE email = ?)');
                    $sql->bind_param('s', $row["email"]);
                    $sql->execute();

                    if ($sql->get_result()->num_rows == 1) {
                        $accountType = "parent";
                    }
                }
                $_SESSION["user"] = $row;
                $_SESSION["user"]["accountType"] = $accountType;

                header("Location: loginSuccess.php");

                exit;
            }
        }
        echo $LOGIN_FAIL;
        echo $LOGIN_LINK;
    } else {
        echo $EMAIL_MISSING;
    }
} else {
    header("Location: homepage.php");

    exit;
}
