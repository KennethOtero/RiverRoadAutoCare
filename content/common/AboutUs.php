<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../../styles/AboutUs.css">
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
 
    <div class="Business Image">
        <div>
            <img src="../../images/AboutUsImage.png" alt="River Road Auto Care Business Image" class="BusinessImage">
        </div>
    </div>

    <div class="Text">
        <h1>Let's Learn About River Road Auto Care</h1>
        <p>
            River Road Auto Care is a privately-owned auto shop. We guarantee quality
            repairs to the people of Cincinnati. The qualified professionals are equipped 
            to handle all major and minor repairs on foreign and domestic vehicles. We currently hold an A+ rating with the Better Business Bureau since 2019. Together, we will keep
            your car on the road and we look forward to exceeding your expectations of automotive 
            repair.
        </p>
    </div> 

    <div class="Footer">
	    <div>
            <h3>RIVER ROAD AUTO CARE</h3>
            <ul>
                <li>5718 River Road, Cincinnati Ohio 45233</li>
                <li>(513) 941-8111</li>
                <li>Open 10am to 4pm Mon-Fri</li>
            </ul>
        </div>
    </div>
</body>
</html>