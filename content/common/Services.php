<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Services</title>
        <link rel="stylesheet" href="../../styles/services.css">
        <script src="../../scripts/ProfileMenu.js"></script>
    </head>
    <body>
        <?php 
            // Check if the session has started
            if (!isset($_SESSION)) {
                // Start the session
                session_start();
            }
        ?>
        <div class="Header">
            <div>
                <ul class="topbar">
                    <li>5718 River Road</li>
                    <li>(513) 941-8111</li>
                    <li>Open 10am to 4pm Mon-Fri</li>
                </ul>
            </div>
            <img src="../../images/car-header.png" class="CarImage" alt="Car">
            <div class="Logo"><a href="../../index.php">RIVER ROAD<br>AUTO CARE</a></div>
            <div>
                <ul class="menubar">
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="Services.php">Services</a></li>
                    <li><a href="ContactUs.php">Contact</a></li>
                    <li><a href="AboutUs.php">About</a></li>
                    <li>
                        <?php 
                            // Check if the user is logged in and display the appropriate navigation bar based on user type
                            require('IsLoggedIn.php');
                        ?>  
                    </li>
                </ul>
                <div class="MenuAction">
                    <ul class="MenuItems" id="myDropdown">
                        <li><a href="update_user.php">Update Profile</a></li>
                        <li><a href="add_vehicle.php">Add Vehicle</a></li>
                        <li><a href="update_vehicle.php">Update Vehicle</a></li>
                        <li><a href="u_calendar.php">Schedule</a></li>
                        <li><a href="../restricted/LogOut.php">Log Out</a></li>
                    <ul>
                </div>
            </div>
        </div>

        <div class="Services">
            <h1>Services</h1>
            <ul class="NormalServices">
                <li>Oil Change</li>
                <li>Engine Repair</li>
                <li>Suspension Repair</li>
                <li>Brake Repair</li>
                <li>HVAC Repair</li>
                <li>Electrical Repair</li>
                <li>Exhaust Repair</li>
                <li>Fog Light or Light Bar Install</li>
                <li>Lift Kit Install</li>
                <li>Winch Install</li>
            </ul>
            <h1>Custom Work</h1>
            <ul class="CustomServices">
                <li>Aftermarket Engine Install</li>
                <li>Aftermarket Suspension Install</li>
                <li>Aftermarket Exhaust Install</li>
                <li>... And More!</li>
            </ul>
            <a href="u_calendar.php"><input type="button" value="Schedule Now" name="btnSchedule" class="btnSchedule"></a>
        </div>

        <div class="Footer">
            <h3>RIVER ROAD AUTO CARE</h3>
            <ul>
                <li>5718 River Road, Cincinnati Ohio 45233</li>
                <li>(513) 941-8111</li>
                <li>Open 10am to 4pm Mon-Fri</li>
            </ul>
        </div>
    </body>
</html>