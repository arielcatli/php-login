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

//    Get all the login history records

    $user_id = $profile['id'];
    $SQL_GET_LOGIN_HISTORY = "SELECT * FROM dhvsu_app.login_history WHERE user_id = '$user_id'";
    $SQL_GET_LOGIN_HISTORY_ADMIN = "SELECT dhvsu_app.user.first_name, dhvsu_app.user.middle_name, dhvsu_app.user.last_name, dhvsu_app.login_history.logged_in, dhvsu_app.user.role FROM dhvsu_app.login_history INNER JOIN dhvsu_app.user ON dhvsu_app.user.id = dhvsu_app.login_history.user_id";

    $results_records = $connection->query($profile['role'] == 'administrator' ? $SQL_GET_LOGIN_HISTORY_ADMIN : $SQL_GET_LOGIN_HISTORY);
    print($connection->error);
    $records = array();
    while($row = $results_records->fetch_assoc()) {
        $records[] = $row;
    }

//    List of users for admin
    if($profile['role'] == 'administrator') {
	    $SQL_GET_USERS = "SELECT dhvsu_app.user.first_name, dhvsu_app.user.middle_name, dhvsu_app.user.last_name, dhvsu_app.user.username FROM dhvsu_app.user WHERE dhvsu_app.user.role = 'external'";
	    $user_result = $connection->query($SQL_GET_USERS);
	    $users = array();

	    while($row = $user_result->fetch_assoc()) {
	        $users[] = $row;
        }
    }


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(htmlentities($_POST['logout'])) {
            print('I am logging out');
            unset($_SESSION['loggedin']);
            unset($_SESSION['username']);
            $_SESSION = array();
            session_destroy();
            header('Location: /app');
            exit();
        }
    }


?>

<?php require_once './modules/loggedin-header.php' ?>

<main class="profile">
    <div class="profile-container">
        <img src="/app/assets/images/avatar.png" alt="">
        <div class="information">
            <p class="label"><?=$profile['role'] == 'administrator' ? "Administrator" : "Name"?></p>
            <p class="name"><?=$profile['first_name']?> <?=$profile['middle_name']?> <?=$profile['last_name']?></p>
            <p class="label">Address</p>
            <p class="address"><?=$profile['address']?>, <?=$profile['barangay']?>, <?=$profile['city']?>, <?=$profile['province']?> <?=$profile['zip']?></p>
            <p class="label">Gender</p>
            <p class="gender"><?=$profile['gender'] == 'M' ? 'Male' : 'Female';?></p>
            <p class="label">Phone Number</p>
            <p class="phone"><?=$profile['phone']?></p>
            <form action="" method="POST">
                <input type="hidden" name="logout" value="true">
                <button>Logout</button>
            </form>
            <button onclick="location.href = '/app/edit.php';">Edit Profile</button>
            <button onclick="location.href = '/app/enrollment.php';">My Courses</button>
        </div>
    </div>
    <?php if($profile['role'] == 'administrator'): ?>
        <div class="user-list">
            <h2>List of Users (<?= count($users) ?>)</h2>
            <?php foreach($users as $user): ?>
                <p class="user"><span class="email"><?=$user['username']?></span><br /><?=$user['first_name']?> <?=$user['middle_name']?> <?=$user['last_name']?></p>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
    <div class="content">
        <h2>Login History</h2>
        <div class="login-history">

            <?php foreach ($records as $record):
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $record['logged_in']);
                    $logged_in = $date->format('F j, Y h:i:s A');
                ?>
                <div class="record">
                    <p class="details">Details</p>
                    <?php if($profile['role'] == 'administrator'): ?>
                        <p class="user-details"><?= $record['role'] == 'administrator' ? "<span class='admin'>[ADMINISTRATOR] </span>" : "" ?><?=$record['first_name']?> <?=$record['middle_name']?> <?=$record['last_name']?></p>
                    <?php endif; ?>
                    <p class="datetime"><?=$logged_in?></p>
                </div>
            <?php endforeach; ?>



        </div>
    </div>
</main>

<?php require_once './modules/loggedin-footer.php' ?>
