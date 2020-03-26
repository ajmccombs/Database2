<form method="post" action="makeNewStudentAccount.php">
    <label for="fullname">Full Name</label>
    <input type="text" placeholder="Enter Full Name" name="fullname" required /><br />

    <label for="email">Email</label>
    <input type="text" placeholder="Enter Email" name="email" required /><br />

    <label for="phone">Phone Number</label>
    <input type="text" placeholder="Enter Phone Number" name="phone" required /><br />

    <label for="pemail">Parent Email</label>
    <input type="text" placeholder="Parent Email" name="pemail" required /><br />

    <label for="grade">Grade Level</label>
    <input type="text" placeholder="Grade" name="grade" required /><br />

    <label for="password">Password</label>
    <input type="password" placeholder="Enter Password" name="password" required /><br />

    <label for="password">Confirm Password</label>
    <input type="password" placeholder="Re-enter Password" name="passcheck" required /><br />

    <input type="hidden" name="new_account_submitted" value="1" />

    <input type="submit" value="Login" />

</form>

<a href='index.php'>Homepage</a>