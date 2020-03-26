<?php
    session_start();
    define("BREAKLINE", "<br></br>");
    $mysqli = mysqli_connect("localhost", "root", "", "db2");

    // User needs to be an admin for this page
    if($_SESSION["user"]["accountType"] != "admin") {
        header("Location: index.php");

        exit;
    }

    $meet_id = $_GET["meet_id"];
?>


<form method="post" action="postStudyMaterials.php">
    <label for="title">Title</label>
    <input type="text" placeholder="Title" name="title" required /><br />

    <label for="author">Author</label>
    <input type="text" placeholder="author" name="author" required /><br />

    <label for="type">Type</label>
    <input type="text" placeholder="type" name="type" required /><br />

    <label for="url">Url</label>
    <input type="text" placeholder="url" name="url" required /><br />

    <label for="date">Assigned Date</label>
    <input type="date" placeholder="date" name="date" required /><br />

    <label for="notes">Notes</label>
    <input type="text" placeholder="notes" name="notes" required /><br />


    <input type="hidden" name="study_materials_submitted" value="1" />

    <input type="hidden" name="meet_id" <?php echo "value='$meet_id'";?>/>
    <input type="submit" value="Post" />

</form>