<?php
	// Display errors
	if (FALSE) { // toggle to false after debugging
        ini_set( 'display_errors', 'true');
        error_reporting(-1);
	}
?>
<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    
    try {
        //echo "<script>alert('idintVehicleID Exists');</script>";
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
    } catch (Exception $e) {
        echo $e;
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Update Vehicle : River Road Auto Care</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="keywords" content="river road auto care" />
        <meta name="description" content="Custom auto modifications and repairs." />
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

        <div class="UpdateVehicle">
            <h1>Update Vehicle</h1>
            <form name="frmLoadVehicles" method="post" action="">
                <span class="details">Select Vehicle*</span>
                <select name="selVehicle" id="selVehicle" required>
                    <?php
                        // Get the UserID
                        $intUserID = $_SESSION['intUserID'];

                        // Run a query to load the select box with a user's vehicles
                        $sql = "SELECT 
                                    intVehicleID,
                                    CONCAT(strColor, ' ',strMake,' ', strModel) as Vehicle
                                FROM 
                                    TVehicles 
                                WHERE 
                                    intUserID = $intUserID";
                        $result = $conn->query($sql);
                        echo '<option value="0">Select Vehicle</option>';
                        if ($result) {
                            while( $row = mysqli_fetch_array($result) ) {
                                /* If a vehicle ID matches whatever is selected, make that vehicle selected.
                                   This is so that the select box doesn't default back to 'Select Vehicle' 
                                   after submitting. This results in a better user experience.
                                */
                                if ($row['intVehicleID'] == $_POST['selVehicle']) {
                                    echo "<option value=\"" . $row['intVehicleID'] . "\" selected>"
                                    . $row['Vehicle'] . "</option>";
                                } else {
                                    echo "<option value=\"" . $row['intVehicleID'] . "\">"
                                    . $row['Vehicle'] . "</option>";
                                }
                                
                            }
                        }

                        // Clear result set
                        $result->free();
                    ?>
                </select>
                <input type="submit" name="btnSelSubmit" id="btnSelSubmit" value="Load Vehicle">
            </form>
            <form name="frmLogin" method="post" action="../restricted/process_update_vehicle.php" onsubmit="return validateForm()">
                <?php 
                    // Get selected vehicle
                    if (isset($_POST['selVehicle'])) {
                        $Selected = $_POST['selVehicle'];
                    } else {
                        $Selected = 0;
                    }

                    // Get vehicle id to update
                    // $intVehicleID = $_POST['selVehicle'];
                    // $_SESSION['intVehicleID'] = $intVehicleID;

                    // Get User's Information
                    $sql = "SELECT * FROM TVehicles WHERE intVehicleID = $Selected";
                    $result = $conn->query($sql);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $_SESSION['intVehicleID'] = $row['intVehicleID'];
                        $_SESSION['strVIN'] = $row['strVIN'];
                        $_SESSION['strMake'] = $row['strMake'];
                        $_SESSION['strModel'] = $row['strModel'];
                        $_SESSION['intYear'] = (int)$row['intYear'];
                        $_SESSION['strColor'] = $row['strColor'];
                        $_SESSION['strLicensePlate'] = $row['strLicensePlate'];
                        $_SESSION['strComments'] = $row['strComments'];

                        // Clear result set and close connection
                        $result->free();
                        $conn->close();
                        
                        // Get form data
                        $intVehicleID = $_SESSION['intVehicleID'];
                        $strVIN = $_SESSION['strVIN'];
                        $strMake = $_SESSION['strMake'];
                        $strModel = $_SESSION['strModel'];
                        $intYear = (int)$_SESSION['intYear'];
                        $strColor = $_SESSION['strColor'];
                        $strLicensePlate = $_SESSION['strLicensePlate'];
                        $strComments = $_SESSION['strComments'];
                    }

                    // Load form based on vehicle selected
                    if ($Selected != 0) {
                        echo 
                        '
                        <span class="details">VIN*</span>
                        <input type="text" name="txtVIN" id="txtVIN" maxlength="17" value="'. $strVIN .'" placeholder="Enter VIN" required>
                        <span class="details">Year*</span>
                        <input type="text" name="txtYear" id="txtYear" maxlength="4" value="'. $intYear .'" placeholder="Enter Year" required>
                        <span class="details">Make*</span>
                        <input type="text" name="txtMake" id="txtMake" maxlength="50" value="'. $strMake .'" placeholder="Enter Make" required>
                        <span class="details">Model*</span>
                        <input type="text" name="txtModel" id="txtModel" maxlength="50" value="'. $strModel .'" placeholder="Enter Model" required>
                        <span class="details">Color*</span>
                        <input type="text" name="txtColor" id="txtColor" maxlength="50" value="'. $strColor .'" placeholder="Enter Color" required>
                        <span class="details">License Plate*</span>
                        <input type="text" name="txtLicensePlate" id="txtLicensePlate" maxlength="20" value="'. $strLicensePlate .'" placeholder="Enter License Plate" required>
                        <span class="details">Comments:</span>
                        <textarea id="txtComments" name="txtComments" id="txtComments" rows="4" cols="50" maxlength="250">'. $strComments .'</textarea>
                        <span class="required">Required*</span><br>
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Update">
                        ';
                    } else {
                        echo 
                        '
                        <span class="details">VIN*</span>
                        <input type="text" name="txtVIN" maxlength="17" value="" placeholder="Enter VIN" required>
                        <span class="details">Year*</span>
                        <input type="text" name="txtYear" maxlength="4" value="" placeholder="Enter Year" required>
                        <span class="details">Make*</span>
                        <input type="text" name="txtMake" maxlength="50" value="" placeholder="Enter Make" required>
                        <span class="details">Model*</span>
                        <input type="text" name="txtModel" maxlength="50" value="" placeholder="Enter Model" required>
                        <span class="details">Color*</span>
                        <input type="text" name="txtColor" maxlength="50" value="" placeholder="Enter Color" required>
                        <span class="details">License Plate*</span>
                        <input type="text" name="txtLicensePlate" maxlength="20" value="" placeholder="Enter License Plate" required>
                        <span class="details">Comments:</span>
                        <textarea id="txtComments" name="txtComments" rows="4" cols="50" maxlength="250"></textarea>
                        <span class="required">Required*</span><br>
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Update">
                        ';
                    }
                ?>
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