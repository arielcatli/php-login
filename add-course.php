<?php
require_once './functions.php';
session_start();

if(!(isset($_SESSION['loggedin']))) {
	print(!(isset($_SESSION['loggedin'])));
	header('Location: /app');
	exit();
}

//    Load profile
$username = $_SESSION['username'];
$SQL_GET_PROFILE = "SELECT * FROM dhvsu_app.user WHERE username = '$username'";
$result = $connection->query($SQL_GET_PROFILE);

if($result->num_rows > 0) {
	$profile = $result->fetch_assoc();
} else {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	exit();
}

if($profile['role'] != 'administrator') {
	header("Location: /app/profile.php");
	exit();
}

// Add a course

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	extract($_POST, EXTR_PREFIX_ALL, 'post');

	$post_course_name = ucwords(addslashes(htmlentities($post_course_name)));
	$post_course_code = strtoupper(htmlentities($post_course_code));
	$post_course_start = htmlentities($post_course_start);
	$post_course_end = htmlentities($post_course_end);

	# check if code already exists
    $SQL_CHECK_CODE_EXISTS = "SELECT * FROM dhvsu_app.course WHERE dhvsu_app.course.code = '$post_course_code'";
    $check_code_result = $connection->query($SQL_CHECK_CODE_EXISTS);
    print($connection->error);

    if($check_code_result->num_rows > 0) {
        $error = "Course code already exists.";
    } else {
	    $SQL_ADD_COURSE = "INSERT INTO dhvsu_app.course (name, code, time_start, time_end) VALUES ('$post_course_name', '$post_course_code', '$post_course_start', '$post_course_end')";
	    $add_course_result = $connection->query($SQL_ADD_COURSE);
	    print($connection->error);

	    if($add_course_result) {
		    header('Location: /app/edit-courses.php');
		    exit();
	    } else {
		    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		    exit();
	    }
    }


}

?>

<?php require_once './modules/loggedin-header.php' ?>

<main class="edit-course">
	<a href="/app/profile.php" class="back">< Back to profile</a>

	<form action="" class="edit-course-form" method="POST">
        <h2>Add a Course</h2>
        <?php if(isset($error)): ?>
            <p class="error"><?=$error?></p>
        <?php endif; ?>
		<input type="hidden" name="edit-course">
		<label for="">Course Code</label>
		<input type="text" name="course_code" id="course_code" required>
		<label for="">Course Name</label>
		<input type="text" name="course_name" id="course_name" required>
		<label for="">Start Time</label>
		<input type="time" name="course_start" id="course_start" required>
		<label for="">End Time</label>
		<input type="time" name="course_end" id="course_end" required>

		<button type="submit" class="submit-edit-course">Add</button>
	</form>
</main>

<?php require_once './modules/loggedin-footer.php' ?>
