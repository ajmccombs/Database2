<?php
    define("BREAKLINE", "<br></br>");
    session_start();

    // Returns the user to the homepage, used if the user isn't supposed to be here.
    // No code should execute after this function call.
    function returnToHomepage() {
        header("Location: homepage.php");

        exit;
    }

    // If the user isn't already logged in somehow
    if (!isset($_SESSION["user"])) {
        returnToHomepage();
    } else {

        // Check if the the parent's account was actually updated.
        if(isset($_POST['edit_parent_account'])) {
            $mysqli = mysqli_connect("localhost", "root", "", "db2");
            $fullname = $_SESSION["user"]["name"];
            $email = $_SESSION["user"]["email"];
            $phone = $_SESSION["user"]["phone"];
    
            if ($_POST["password"] != $_POST["passcheck"]) {
                echo "The passwords were not the same";
                echo BREAKLINE;
                echo "<a href='editParentAccount.php'>Try Again</a>";
                echo BREAKLINE;
                echo "<a href='homepage.php'>Homepage</a>";
            } else {
                if (!empty($_POST["fullname"])) {
                    $fullname = $_POST["fullname"];
                }
                if (!empty($_POST["email"])) {
                    $email = $_POST["email"];
                }
                if (!empty($_POST["phone"])) {
                    $phone = $_POST["phone"];
                }
                if (!empty($_POST["password"])) {
                    $password = $_POST["password"];
                }
                $pid = $_SESSION["user"]["id"];
        
                $sql = $mysqli->prepare("UPDATE users SET name = ?, phone = ?, email = ?, password = ? WHERE id = ?"); 
                $sql->bind_param('sssss', $fullname, $phone, $email, $password, $pid);
                
                $sql->execute();
    
                if ($sql->affected_rows == 1) {
                    $_SESSION["user"]["name"] = $fullname;
                    $_SESSION["user"]["email"] = $email;
                    $_SESSION["user"]["phone"] = $phone;
    
                    echo "You've sucessfully updated your account.";
                    echo BREAKLINE;
                    echo "<a href='homepage.php'>Homepage</a>";
                } else {
                    echo "an error has occured. The database was not successfully updated.";
                    echo BREAKLINE;
                    echo "<a href='homepage.php'>Homepage</a>";
                }
            }
        } else {
            returnToHomepage();
        }
    }
