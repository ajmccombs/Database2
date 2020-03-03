<?php
$LOGIN_FAIL = "<p>Your login failed please try again.</p>";
$EMAIL_MISSING = "<p>The email field was left blank.</p>";
$LOGIN_LINK = "<a href='login.php'>Login</a>";

if (isset($_POST['login_submitted'])) {
    $mysqli = mysqli_connect("localhost", "root", "", "db2");

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $success = false;
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
                $success = true;
            }
        }
        if ($success) {
            header("Location: loginSuccess.php");

            exit;
        } else {
            echo $LOGIN_FAIL;
            echo $LOGIN_LINK;
        }
    } else {
        echo $EMAIL_MISSING;
    }
}
else {
    header("Location: homepage.php");

    exit;
}

?>
