<?php
define("BREAKLINE", "<br></br>");

session_start();

if (isset($_SESSION["user"])) {

    echo $_SESSION["user"]["name"];
    echo BREAKLINE;
    echo "Email: " . $_SESSION["user"]["email"];
    echo BREAKLINE;
    echo "Phone: " . $_SESSION["user"]["phone"];
    echo BREAKLINE;
} else {
    header("Location: homepage.php");

    exit;
}
?>

<form method="post" action="updateAdminAccount.php">
    <label for="fname">Full Name</label>
    <input type="text" placeholder="Enter Full Name" name="fullname" /><br />

    <label for="email">Email</label>
    <input type="text" placeholder="Enter Email" name="email" /><br />

    <label for="phone">Phone Number</label>
    <input type="text" placeholder="Enter Phone Number" name="phone" /><br />

    <label for="password">Password</label>
    <input type="password" placeholder="Enter Password" name="password" required/><br />

    <label for="password">Confirm Password</label>
    <input type="password" placeholder="Re-enter Password" name="passcheck" required/><br />

    <input type="hidden" name="edit_admin_account" value="1" />

    <input type="submit" value="Update" />
</form>