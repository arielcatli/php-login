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
           $profile = $SQL_RESULT->fetch_assoc();
           $_SESSION['loggedin'] = true;
           $_SESSION['username'] = $username;

           $profile_id = $profile['id'];
           $now = new DateTime();
           $now->setTimezone(new DateTimeZone('Asia/Taipei'));
           $logged_in = $now->format('Y-m-d H:i:s');
           $SQL_ADD_TO_LOGIN_HISTORY = "INSERT INTO dhvsu_app.login_history (user_id, logged_in) VALUES ('$profile_id', '$logged_in')";
           $write_result = $connection->query($SQL_ADD_TO_LOGIN_HISTORY);

           if($write_result) {
	           header('Location: /app/profile.php');
           } else {
               header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
           }

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
