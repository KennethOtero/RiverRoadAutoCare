<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
    <link rel="stylesheet" href="../../styles/AddReview.css">
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

    <?php 
        // If the user is not logged in, redirect to login page
        if ($_SESSION['blnLoggedIn'] == FALSE) {
            // Change to login location
            header('Location: login.php');
        } 
    ?>

    <div class="Content">
        <h1>THANK YOU FOR REVIEWING<br>RIVER ROAD AUTO CARE</h1>
        <form name="frmReview" action="../restricted/InsertReview.php" method="POST" onsubmit="return validateForm()">
            <p>Enter your email:</p>
            <input type="email" class="Input" name="txtEmail" id="txtEmail" value="<?php echo $_SESSION['Email'];?>">
            <p>Select Rating:</p>
            <div class="rate">
                <input type="radio" id="star5" name="rate" value="5" <?php if ($_SESSION['Rating'] == 5){echo "checked";}?>/>
                <label for="star5" title="text">5 stars</label>
                <input type="radio" id="star4" name="rate" value="4" <?php if ($_SESSION['Rating'] == 4){echo "checked";}?>/>
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star3" name="rate" value="3" <?php if ($_SESSION['Rating'] == 3){echo "checked";}?>/>
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star2" name="rate" value="2" <?php if ($_SESSION['Rating'] == 2){echo "checked";}?>/>
                <label for="star2" title="text">2 stars</label>
                <input type="radio" id="star1" name="rate" value="1" <?php if ($_SESSION['Rating'] == 1){echo "checked";}?>/>
                <label for="star1" title="text">1 star</label>
            </div>
            <p>Leave Review Here:</p>
            <textarea id="txtReview" name="txtReview" rows="4" cols="50" maxlength="500"><?php echo $_SESSION['Review'];?></textarea><br>
            <div class="buttons">
                <a href="../../index.php"><input type="button" id="btnCancel" value="Cancel"></a>
                <input type="submit" id="btnSubmit" value="Submit">
            </div>
        </form>
    </div>

    <div class="Footer">
        <h3>RIVER ROAD AUTO CARE</h3>
        <ul>
            <li>5718 River Road, Cincinnati Ohio 45233</li>
            <li>(513) 941-8111</li>
            <li>Open 10am to 4pm Mon-Fri</li>
        </ul>
    </div>

    <script>
        function validateForm() {
            // Get textbox input
            var Email = document.forms["frmReview"]["txtEmail"].value;
            var radios = document.getElementsByName("rate");
            var Review = document.forms["frmReview"]["txtReview"].value;
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var blnRating = false;

            // Create result
            var blnResult = true;

            // Validate input
            if (Email == "") {
                alert("Enter an email address.");
                document.getElementById("txtEmail").focus();
                blnResult = false;
                return blnResult;
            }
            // Check if the email format is correct
            if (!Email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
                alert("Enter a valid email address.");
                document.getElementById("txtEmail").focus();
                blnResult = false;
                return blnResult;
            }
            // Loop through radio button ratings to see if they're checked
            for (var i = 0, len = radios.length; i < len; i++) {
                if (radios[i].checked) {
                    // A rating has been selected
                    blnRating = true;
                }
            }
            // Check if rating was selected
            if (blnRating == false) {
                alert("Select a rating.");
                blnResult = false;
                return blnResult;
            }
            // Check if Review is empty
            if (Review == "") {
                alert("Enter a review.");
                document.getElementById("txtReview").focus();
                blnResult = false;
                return blnResult;
            }

            // Return result
            return blnResult;
        }
    </script>
</body>
</html>