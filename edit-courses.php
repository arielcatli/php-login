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

// Get courses

$SQL_GET_COURSES = "SELECT * FROM dhvsu_app.course";
$courses_result = $connection->query($SQL_GET_COURSES);
print($connection->error);

$courses = array();
while($row = $courses_result->fetch_assoc()) {
	$courses[] = $row;
}

?>

<?php require_once './modules/loggedin-header.php' ?>

<main class="edit-courses">
	<a href="/app/profile.php" class="back">< Back to profile</a>

	<div class="courses-available">
		<form action="" method="POST">
			<h2>Courses Available</h2>
            <ul class="courses">
				<?php foreach($courses as $course): ?>
					<li>
						<div class="course-information">
							<p class="course-name"><?=$course['name']?></p>
							<p class="course-code"><?=$course['code']?></p>
							<p class="course-schedule"><?=$course['time_start']?> - <?=$course['time_end']?></p>
							<a href="/app/edit-course.php/?code=<?=$course['code']?>">[Edit]</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</form>
        <button onclick="location.href = '/app/add-course.php';">Add a course</button>

    </div>
</main>



<?php require_once './modules/loggedin-footer.php' ?>

