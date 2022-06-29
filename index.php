<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            // Start the session
            if (!isset($_SESSION)) {
                session_start();
            }
        ?>
        <title>River Road Auto Care</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="keywords" content="river road auto care" />
        <meta name="description" content="Custom auto modifications and repairs." />
        <link rel="stylesheet" href="styles/homepage.css">
        <script src="scripts/ProfileMenu.js"></script>
    </head>

    <body>
        <div class="Header">
            <div>
                <ul class="topbar">
                    <li>5718 River Road</li>
                    <li>(513) 941-8111</li>
                    <li>Open 10am to 4pm Mon-Fri</li>
                </ul>
            </div>
            <img src="images/car-header.png" class="CarImage" alt="Car">
            <div class="Logo"><a href="index.php">RIVER ROAD<br>AUTO CARE</a></div>
            <div>
                <ul class="menubar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="content/common/Services.php">Services</a></li>
                    <li><a href="content/common/ContactUs.php">Contact</a></li>
                    <li><a href="content/common/AboutUs.php">About</a></li>
                    <?php 
                        // Check if the user is logged in and display the appropriate navigation bar based on user type
                        require('content/common/IsLoggedIn.php');
                    ?>
                </ul>
                <div class="MenuAction">
                    <ul class="MenuItems" id="myDropdown">
                        <li><a href="content/common/update_user.php">Update Profile</a></li>
                        <li><a href="content/common/add_vehicle.php">Add Vehicle</a></li>
                        <li><a href="content/common/update_vehicle.php">Update Vehicle</a></li>
                        <li><a href="content/common/u_calendar.php">Schedule</a></li>
                        <li><a href="content/restricted/LogOut.php">Log Out</a></li>
                    <ul>
                </div>
            </div>
        </div>

        <div class="WelcomeScreen">
            <p class="WelcomeText">WELCOME TO</p>
            <p class="RiverRoadText">RIVER ROAD<br>AUTO CARE</p>
            <hr>
        </div>

        <div class="Info">
            <div class="Icons">
                <a href="#Reviews"><img src="images/Checkmark_Icon.png" class="CheckmarkIcon" alt="Checkmark"></a>
                <h3>CHECK OUR REVIEWS</h3>
                <p>See what our customers are saying!<br>Click the image above to view our reviews.</p>
            </div>
            <div class="Icons">
                <a href="content/common/AboutUs.php"><img src="images/Team_Logo.png" class="TeamIcon" alt="Team"></a>
                <h3>LEARN ABOUT US</h3>
                <p>Click the image above to learn <br>more about us!</p>
            </div>
            <div class="Icons">
                <a href="content/common/Services.php"><img src="images/Camera _Icon.png" class="CameraIcon" alt="Camera"></a>
                <h3>VIEW OUR WORK</h3>
                <p>Click the image above to <br>view some of our work!</p>
            </div>
    
            <hr class="ImgSeparator">
        </div>

        <div class="MapSection">
            <div class="Map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3096.3094096552754!2d-84.66951178518083!3d39.09942534261622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8841c96a3c69d387%3A0xc7676b3b73497164!2s5718%20River%20Rd%2C%20Cincinnati%2C%20OH%2045233!5e0!3m2!1sen!2sus!4v1649809078124!5m2!1sen!2sus" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="GoogleMaps"></iframe>
                <!--<img src="images/MapImage.png" class="GoogleMaps" alt="Address">-->
            </div>
            <div class="Map">
                <h3 id="FindUs">FIND US!</h3>
                <p>We're located at 5718 River Road, Cincinnati Ohio 45233. 
                   We offer a variety of different automotive services that you can find
                   <a href="content/common/Services.php">here</a> that range from traditional oil changes to custom work! Come visit us!</p>
            </div>
    
            <hr class="MapSeparator">
        </div>
        
        <div class="NewReviews" id="Reviews">
            <h1 class="ReviewHeader">What our customers say:</h1>
            <?php include('content/common/LoadShopReviews.php');?>
            <a href="content/common/AddReview.php"><input type="button" value="Leave A Review" class="btnNewReview"></a>
            <a class="SeeReviews" href="content/common/ViewReviews.php">See all reviews</a>
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