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

# Get Course
if(isset($_GET['code'])) {
	$course_code = $_GET['code'];
	$SQL_GET_COURSE = "SELECT * FROM dhvsu_app.course WHERE dhvsu_app.course.code = '$course_code'";
	$get_course_result = $connection->query($SQL_GET_COURSE);

	if($get_course_result->num_rows < 1) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		exit();
	}

	$course_retrieved = $get_course_result->fetch_assoc();
}

# SQL Edit course

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	extract($_POST, EXTR_PREFIX_ALL, 'post');
	$post_course_name = ucwords(addslashes(htmlentities($post_course_name)));
	$course_code = $course_retrieved['code'];
	$post_course_start = htmlentities($post_course_start);
	$post_course_end = htmlentities($post_course_end);

	$SQL_EDIT_COURSE = "UPDATE dhvsu_app.course SET dhvsu_app.course.name = '$post_course_name', dhvsu_app.course.time_start = '$post_course_start', dhvsu_app.course.time_end = '$post_course_end' WHERE dhvsu_app.course.code = '$course_code'";
	$edit_course_result = $connection->query($SQL_EDIT_COURSE);
	print($connection->error);

	if($edit_course_result) {
	    header("Location: /app/edit-courses.php");
	    exit();
    } else {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		exit();
    }
}

?>

<?php require_once './modules/loggedin-header.php' ?>

<main class="edit-course">
    <a href="/app/profile.php" class="back">< Back to profile</a>

    <form action="" class="edit-course-form" method="POST">
		<input type="hidden" name="edit-course">
		<label for="">Course Code</label>
		<input type="text" name="course_code" id="course_code" disabled value="<?=$course_retrieved['code']?>">
		<label for="">Course Name</label>
		<input type="text" name="course_name" id="course_name" value="<?=$course_retrieved['name']?>" required>
		<label for="">Start Time</label>
		<input type="time" name="course_start" id="course_start" value="<?=$course_retrieved['time_start']?>" required>
		<label for="">End Time</label>
		<input type="time" name="course_end" id="course_end" value="<?=$course_retrieved['time_end']?>" required>

		<button type="submit" class="submit-edit-course">Edit</button>
	</form>
</main>

<?php require_once './modules/loggedin-footer.php' ?>

