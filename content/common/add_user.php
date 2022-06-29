<?php
	// Display errors
	if (FALSE) {// toggle to false after debugging
        ini_set( 'display_errors', 'true');
        error_reporting(-1);
	}
?>
<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    //$_SESSION['blnAddUserFailed'] = TRUE;
    if (isset($_SESSION['blnAddUserFailed'])) {
        //get retry flag
        $blnIsRetry = $_SESSION['blnAddUserFailed'];
        //clear flag for next try
        $_SESSION['blnAddUserFailed'] = FALSE;
        //echo $strEmail;
        //if this is a retry
        if ($blnIsRetry == TRUE) {
            //grab values
            $strFirstName = $_SESSION['strFirstName'];
            $strLastName = $_SESSION['strLastName'];
            $strAddress = $_SESSION['strAddress'];
            $strApartmentNumber = $_SESSION['strApartmentNumber'];
            $strCity = $_SESSION['strCity'];
            $intStateID = $_SESSION['intStateID'];
            $strZip = $_SESSION['strZip'];
            $strPhoneNumber = $_SESSION['strPhoneNumber'];
            $strEmail = strtolower($_SESSION['strEmail']);
        } else {
            //set to blank
            $strFirstName = "";
            $strLastName = "";
            $strAddress = "";
            $strApartmentNumber = "";
            $strCity = "";
            $intStateID = "";
            $strZip = "";
            $strPhoneNumber = "";
            $strEmail = "";
        }        
    } else {
        //set to blank
        $strFirstName = "";
        $strLastName = "";
        $strAddress = "";
        $strApartmentNumber = "";
        $strCity = "";
        $intStateID = "";
        $strZip = "";
        $strPhoneNumber = "";
        $strEmail = "";
    }   
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>New User : River Road Auto Care</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="keywords" content="river road auto care" />
        <meta name="description" content="Custom auto modifications and repairs." />
        <link rel="stylesheet" href="../../styles/add_user.css">
        <script src="../../scripts/ProfileMenu.js"></script>
        <script>
            function setPostedState(intSelectedState) {
                //set posted stateid as the value of the state ddl
                var selState = document.getElementById('selState');
                selState.selectedIndex = intSelectedState;
            }
        </script>              
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

        <div class="AddUser">
            <h1>User Registration</h1>
            <form name="frmLogin" method="post" action="../restricted/process_add_user.php" onsubmit=" return validateForm()">
                <span class="details">First Name<small>*</small></span>
                <input type="text" name="txtFirstName" id="txtFirstName" maxlength="50" value="<?php echo $strFirstName;?>" placeholder="Enter your first name" required>
                <span class="details">Last Name<small>*</small></span>
                <input type="text" name="txtLastName" id="txtLastName" maxlength="100" value="<?php echo $strLastName;?>" placeholder="Enter your last name" required>
                <span class="details">Address<small>*</small></span>
                <input type="text" name="txtAddress" id="txtAddress" maxlength="100" value="<?php echo $strAddress;?>" placeholder="Enter your address" required>
                <span class="details">Apartment Number</span>
                <input type="text" name="txtApartmentNumber" id="txtApartmentNumber" maxlength="50" value="<?php echo $strApartmentNumber;?>" placeholder="Enter your apartment number">
                <span class="details">City<small>*</small></span>
                <input type="text" name="txtCity" id="txtCity" maxlength="100" value="<?php echo $strCity;?>" placeholder="Enter your city" required>
                <span class="details">State<small>*</small></span>
                <select id="selState" name="selState" id="selState" required>
                    <?php
                        // Connect to database
                        $servername = "itd2.cincinnatistate.edu";
                        $username = "kjotero2";
                        $password = "0646911";
                        $database = "02CPDM290OteroK";

                        // Connection object
                        $mysqli = new mysqli($servername, $username, $password, $database);

                        // Check connection
                        if ($mysqli -> connect_errno) {
                            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
                            exit();
                        } else {
                            $query = "SELECT * FROM TSTates";
                            $result = $mysqli -> query($query);
                            echo "<option value=\"0\">Select State</option>";
                            while( $row = mysqli_fetch_array($result) ) {
                                echo "<option value=\"" . $row['intStateID'] . "\">"
                                . $row['strState'] . "</option>";
                            }

                            // Close connection
                            $result->free();
                            $mysqli->close();
                        }
                    ?>
                </select>
                <?php echo "<script> setPostedState(" . $intStateID . "); </script>";?>
                <span class="details">Zip Code<small>*</small></span>
                <input type="text" name="txtZip" id="txtZip" maxlength="100" value="<?php echo $strZip;?>" placeholder="Enter your zip code" required>
                <span class="details">Phone Number<small>*</small></span>
                <input type="text" name="txtPhone" id="txtPhone" maxlength="100" value="<?php echo $strPhoneNumber;?>" placeholder="Enter your phone number" required>
                <span class="details">Email<small>*</small></span>
                <input type="email" name="txtEmail" id="txtEmail" maxlength="100" value="<?php echo $strEmail;?>" placeholder="Enter your email" required>
                <span class="details">Password<small>*</small></span>
                <input type="password" name="txtPassword" id="txtPassword" maxlength="50" placeholder="Enter your password" required>
                <span class="details">Security Question: What City Were You Born In?<small>*</small></span>
                <input type="text" name="txtSecurity" id="txtSecurity" placeholder="Enter security answer" required>
                <div class="buttons">
                    <a href="../../index.php"><input type="button" id="btnCancel" value="Cancel"></a>
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Register">
                    <span class="required"><small>Required*</small></span>
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
            // Validate the form
            function validateForm() {
                // Create boolean result
                var blnResult = true;

                // Get textbox input
                var FirstName = document.forms['frmLogin']['txtFirstName'].value.trim();
                var LastName = document.forms['frmLogin']['txtLastName'].value.trim();
                var Address = document.forms['frmLogin']['txtAddress'].value.trim();
                var City = document.forms['frmLogin']['txtCity'].value.trim();
                var State = document.forms['frmLogin']['selState'].value;
                var Zip = document.forms['frmLogin']['txtZip'].value.trim();
                var Phone = document.forms['frmLogin']['txtPhone'].value.trim();
                var Email = document.forms['frmLogin']['txtEmail'].value.trim();
                var Password = document.forms['frmLogin']['txtPassword'].value.trim();
                var Security = document.getElementById('txtSecurity').value.trim();

                // Check for empty strings
                if (FirstName == "") {
                    alert("Enter a first name.");
                    document.getElementById("txtFirstName").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (LastName == "") {
                    alert("Enter a last name.");
                    document.getElementById("txtLastName").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Address == "") {
                    alert("Enter an address.");
                    document.getElementById("txtAddress").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (City == "") {
                    alert("Enter a city.");
                    document.getElementById("txtCity").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (State == 0) {
                    alert("Select a state.");
                    document.getElementById("selState").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Zip == "") {
                    alert("Enter a zip code.");
                    document.getElementById("txtZip").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Phone == "") {
                    alert("Enter a phone number.");
                    document.getElementById("txtPhone").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Email == "") {
                    alert("Enter an email address.");
                    document.getElementById("txtEmail").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Password == "") {
                    alert("Enter a password.");
                    document.getElementById("txtPassword").focus();
                    blnResult = false;
                    return blnResult;
                }
                if (Security == "") {
                    alert("Answer the security question.");
                    document.getElementById("txtSecurity").focus();
                    blnResult = false;
                    return blnResult;
                }

                // Return successful validation status
                return blnResult;
            }
        </script>

    </body>    
</html>