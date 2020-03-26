Login Page

<form method="post" action="loginAction.php">

    <label for="email">Email</label>
    <input type="text" placeholder="Enter Email" name="email" required /><br />

    <label for="password">Password</label>
    <input type="password" placeholder="Enter Password" name="password" required /><br />

    <input type="hidden" name="login_submitted" value="1" />

    <input type="submit" value="Login" />

</form>

<a href='index.php'>Homepage</a>