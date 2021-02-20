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

// Get courses

$SQL_GET_COURSES = "SELECT * FROM dhvsu_app.course";
$courses_result = $connection->query($SQL_GET_COURSES);
print($connection->error);

$courses = array();
while($row = $courses_result->fetch_assoc()) {
	$courses[] = $row;
}

// Enrolled courses
$user_id = $profile['id'];
$SQL_GET_ENROLLED_COURSES = "SELECT dhvsu_app.enrollment.course_id, dhvsu_app.course.name, dhvsu_app.course.code, dhvsu_app.course.time_start, dhvsu_app.course.time_end FROM dhvsu_app.enrollment INNER JOIN dhvsu_app.course ON dhvsu_app.enrollment.course_id = dhvsu_app.course.id WHERE user_id = '$user_id';";
$enrolled_courses_result = $connection->query($SQL_GET_ENROLLED_COURSES);
print($connection->error);

$enrolled_courses = array();
while($row = $enrolled_courses_result->fetch_assoc()) {
	$enrolled_courses[] = $row;
}

// Generate array of enrolled course id
$enrolled_course_ids_only = array();
foreach($enrolled_courses as $whole_courses) {
    $enrolled_course_ids_only[] = $whole_courses['code'];
}

$debug_me = 'default';
//print_r($enrolled_course_ids_only);

//print(count($enrolled_courses));

// Process enrollment

    if($_SERVER['REQUEST_METHOD'] == "POST") {
	    if(isset($_POST['course_added'])) {
	        $post_courses_added = $_POST['course_added'];

	        foreach($post_courses_added as $post_course_id) {
		        $SQL_GET_COURSE_ID = "SELECT dhvsu_app.course.id, dhvsu_app.course.code FROM dhvsu_app.course where dhvsu_app.course.code = '$post_course_id'";
                $get_course_result = $connection->query($SQL_GET_COURSE_ID);
                print($connection->error);
                if($get_course_result->num_rows > 0) {
                    $course_id_assoc = $get_course_result->fetch_assoc();
                    $course_id = $course_id_assoc['id'];
                    $course_code = $course_id_assoc['code'];

//                    $debug_me = $course_id;

                    if(in_array($course_code, $enrolled_course_ids_only)) {
                        continue;
                    }

	                $now = new DateTime();
	                $now->setTimezone(new DateTimeZone('Asia/Taipei'));
	                $date_enrolled = $now->format('Y-m-d H:i:s');

                    $SQL_ADD_ENROLLMENT = "INSERT INTO dhvsu_app.enrollment (user_id, course_id, enrolled_on) VALUES ('$user_id', '$course_id', '$date_enrolled')";

                    $add_enrollment_results = $connection->query($SQL_ADD_ENROLLMENT);
                    print($connection->error);

                    if($add_enrollment_results) {
//                        header('Location: /app/enrollment.php');
//	                    exit();
                    } else {
	                    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	                    exit();
                    }
                } else
                {
	                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	                exit();
                }
	        }

	        header('Location: /app/enrollment.php');
	        exit();
        }

	    if(isset($_POST['course_deleted'])) {
	        $post_courses_deleted = $_POST['course_deleted'];
	        $debug_me = ($_POST['course_deleted']);

		    foreach($post_courses_deleted as $post_course_id) {
			    $SQL_GET_COURSE_ID = "SELECT dhvsu_app.course.id, dhvsu_app.course.code FROM dhvsu_app.course where dhvsu_app.course.code = '$post_course_id'";
			    $get_course_result = $connection->query($SQL_GET_COURSE_ID);
			    print($connection->error);
			    if($get_course_result->num_rows > 0) {
				    $course_id_assoc = $get_course_result->fetch_assoc();
				    $course_id = $course_id_assoc['id'];
				    $course_code = $course_id_assoc['code'];

				    $SQL_ADD_ENROLLMENT_DELETE = "DELETE FROM dhvsu_app.enrollment WHERE dhvsu_app.enrollment.course_id = '$course_id' and dhvsu_app.enrollment.user_id = '$user_id';";

				    $delete_enrollment_results = $connection->query($SQL_ADD_ENROLLMENT_DELETE);
				    print($connection->error);

				    if($delete_enrollment_results) {
//					    header('Location: /app/enrollment.php');
//					    exit();
				    } else {
					    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
					    exit();
				    }
			    } else
			    {
				    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
				    exit();
			    }
		    }

		    header('Location: /app/enrollment.php');
		    exit();
        }
    }


?>

<?php require_once './modules/loggedin-header.php' ?>

<main class="enrollment">
<!--    --><?//=$debug_me?>
	<div class="courses-available">
		<form action="" method="POST">
			<h2>Courses Available</h2>
			<button type="submit">Enroll</button>
			<ul class="courses">
				<?php foreach($courses as $course): ?>
					<li>
						<input type="checkbox" name="course_added[]" value="<?=$course['code']?>">
						<div class="course-information">
							<p class="course-name"><?=$course['name']?></p>
							<p class="course-code"><?=$course['code']?></p>
							<p class="course-schedule"><?=$course['time_start']?> - <?=$course['time_end']?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</form>
	</div>
	<div class="enrolled-courses">
		<form action="" method="POST">
			<h2>My Enrolled Courses</h2>
			<button type="submit">Un-enroll</button>

			<ul class="enrolled_courses">
				<?php foreach($enrolled_courses as $enrolled_course): ?>
					<li>
						<input type="checkbox" name="course_deleted[]" value="<?=$enrolled_course['code']?>">
						<div class="course-information">
							<p class="course-name"><?=$enrolled_course['name']?></p>
							<p class="course-code"><?=$enrolled_course['code']?></p>
							<p class="course-schedule"><?=$enrolled_course['time_start']?> - <?=$enrolled_course['time_end']?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</form>
	</div>
</main>

<?php require_once './modules/loggedin-footer.php' ?>

