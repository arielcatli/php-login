<?php
   require_once './functions.php';
   session_start();

    $login_error = null;

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	    header('Location: /app/profile.php');
    }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
       $username = htmlentities($_POST['username']);
       $password = htmlentities($_POST['password']);

//       $SQL_CHECK_USER_LOGIN = "SELECT id FROM dhvsu_app WHERE username = '$username' and password = '$password'";
       $SQL_CHECK_USER_LOGIN = "SELECT * FROM dhvsu_app.user WHERE username = '$username' and password = '$password'";
       $SQL_RESULT = $connection->query($SQL_CHECK_USER_LOGIN);

       if ($SQL_RESULT->num_rows > 0) {

           $_SESSION['loggedin'] = true;
           $_SESSION['username'] = $username;

           # TODO: record login details here.

           header('Location: /app/profile.php');
       }
       else {
           $login_error = 'Invalid email or password.';
       }
   }
?>
<?php require_once './modules/header.php' ?>
<main class="login">
    <div class="darkoverlay"></div>
    <div class="form-container">
        <img src="./assets/images/dhvsu-logo.png" alt="" class="logo">
        <form method="POST">

            <label for="username">Username</label>
            <input type="email" name="username" id="username" required/>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
<!--            <a href="#">Forgot password</a>-->

	        <?php if($login_error != null): ?>
                <p class="error">Invalid email or password.</p>
	        <?php endif; ?>

            <button type="submit">Login</button>
        </form>
    </div>
    <p class="register-link">Don't have an account yet? Sign up <a href="register.php">here</a>.</p>
</main>

<?php require_once './modules/footer.php' ?>
