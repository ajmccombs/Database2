<?php
define("BREAKLINE", "<br></br>");

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");

    exit;
}
?>

<form method="post" action="updateStudentAccount.php">
    <label for="fname">Full Name</label>
    <input type="text" placeholder="Enter Full Name" name="fullname" /><br />

    <label for="email">Email</label>
    <input type="text" placeholder="Enter Email" name="email" /><br />

    <label for="grade">Grade Level</label>
    <input type="text" placeholder="Enter Grade Level" name="grade" required/><br />

    <label for="phone">Phone Number</label>
    <input type="text" placeholder="Enter Phone Number" name="phone" /><br />

    <label for="password">Password</label>
    <input type="password" placeholder="Enter Password" name="password" required/><br />

    <label for="password">Confirm Password</label>
    <input type="password" placeholder="Re-enter Password" name="passcheck" required/><br />

    <input type="hidden" name="edit_student_account" value="1" />

    <input type="submit" value="Update" />
</form>