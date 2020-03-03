<form method="post" action="makeNewStudentAccount.php">
    <label for="fname">First Name</label>
    <input type="text" placeholder="Enter First Name" name="fname"/><br/>

    <label for="lname">Last Name</label>
    <input type="text" placeholder="Enter Last Name" name="lname"/><br/>

    <label for="email">Email</label>
    <input type="text" placeholder="Enter Email" name="email"/><br/>

    <label for="phone">Phone Number</label>
    <input type="text" placeholder="Enter Phone Number" name="phone"/><br/>

    <label for="pid">Enter Parent id #</label>
    <input type="text" placeholder="Parent id #" name="pid"/><br/>    

    <label for="password">Password</label>
    <input type="password" placeholder="Enter Password" name="password"/><br/>

    <label for="password">Confirm Password</label>
    <input type="password" placeholder="Re-enter Password" name="passcheck"/><br/>

    <input type="hidden" name="new_account_submitted" value="1" />

    <input type="submit" value="Login"/>

</form>

<a href='homepage.php'>Homepage</a>