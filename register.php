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
			</div>
			<div class="form-grid">
				<label for="username">Email Address</label>
				<input type="email" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
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
					<option value="m">Male</option>
					<option value="f">Female</option>
				</select>
				<label for="address">Address</label>
				<input type="text" name="address" id="address">
				<label for="barangay">Barangay</label>
				<input type="text" name="barangay" id="barangay">
				<label for="municipality">Municipality/City</label>
				<input type="text" name="municipality" id="municipality">
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
