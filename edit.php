<?php
    require_once './functions.php';
    session_start();

    if(!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: /app');
    }

//    Load profile
    $username = $_SESSION['username'];
    $SQL_GET_PROFILE = "SELECT * FROM dhvsu_app.user WHERE username = '$username'";
    $result = $connection->query($SQL_GET_PROFILE);

    if($result->num_rows > 0) {
        $profile = $result->fetch_assoc();
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    }


//    Handler for saving edits in profile
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        extract($_POST, EXTR_PREFIX_ALL, 'post');

        $post_first_name = addslashes(htmlentities($post_first_name));
        $post_middle_name = addslashes(htmlentities($post_middle_name));
        $post_last_name = addslashes(htmlentities($post_last_name));
        $post_address = addslashes(htmlentities($post_address));
        $post_barangay = addslashes(htmlentities($post_barangay));
        $post_city = addslashes(htmlentities($post_city));
        $post_province = addslashes(htmlentities($post_province));
        $post_zip = addslashes(htmlentities($post_zip));
        $post_gender = addslashes(htmlentities($post_gender));
        $post_phone = addslashes(htmlentities($post_phone));


	    $username = $_SESSION['username'];
        $SQL_UPDATE = "UPDATE dhvsu_app.user SET first_name = '$post_first_name', middle_name = '$post_middle_name', last_name = '$post_last_name', address = '$post_address', barangay = '$post_barangay', city = '$post_city', province = '$post_province', zip = '$post_zip', gender = '$post_gender', phone = '$post_phone' WHERE username = '$username'";

        $result = $connection->query($SQL_UPDATE);

        if($result) {
            header('Location: /app/profile.php');
        } else {
            echo $connection->error;
        }

    }



?>


<?php require_once './modules/loggedin-header.php' ?>
<main class="edit">
	<div class="edit-form-container">
        <a href="/app/profile.php" class="back">< Back to profile</a>
        <h2>Edit Profile</h2>
		<form action="" method="POST">
			<label for="username">Email Address</label>
			<input type="email" name="username" id="username" value="<?=$profile['username']?>" disabled>

			<label for="first_name">First Name</label>
			<input type="text" name="first_name" id="first_name" value="<?=$profile['first_name']?>" required>

			<label for="middle_name">Middle Name</label>
			<input type="text" name="middle_name" id="middle_name" value="<?=$profile['middle_name']?>" required>

			<label for="last_name">Last Name</label>
			<input type="text" name="last_name" id="last_name" value="<?=$profile['last_name']?>" required>
			<label for="gender">Gender</label>
			<select name="gender" id="gender" required>
				<option value="m" <?= $profile['gender'] == 'M' ? 'selected' : '' ?>>Male</option>
				<option value="f" <?= $profile['gender'] == 'F' ? 'selected' : '' ?>>Female</option>
			</select>

			<label for="address">Address</label>
			<input type="text" name="address" id="address"  value="<?= $profile['address'] ?>">

			<label for="barangay">Barangay</label>
			<input type="text" name="barangay" id="barangay"  value="<?= $profile['barangay'] ?>">

			<label for="city">Municipality/City</label>
			<input type="text" name="city" id="city"  value="<?= $profile['city'] ?>">

			<label for="province">Province</label>
			<input type="text" name="province" id="province"  value="<?= $profile['province'] ?>">

			<label for="zip">ZIP</label>
			<input type="text" name="zip" id="zip"  value="<?= $profile['zip'] ?>">

			<label for="phone">Mobile Number</label>
			<input type="text" name="phone" id="phone"  value="<?= $profile['phone'] ?>">

            <h2>Change Password</h2>
            <label for="password">Old Password</label>
            <input type="password" name="password" id="password">

            <label for="password">New Password</label>
            <input type="password" name="password" id="password">

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">

			<button type="submit">Submit</button>
		</form>
	</div>
</main>
<?php require_once './modules/loggedin-footer.php' ?>
