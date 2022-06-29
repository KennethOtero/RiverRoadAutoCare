<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Review</title>
    <link rel="stylesheet" href="../../styles/update_vehicle.css">
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
                <li><a href="../common/Services.php">Services</a></li>
                <li><a href="../common/ContactUs.php">Contact</a></li>
                <li><a href="../common/AboutUs.php">About</a></li>
                <li>
                    <?php 
                        // Check if the user is logged in and display the appropriate navigation bar based on user type
                        require('../common/IsLoggedIn.php');
                    ?>  
                </li>
            </ul>
            <div class="MenuAction">
                <ul class="MenuItems" id="myDropdown">
                    <li><a href="../common/update_user.php">Update Profile</a></li>
                    <li><a href="../common/add_vehicle.php">Add Vehicle</a></li>
                    <li><a href="../common/update_vehicle.php">Update Vehicle</a></li>
                    <li><a href="../common/u_calendar.php">Schedule</a></li>
                    <li><a href="LogOut.php">Log Out</a></li>
                <ul>
            </div>
        </div>
    </div>

<?php
	// Display errors
	if (FALSE) { // toggle to false after debugging
        ini_set( 'display_errors', 'true');
        error_reporting(-1);
	}
?>
<script>
    function success() {
        alert("Update Successful.");
        window.location.href="../common/update_vehicle.php";
    }
</script>
<?php 
        // Start session
        if (!isset($_SESSION)) {
            session_start();
        }

        try {
            // MySQL Connection variables                        
            $servername = "itd2.cincinnatistate.edu";
            $username = "kjotero2";
            $password = "0646911";
            $database = "02CPDM290OteroK";
            
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $database);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($conn) {
                // Get form data
                $intUserID = (int)$_SESSION['intUserID'];
                $intVehicleID = (int)$_SESSION['intVehicleID'];
                $strVIN = $_POST['txtVIN'];
                $strMake = $_POST['txtMake'];
                $strModel = $_POST['txtModel'];
                $intYear = (int)$_POST['txtYear'];
                $strColor = $_POST['txtColor'];
                $strLicensePlate = $_POST['txtLicensePlate'];
                $strComments = $_POST['txtComments'];                        
                $strModified_Reason = "User updated vehicle";

                // Session variables in case the user has an error and must go back
                $_SESSION['intYear'] = $intYear;
                $_SESSION['strMake'] = $strMake;
                $_SESSION['strModel'] = $strModel;
                $_SESSION['strColor'] = $strColor;
                $_SESSION['strLicensePlate'] = $strLicensePlate;
                $_SESSION['strVIN'] = $strVIN;
                $_SESSION['strComments'] = $strComments;
                $_SESSION['strModified_Reason'] = $strModified_Reason; 
                
                // Update vehicle
                $sql = "CALL uspUpdateVehicle($intVehicleID,
                            '$strVIN','$strMake',$intYear,
                            '$strModel','$strColor','$strLicensePlate',
                            $intUserID,'$strComments','$strModified_Reason')";
                if (mysqli_query($conn,$sql)) {
                    //success                        
                    echo "<script>success();</script>";
                } 
                else {
                    //Update failed
                    echo '
                    <div class="ContentMessage">
                        <h1>Update Failed.</h1>
                        <a href="../common/update_vehicle.php" class="GoBack">Go back</a>
                    </div>
                    <style>
                        .ContentMessage, .GoBack{
                            font-family: Arial, Helvetica, sans-serif;
                            color: #424242;
                            text-align: center;
                            margin-bottom: 550px;
                        }
                        
                        .ContentMessage a, .GoBack {
                            color: #0075db;
                            text-decoration: none;
                        }
                    </style>';                    
                }
            }
            // Close database connection
            $conn->close();
        } catch (Exception $e) {
            echo $e;
        }
    ?>
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