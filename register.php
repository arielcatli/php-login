<?php
    require_once './functions.php';
    session_start();

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('Location: /app/profile.php');
        exit();
    }

//    Handler for new profile
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        extract($_POST, EXTR_PREFIX_ALL, 'post');

        $post_first_name = ucwords(addslashes(htmlentities($post_first_name)));
        $post_middle_name = ucwords(addslashes(htmlentities($post_middle_name)));
        $post_last_name = ucwords(addslashes(htmlentities($post_last_name)));
        $post_address = addslashes(htmlentities($post_address));
        $post_barangay = addslashes(htmlentities($post_barangay));
        $post_city = addslashes(htmlentities($post_city));
        $post_province = addslashes(htmlentities($post_province));
        $post_zip = addslashes(htmlentities($post_zip));
        $post_gender = addslashes(htmlentities($post_gender));
        $post_phone = addslashes(htmlentities($post_phone));

        $post_new_password = addslashes(htmlentities(($post_new_password)));
        $post_confirm_password = addslashes(htmlentities(($post_confirm_password)));

        $SQL_NEW_PROFILE = "INSERT into dhvsu_app.user (username, password, first_name, middle_name, last_name, address, barangay, city, province, zip, gender, phone, role) VALUES ('$post_username', '$post_new_password', '$post_first_name', '$post_middle_name', '$post_last_name', '$post_address', '$post_barangay', '$post_city', '$post_province', '$post_zip', '$post_gender', '$post_phone', 'external')";

        $SQL_CHECK_EXIST_PROFILE = "SELECT * FROM dhvsu_app.user WHERE username = '$post_username'";

        $check_exist = $connection->query($SQL_CHECK_EXIST_PROFILE);

        if($check_exist->num_rows > 0) {
            $error = 'Account already exists.';
        } else {
	        if($post_new_password != $post_confirm_password) {
		        $error = 'Password mismatch.';
	        }
	        else {
		        $result = $connection->query($SQL_NEW_PROFILE);

		        if($result) {
			        header('Location: /app');
		        } else {
			        $error = 'Server problem';
			        print($connection->error);
		        }
	        }
        }


    }
?>


<?php require_once './modules/header.php' ?>

<main class="register">
	<div class="registration-form-container">
		<form action="" method="POST">
			<div class="form-introduction">
				<div class="logo">
					<a href="/app"><img src="./assets/images/dhvsu-logo.png" alt="DHVSU logo" /></a>
					<h1>Registration</h1>
				</div>
				<p class="description">Fill out the form for your registration. Make sure your email address is valid.</p>
                <p class="error"><?=isset($error) ? $error : ""?></p>
			</div>
			<div class="form-grid">
				<label for="username">Email Address</label>
				<input type="email" name="username" id="username" required>
                <label for="new_password">Password</label>
                <input type="password" name="new_password" id="new_password" required>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" id="first_name" required>
				<label for="middle_name">Middle Name</label>
				<input type="text" name="middle_name" id="middle_name" required>
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" id="last_name" required>
				<label for="gender">Gender</label>
				<select name="gender" id="gender" required>
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>
				<label for="address">Address</label>
				<input type="text" name="address" id="address">
				<label for="barangay">Barangay</label>
				<input type="text" name="barangay" id="barangay">
				<label for="city">Municipality/City</label>
				<input type="text" name="city" id="city">
				<label for="province">Province</label>
				<input type="text" name="province" id="province">
				<label for="zip">ZIP</label>
				<input type="text" name="zip" id="zip">
				<label for="phone">Mobile Number</label>
				<input type="text" name="phone" id="phone">
			</div>
            <button type="submit">Register</button>
        </form>
	</div>
</main>

<?php require_once './modules/footer.php' ?>
