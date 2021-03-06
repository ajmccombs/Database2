<a href='loginSuccess.php'>Return to Homepage</a>
<br/>
<?php

    session_start();
    define("BREAKLINE", "<br></br>");
    $mysqli = mysqli_connect("localhost", "root", "", "db2");

    // User needs to be an admin for this page
    if($_SESSION["user"]["accountType"] != "admin") {
        header("Location: index.php");

        exit;
    }

    $id = $_SESSION["user"]["id"];
    $sql = "SELECT * FROM meetings ORDER BY date ASC";

    $result = $mysqli->query($sql);
    if ($result->num_rows != 0) {
        echo "All Meetings";
    } else {
        echo "There are no meetings";
    }
    echo BREAKLINE;
?>

<!-- Display table only if there are meetings to populate it.-->
<?php if($result->num_rows != 0): ?>
<table border="1">
        <tr>
            <th>Meeting Name</th>
            <th>Required Mentor Level</th>
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

                echo "<td><a href='viewSingleMeeting.php?meet_id=$meet_id'\" >View</a></td>";
                echo "</tr>";

            }
        ?>

</table>
<?php endif; ?>
