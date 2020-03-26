<?php
// You logged in!
session_start();
define("BREAKLINE", "<br></br>");

$mysqli = mysqli_connect("localhost", "root", "", "db2");

if(!isset($_SESSION["user"])) {
    header("Location: index.php");

    exit;
} 
// If the user is not signed in, return them to the homepage. Should probably be a 401 Not Authorized page https://www.restapitutorial.com/httpstatuscodes.html
else {
    echo "Welcome " . $_SESSION["user"]["name"];
    echo BREAKLINE;
    if (isset($_SESSION["user"]["accountType"])) {
        if($_SESSION["user"]["accountType"] == "student") {
            echo "<a href='editStudentAccount.php'>Edit Account</a>";
            echo BREAKLINE;
            echo "<a href='makeNewMentor.php'>Become a Mentor</a>";
            echo BREAKLINE;
            echo "<a href='makeNewMentee.php'>Become a Mentee</a>";
            echo BREAKLINE;
            echo "<a href='viewMeetings.php'>View Meetings</a>";

        }
        else if ($_SESSION["user"]["accountType"] == "parent") {

            echo "<a href='editParentAccount.php'>Edit Account</a>";
            $pid = $_SESSION["user"]["id"];
            $sql = $mysqli->prepare('SELECT * FROM users WHERE id IN (SELECT student_id from students WHERE parent_id = ?)'); 
            $sql->bind_param('s', $pid);
            $sql->execute();
            $result = $sql->get_result();

            if($result->num_rows > 0) {
                echo BREAKLINE;
                echo "Your lovely children:";
                echo BREAKLINE;
                while($row = $result->fetch_assoc()) {
                    $sid = $row["id"];
                    $sname = $row["name"];
                    echo "<a href='editStudentAccount.php?id=$sid'>$sname</a>";
                    echo BREAKLINE;
                }
            }
        }
        else {
            echo "<a href='editAdminAccount.php'>Edit Account</a>";
            echo BREAKLINE;
            echo "<a href='viewMeetingsAdmin.php'>View Meetings</a>";
        }
    }
    // TODO
    // Actually log out here (Dump Session)
    echo BREAKLINE;
    echo "<a href='logout.php'>Log Out</a>";
}
?>
