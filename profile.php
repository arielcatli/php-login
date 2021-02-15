<?php
    session_start();

    if(!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: /app');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(htmlentities($_POST['logout'])) {
            unset($_SESSION['loggedin']);
            unset($_SESSION['username']);
            header('Location: /app');
        }
    }


?>

<?php require_once './modules/loggedin-header.php' ?>

<main class="profile">
    <div class="profile-container">
        <img src="/app/assets/images/avatar.png" alt="">
        <div class="information">
            <p class="label">Name</p>
            <p class="name">Jerome Maglaqui Catli</p>
            <p class="label">Address</p>
            <p class="address">591 San Juan, San Luis, Pampanga 2014</p>
            <p class="label">Gender</p>
            <p class="gender">Male</p>
            <p class="label">Phone Number</p>
            <p class="phone">+639777784451</p>
            <form action="" method="POST">
                <input type="hidden" name="logout" value="true">
                <button>Logout</button>
            </form>
            <button onclick="location.href = '/app/edit.php';">Edit Profile</button>
        </div>
    </div>
    <div class="content">
        <h2>Login History</h2>
        <div class="login-history">
            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>

            <div class="record">
                <p class="details">Details</p>
                <p class="datetime">February 14, 2021 9:52 AM</p>
            </div>
        </div>
    </div>
</main>

<?php require_once './modules/loggedin-footer.php' ?>
