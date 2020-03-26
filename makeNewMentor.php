<a href='loginSuccess.php'>Return to Homepage</a>
<br/>
<?php
session_start();
define("BREAKLINE", "<br/>");

if (!isset($_SESSION["user"])) {
    header("Location: homepage.php");

    exit;
}
$mysqli = mysqli_connect("localhost", "root", "", "db2");
echo "Become a Mentor";
echo BREAKLINE;

$id = $_SESSION["user"]["id"];
$sql = "SELECT grade FROM students WHERE student_id = $id";
$result = $mysqli->query($sql);
$result = $result->fetch_assoc();
$grade = $result["grade"];
$date = date('Ymd');


$sql = "SELECT * FROM meetings WHERE group_id IN
(SELECT group_id FROM groups
    WHERE mentee_grade_req <= $grade)
    AND date NOT IN (
        SELECT date FROM meetings
        WHERE meet_id in (
                SELECT meet_id FROM enroll2
                WHERE mentor_id = $id))
    AND meet_id NOT IN (
        SELECT meet_id FROM enroll2
        GROUP BY meet_id
        HAVING count(*) > 2)
    AND DATEDIFF(meetings.date, $date) > 3";

$result = $mysqli->query($sql);
echo BREAKLINE;
if ($result->num_rows != 0) {
    echo "Open meetings to sign up for";
} else {
    echo "There are no open meetings at this time";
}
echo BREAKLINE;
?>

<?php if ($result->num_rows != 0) : ?>
    <table border="1">
        <tr>
            <th>Meeting Name</th>
            <th>Grade Level</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Mentor Count</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
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

            $sql = "SELECT COUNT(mentor_id) as numMentors FROM enroll2 WHERE meet_id = $row[meet_id]";
            $resultNumMentors = $mysqli->query($sql);
            $numMentors = $resultNumMentors->fetch_assoc();
            $numMentors = $numMentors["numMentors"];
            echo "<td>$numMentors/3</td>";

            
            echo "<td><form method=\"post\" action=\"makeNewMentor.php\">";
            echo "<input type=\"hidden\" name=\"newMentor\" value=\"" . $row["meet_id"] . "\" />";
            echo "<input type=\"submit\" name=\"submit\" value=\"Become a Mentor!\"/></form></td>";
            echo "</tr>";
        }
        ?>

    </table>
<?php endif; ?>

<?php

if(isset($_POST["newMentor"])) {
    $meet_id = $_POST["newMentor"];

    $sql = "INSERT INTO mentors VALUES ($id)";
    $result = $mysqli->query($sql);

    $sql = "INSERT INTO enroll2 VALUES ($meet_id, $id)";
    $result = $mysqli->query($sql);

    header("Refresh:0");
}
?>