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
                $time_id = $row["time_slot_id"];
                $time_sql = "SELECT start_time, end_time FROM time_slot WHERE time_slot_id =  $time_id";
                $time_result = $mysqli->query($time_sql);
                $time_row = $time_result->fetch_assoc();

                echo "<tr>";
                echo "<td> " . $row["meet_name"] . "</td>";
                echo "<td> " . $row["group_id"] . "</td>";
                echo "<td> " . $row["date"] . "</td>";
                echo "<td> " . $time_row["start_time"] . "</td>";
                echo "<td> " . $time_row["end_time"] . "</td>";
                echo "</tr>";

            }
        ?>

</table>
<?php endif; ?>
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
                $time_id = $row["time_slot_id"];
                $time_sql = "SELECT start_time, end_time FROM time_slot WHERE time_slot_id =  $time_id";
                $time_result = $mysqli->query($time_sql);
                $time_row = $time_result->fetch_assoc();

                echo "<tr>";
                echo "<td> " . $row["meet_name"] . "</td>";
                echo "<td> " . $row["group_id"] . "</td>";
                echo "<td> " . $row["date"] . "</td>";
                echo "<td> " . $time_row["start_time"] . "</td>";
                echo "<td> " . $time_row["end_time"] . "</td>";
                echo "</tr>";
            }
        ?>

</table>
<?php endif; ?>
