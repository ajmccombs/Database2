<a href='loginSuccess.php'>Return to Homepage</a>
<br/>
<?php

    session_start();
    define("BREAKLINE", "<br></br>");
    $mysqli = mysqli_connect("localhost", "root", "", "db2");

    // User needs to be logged in for this page
    if(!isset($_SESSION["user"])) {
        header("Location: homepage.php");

        exit;
    }



    $id = $_SESSION["user"]["id"];

    $sql = "SELECT * FROM meetings WHERE meet_id IN (SELECT meet_id FROM enroll2 WHERE mentor_id = $id)";

    $result = $mysqli->query($sql);
    if ($result->num_rows != 0) {
        echo "Meetings where you are a mentor";
    } else {
        echo "You are not mentoring in any meetings.";
    }
    echo BREAKLINE;
?>

<!-- Display table only if there are meetings to populate it.-->
<?php if($result->num_rows != 0): ?>
<table border="1">
        <tr>
            <th>Meeting Name</th>
            <th>Grade Level</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php
            while($row = $result->fetch_assoc()) {
                $meet_id = $row["meet_id"];
                $time_id = $row["time_slot_id"];
                $time_sql = "SELECT start_time, end_time FROM time_slot WHERE time_slot_id =  $time_id";
                $time_result = $mysqli->query($time_sql);
                $time_row = $time_result->fetch_assoc();

                $grade_id = $row["group_id"];
                $grade_sql = "SELECT mentor_grade_req FROM groups WHERE group_id = $grade_id";
                $grade_result = $mysqli->query($grade_sql);
                $grade_row = $grade_result->fetch_assoc();
    
                $gradelvl = $grade_row["mentor_grade_req"];

                echo "<tr>";
                echo "<td> " . $row["meet_name"] . "</td>";
                echo "<td> " . $gradelvl . "</td>";
                echo "<td> " . $row["date"] . "</td>";
                echo "<td> " . $time_row["start_time"] . "</td>";
                echo "<td> " . $time_row["end_time"] . "</td>";
                echo "<td><form method=\"post\" action=\"viewMeetingMaterials.php\">";
                echo "<input type=\"hidden\" name=\"meet_id\" value=\"$meet_id\">";
                echo "<input type=\"submit\" name=\"submit\" value=\"View Study Materials\">";
                echo "</form></td>";
                echo "</tr>";
            }
        ?>

</table>
<?php endif; ?>

<!--viewing fellow mentors-->
<?php 

    $sql = "SELECT meet_id FROM enroll2 WHERE mentor_id = $id";
    $result = $mysqli->query($sql);
    $sqlrow = $result->fetch_assoc();
    $meet_id = $sqlrow["meet_id"];
    
    $list_sql = "SELECT name, email, phone FROM users WHERE id IN
        (SELECT mentor_id FROM mentors WHERE mentor_id IN
            (SELECT mentor_id FROM enroll2 WHERE meet_id = $meet_id))";

    $list_result = $mysqli->query($list_sql);
    
    echo "Participating mentors:";
    echo BREAKLINE;

    while($list = $list_result->fetch_assoc()) {
    $list_name = $list["name"];
    $list_email = $list["email"];
    $list_phone = $list["phone"];
   
    echo "$list_name, $list_email, $list_phone";
    echo BREAKLINE;
    }

?>

<?php

    echo BREAKLINE;
    $id = $_SESSION["user"]["id"];
    $sql = "SELECT * FROM meetings WHERE meet_id IN (SELECT meet_id FROM enroll WHERE mentee_id = $id)";

    $result = $mysqli->query($sql);

    if ($result->num_rows != 0) {
        echo "Meetings where you are a mentee";
    } else {
        echo "You are not a mentee in any meetings.";
    }
    echo BREAKLINE;
?>
<?php if($result->num_rows != 0): ?>
<table border="1">
        <tr>
            <th>Meeting Name</th>
            <th>Grade Level</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php
            while($row = $result->fetch_assoc()) {
                $meet_id = $row["meet_id"];
                $time_id = $row["time_slot_id"];
                $time_sql = "SELECT start_time, end_time FROM time_slot WHERE time_slot_id =  $time_id";
                $time_result = $mysqli->query($time_sql);
                $time_row = $time_result->fetch_assoc();


                $grade_id = $row["group_id"];
                $grade_sql = "SELECT mentee_grade_req FROM groups WHERE group_id = $grade_id";
                $grade_result = $mysqli->query($grade_sql);
                $grade_row = $grade_result->fetch_assoc();
    
                $gradelvl = $grade_row["mentee_grade_req"];
                echo "<tr>";
                echo "<td> " . $row["meet_name"] . "</td>";
                echo "<td> " . $gradelvl . "</td>";
                echo "<td> " . $row["date"] . "</td>";
                echo "<td> " . $time_row["start_time"] . "</td>";
                echo "<td> " . $time_row["end_time"] . "</td>";
                echo "<td><form method=\"post\" action=\"viewMeetingMaterials.php\">";
                echo "<input type=\"hidden\" name=\"meet_id\" value=\"$meet_id\">";
                echo "<input type=\"submit\" name=\"submit\" value=\"View Study Materials\">";
                echo "</form></td>";
                echo "</tr>";
            }
        ?>

</table>
<?php endif; ?>

<!--Viewing fellow mentees-->
<?php 

    $sql = "SELECT meet_id FROM enroll WHERE mentee_id = $id";
    $result = $mysqli->query($sql);
    $sqlrow = $result->fetch_assoc();
    $meet_id = $sqlrow["meet_id"];
    
    $list_sql = "SELECT name, email, phone FROM users WHERE id IN
        (SELECT mentee_id FROM mentees WHERE mentee_id IN
            (SELECT mentee_id FROM enroll WHERE meet_id = $meet_id))";

    $list_result = $mysqli->query($list_sql);
    
    echo "Participating mentees:";
    echo BREAKLINE;

    while($list = $list_result->fetch_assoc()) {
    $list_name = $list["name"];
    $list_email = $list["email"];
    $list_phone = $list["phone"];
   
    echo "$list_name, $list_email, $list_phone";
    echo BREAKLINE;
    }

?>