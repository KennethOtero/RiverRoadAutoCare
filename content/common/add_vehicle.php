<?php
	// Display errors
	if(FALSE) // toggle to false after debugging
	{
	ini_set( 'display_errors', 'true');
	error_reporting(-1);
	}
?>
<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['intUserID'])) {
        
        if (isset($_SESSION['blnAddVehicleFailed'])) {
            //get retry flag
            $blnIsRetry = $_SESSION['blnAddVehicleFailed'];
            //clear flag for next try
            $_SESSION['blnAddVehicleFailed'] = FALSE;
            //echo $strEmail;
            //if this is a retry
            if ($blnIsRetry == TRUE) {
               //grab values
                $strYear = $_SESSION['strYear'];
                $strMake = $_SESSION['strMake'];
                $strModel = $_SESSION['strModel'];
                $strColor = $_SESSION['strColor'];
                $strLicensePlate = $_SESSION['strLicensePlate'];
                $strVIN = $_SESSION['strVIN'];
            }
            else {
                //set to blank
                $strYear = "";
                $strMake = "";
                $strModel = "";
                $strColor = "";
                $strLicensePlate = "";
                $strVIN = "";
            }        
        }
        else {
            //set to blank
            $strYear = "";
            $strMake = "";
            $strModel = "";
            $strColor = "";
            $strLicensePlate = "";
            $strVIN = "";
        }
    }
    else {
        echo "<script>alert('Please log in to add a vehicle'); window.location.href='../../index.php';</script>";
    }  
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>New Vehicle : River Road Auto Care</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="keywords" content="river road auto care" />
        <meta name="description" content="Custom auto modifications and repairs." />
        <link rel="stylesheet" href="../../styles/add_vehicle.css">
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

        <div class="AddVehicle">
            <h1>Add Vehicle</h1>
            <form name="frmLogin" method="post" action="../restricted/process_add_vehicle.php" onsubmit="return validateForm()">
                <span class="details">VIN*</span>
                <input type="text" name="txtVIN" id="txtVIN" maxlength="17" value="<?php echo $strVIN;?>" placeholder="Enter VIN" required>
                <span class="details">Year*</span>
                <input type="text" name="txtYear" id="txtYear" maxlength="4" value="<?php echo $strYear;?>" placeholder="Enter Year" required>
                <span class="details">Make*</span>
                <input type="text" name="txtMake" id="txtMake" maxlength="50" value="<?php echo $strMake;?>" placeholder="Enter Make" required>
                <span class="details">Model*</span>
                <input type="text" name="txtModel" id="txtModel" maxlength="50" value="<?php echo $strModel;?>" placeholder="Enter Model" required>
                <span class="details">Color*</span>
                <input type="text" name="txtColor" id="txtColor" maxlength="50" value="<?php echo $strColor;?>" placeholder="Enter Color" required>
                <span class="details">License Plate*</span>
                <input type="text" name="txtLicensePlate" id="txtLicensePlate" maxlength="20" value="<?php echo $strLicensePlate;?>" placeholder="Enter License Plate" required>
                <span class="details">Comments:</span>
                <textarea id="txtComments" name="txtComments" id="txtComments" rows="4" cols="50" maxlength="250"></textarea>
                <span class="required">Required*</span><br>
                <input type="submit" name="btnSubmit" id="btnSubmit" value="Add Vehicle">
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
                // Create result
                var blnResult = true;

                // Get form data
                var strVIN = document.forms['frmLogin']['txtVIN'].value.trim();
                var Year = document.forms['frmLogin']['txtYear'].value.trim();
                var Make = document.forms['frmLogin']['txtMake'].value.trim();
                var Model = document.forms['frmLogin']['txtModel'].value.trim();
                var Color = document.forms['frmLogin']['txtColor'].value.trim();
                var LicensePlate = document.forms['frmLogin']['txtLicensePlate'].value.trim();

                // Check for empty strings
                if (strVIN == "") {
                    alert("Enter a VIN number.");
                    document.getElementById("txtVIN").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Year == "" || !isNumeric(Year)) {
                    alert("Enter a year.");
                    document.getElementById("txtYear").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Make == "") {
                    alert("Enter a make.");
                    document.getElementById("txtMake").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Model == "") {
                    alert("Enter a model.");
                    document.getElementById("txtModel").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Color == "") {
                    alert("Enter a color.");
                    document.getElementById("txtColor").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (LicensePlate == "") {
                    alert("Enter a license plate.");
                    document.getElementById("txtLicensePlate").focus();
                    blnResult = false;
                    return blnResult;
                }
                
                // Return result
                return blnResult;
            }

            // Validate a number
            function isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
        </script>
    </body>    
</html>