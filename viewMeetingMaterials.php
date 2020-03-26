<?php
session_start();
define("BREAKLINE", "<br></br>");
$mysqli = mysqli_connect("localhost", "root", "", "db2");

// User must be logged in to view
if (!isset($_SESSION["user"])) {
    header("Location: index.php");

    exit;
}
if(isset($_POST["meet_id"])) {
    $meet_id = $_POST["meet_id"];

    echo "Study Materials";
    echo BREAKLINE;
    $sql = $mysqli->prepare('SELECT * FROM material WHERE material_id IN (SELECT material_id FROM assign WHERE meet_id = ?)');
    $sql->bind_param('i', $meet_id);
    
    $sql->execute();
    $result = $sql->get_result();
    ?>
    <?php if ($result->num_rows != 0) : ?>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Type</th>
                <th>Url</th>
                <th>Assigned Date</th>
                <th>Note</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
    
                $url = $row["url"];
                echo "<tr>";
                echo "<td> " . $row["title"] . "</td>";
                echo "<td> " . $row["author"] . "</td>";
                echo "<td> " . $row["type"] . "</td>";
                echo "<td><a href=$url>$url</td>";
                echo "<td> " . $row["assigned_date"] . "</td>";
                echo "<td> " . $row["notes"] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php endif;
}
?>
