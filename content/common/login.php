<?php
	// Display errors
	if (FALSE) {// toggle to false after debugging
        ini_set( 'display_errors', 'true');
        error_reporting(-1);
	}
?>
<?php
// Start session
    if (!isset($_SESSION)) {
        session_start();
    }
    //$strEmail = "Before";
    //$_SESSION['blnLoginFailed'] = TRUE;
    if (isset($_SESSION['blnLoginFailed'])) {
        //get retry flag
        $blnIsRetry = $_SESSION['blnLoginFailed'];
        //reset flag for next try
        $_SESSION['blnLoginFailed'] = FALSE;
        //if flag is set
        if ($blnIsRetry == TRUE) {
            //grab value
            $strEmail = $_SESSION['strEmail'];
        } else {
            //set email text to blank
            $strEmail = "";
        }       
    } else {
        //set email text to blank
        $strEmail = "";
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../styles/homepage.css"/>
        <link rel="stylesheet" href="../../styles/login.css"> 
        <title>Login : River Road Auto Care</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="keywords" content="river road auto care" />
        <meta name="description" content="Custom auto modifications and repairs." /> 
        <link rel="stylesheet" href="../../styles/login.css">
        <script src="../../scripts/ProfileMenu.js"></script> 
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
                        <li><a href="../restricted/LogOut.php">Logout</a></li>
                    <ul>
                </div>
            </div>
        </div>

        <div class="LogIn">
            <h1>Sign In</h1>
            <form name="frmLogin" method="post" action="../restricted/process_login.php">
                <span class="details">Email*</span>
                <input type="email" name="txtEmail" maxlength="100" value="<?php echo $strEmail;?>" required>
                <span class="details">Password*</span>
                <input type="password" name="txtPassword" maxlength="100" required>
                <span class="required">Required*</span><br>
                <input type="submit" name="btnSubmit" id="btnSubmit" value="Login">
            </form>
            <div class="links">
                <a href="ResetPassword.php" class="reset">Reset Password</a><br><br>
                <a href="add_user.php" class="register">Click here to Register</a>
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

    </body>    
</html>