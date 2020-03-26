<?php

    session_start();
    define("BREAKLINE", "<br></br>");
    $mysqli = mysqli_connect("localhost", "root", "", "db2");

    // User needs to be an admin for this page
    if ($_SESSION["user"]["accountType"] != "admin") {
        header("Location: index.php");

        exit;
    }

    if (isset($_POST)) {

        $meet_id = $_POST["meet_id"];
        $title = $_POST["title"];
        $author = $_POST["author"];
        $type = $_POST["type"];
        $url = $_POST["url"];
        $date = $_POST["date"];
        $notes = $_POST["notes"];

        $sql = $mysqli->prepare('INSERT INTO material (title, author, type, url, assigned_date, notes) VALUES (?, ?, ?, ?, ?, ?)');
        $sql->bind_param('ssssss', $title, $author, $type, $url, $date, $notes);
        $sql->execute();

        $material_id = $mysqli->insert_id;

        $sql = $mysqli->prepare('INSERT INTO assign (meet_id, material_id) VALUES (?, ?)');
        $sql->bind_param('ii', $meet_id, $material_id);

        $sql->execute();
    }

    header("Location: viewMeetingsAdmin.php");
?>
