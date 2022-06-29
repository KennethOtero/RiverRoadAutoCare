<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Review</title>
    <link rel="stylesheet" href="../../styles/update_user.css">
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
        window.location.href="../common/update_user.php";
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
                $userid = $_SESSION['intUserID'];
                $strFirstName = $_POST['txtFirstName'];
                $strLastName = $_POST['txtLastName'];
                $strAddress = $_POST['txtAddress'];
                $strApartmentNumber = $_POST['txtApartmentNumber'];
                $strCity = $_POST['txtCity'];
                $intStateID = (int)$_POST['selState'];
                $strZip = $_POST['txtZip'];
                $strPhoneNumber = $_POST['txtPhoneNumber'];
                $strEmail = strtolower($_POST['txtEmail']);       
                $strSecurity = $_POST['txtSecurity']; 

                // Session variables in case the user has an error and must go back
                $_SESSION['strFirstName'] = $strFirstName;
                $_SESSION['strLastName'] = $strLastName;
                $_SESSION['strAddress'] = $strAddress;
                $_SESSION['strApartmentNumber'] = $strApartmentNumber;
                $_SESSION['strCity'] = $strCity;
                $_SESSION['intStateID'] = $intStateID;
                $_SESSION['strZip'] =  $strZip;
                $_SESSION['strPhoneNumber'] = $strPhoneNumber;
                $_SESSION['strEmail'] =  $strEmail;  
                $_SESSION['strSecurity'] = $strSecurity;

                //bln for eligible save status
                $blnValid = FALSE;

                // Check if email exists
                $sql = "CALL uspUserEmailExists('$strEmail')";
                if ($result = mysqli_query($conn,$sql)) {                   
                    //if email does exist
                    if (mysqli_num_rows($result) > 0) {
                        $row = $result->fetch_assoc();                  
                        //get database email userid
                        $intDBEmailUserID = $row['intUserID'];
                        //clear result set
                        
                        //if  user logged in is the user with the same email
                        if ($intDBEmailUserID == $userid) {
                            //update the user
                            $blnValid = TRUE;
                        }
                    }
                    elseif ($result->num_rows == 0) {
                        //email is good to use, go ahead and update
                        $blnValid = TRUE;
                    }
                }

                // Clear result set
                while($conn->more_results()){
                    $conn->next_result();
                    if($res = $conn->store_result())
                    {
                        $res->free(); 
                    }
                } 

                // Get password and set modified reason
                $sql = "SELECT strPassword FROM TUsers WHERE intUserID = $userid";  
                if ($result = mysqli_query($conn,$sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        $row = $result->fetch_assoc();
                        $strPassword = $row['strPassword'];
                    }
                }                    
                $strModifiedReason = "User updated profile";
                $_SESSION['strPassword'] =  $strPassword;
                $_SESSION['strModifiedReason'] =  $strModifiedReason;

                // Clear result set
                while($conn->more_results()){
                    $conn->next_result();
                    if($res = $conn->store_result())
                    {
                        $res->free(); 
                    }
                } 

                if ($blnValid == TRUE) {
                    //update
                    //customer only right now
                    $intUserTypeID = 1;
                    $sql = "CALL uspUpdateUser($userid, '$strFirstName','$strLastName','$strAddress','$strApartmentNumber','$strCity',$intStateID,'$strZip',
                                                '$strPhoneNumber','$strEmail','$strPassword',$intUserTypeID, '$strSecurity', '$strModifiedReason' )";
                    if ($result = mysqli_query($conn,$sql)) {                        
                        echo "<script>success();</script>";
                    }                        
                }
                else {
                    //email exists
                    echo '
                    <div class="ContentMessage">
                        <h1>Email exists. Update Failed.</h1>
                        <a href="../common/update_user.php" class="GoBack">Go back</a>
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
                // Close database connection
                $conn->close();
            }
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