<a href='loginSuccess.php'>Return to Homepage</a>
<br/>
<?php
session_start();
define("BREAKLINE", "<br/>");

if (!isset($_SESSION["user"])) {
    header("Location: index.php");

    exit;
}
$mysqli = mysqli_connect("localhost", "root", "", "db2");
echo "Become a Mentee";
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
        SELECT meet_id FROM enroll
        GROUP BY meet_id
        HAVING count(*) > 6)
    AND (meetings.date, time_slot_id) NOT IN (
        SELECT date, time_slot_id FROM meetings WHERE meet_id IN (
            SELECT meet_id FROM enroll WHERE mentee_id = $id)
            OR meet_id IN (
                SELECT meet_id FROM enroll2 WHERE mentor_id = $id))
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
            <th>Mentee Count</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
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

            $sql = "SELECT COUNT(mentee_id) as numMentees FROM enroll WHERE meet_id = $row[meet_id]";
            $resultNumMentees = $mysqli->query($sql);
            $numMentees = $resultNumMentees->fetch_assoc();
            $numMentees = $numMentees["numMentees"];
            echo "<td>$numMentees/6</td>";

            // single join
            echo "<td><form method=\"post\" action=\"makeNewMentee.php\">";
            echo "<input type=\"hidden\" name=\"newMentee\" value=\"" . $row["meet_id"] . "\" />";
            echo "<input type=\"submit\" name=\"submit\" value=\"Become a Mentee!\"/></form></td>";

            // join all
            echo "<td><form method=\"post\" action=\"makeNewMentee.php\">";
            echo "<input type=\"hidden\" name=\"enrollInAll\" value=\"" . $row["meet_id"] . "\" />";
            echo "<input type=\"hidden\" name=\"group_id\" value=\"" . $row["group_id"] . "\" />";
            echo "<input type=\"hidden\" name=\"meet_name\" value=\"" . $row["meet_name"] . "\" />";
            echo "<input type=\"submit\" name=\"submit\" value=\"Join All Future Meetings!\"/></form>";
            echo "</td></tr>";
        }
        ?>
        
    </table>
<?php endif; ?>

<?php
// Single Join
if(isset($_POST["newMentee"])) {
    $meet_id = $_POST["newMentee"];

    $sql = "INSERT INTO mentees VALUES ($id)";
    $result = $mysqli->query($sql);

    $sql = "INSERT INTO enroll VALUES ($meet_id, $id)";
    $result = $mysqli->query($sql);

    if(!$mysqli->query($sql)) {
        echo mysqli_error($mysqli);  
    }

    header("Refresh:0");
}
// Join all
if(isset($_POST["enrollInAll"])) {
    $meet_id = $_POST["enrollInAll"];
    $group_id = $_POST["group_id"];
    $meet_name = $_POST["meet_name"];

    $sql = "INSERT INTO mentees VALUES ($id)";
    $result = $mysqli->query($sql);

    $sql = 
    "INSERT INTO enroll(meet_id, mentee_id)
        SELECT meet_id, $id FROM meetings WHERE group_id = $group_id
        AND meet_name = '$meet_name'
    ";

    if(!$mysqli->query($sql)) {
        echo mysqli_error($mysqli);  
    }
    header("Refresh:0");
}
?>