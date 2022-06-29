<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../../styles/resetpassword.css">
    <script src="../../scripts/ProfileMenu.js"></script>
</head>
<body>
    <?php 
        // Start the session
        if (!isset($_SESSION)) {
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

    <div class="Content">
        <div class="ResetPassword">
            <form action="../restricted/ProcessPasswordReset.php" name="frmPassword" method="POST" onsubmit="return validateForm()">
                <h1>Reset Password</h1>
                <p>Enter your email</p>
                <input type="email" class="Input" name="txtEmail" id="txtEmail" placeholder="Enter Email Address *" value="<?php echo $_SESSION['Email'];?>" required>
                <p>Security Question: What City Where You Born In?</p>
                <input type="text" class="Input" name="txtSecurity" id="txtSecurity" placeholder="Enter security answer" value="<?php echo $_SESSION['Security'];?>" required>
                <p>Create your new password</p>
                <input type="password" class="Input" name="txtPassword" id="txtPassword"placeholder="Create New Password *" value="<?php echo $_SESSION['Password'];?>" required><br />
                <input type="password" class="Input" name="txtConfirmPassword" id="txtConfirmPassword" placeholder="Confirm New Password *" value="<?php echo $_SESSION['Confirm'];?>" required><br />
                <input type="submit" value="Reset Password" name="btnSubmit" class="submit">
                <p class="Required">* = Required.</p>
            </form>
        </div>
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
            var Email = document.forms["frmPassword"]["txtEmail"].value.trim();
            var Password = document.forms["frmPassword"]["txtPassword"].value.trim();
            var ConfirmPassword = document.forms["frmPassword"]["txtConfirmPassword"].value.trim();
            var City = document.getElementById('txtSecurity').value.trim();
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

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
            if (City == "") {
                alert("Answer the security question.");
                document.getElementById("txtSecurity").focus();
                blnResult = false;
                return blnResult;
            }
            if (Password == "") {
                alert("Enter a password.");
                document.getElementById("txtPassword").focus();
                blnResult = false;
                return blnResult;
            }
            if (ConfirmPassword == "") {
                alert("Confirm your password.");
                document.getElementById("txtConfirmPassword").focus();
                blnResult = false;
                return blnResult;
            }
            if (Password != ConfirmPassword) {
                alert("Confirmed password must match created password.");
                document.getElementById("txtConfirmPassword").focus();
                blnResult = false;
                return blnResult;
            }

            // Return status
            return blnResult;
        }
    </script>
    
</body>
</html>