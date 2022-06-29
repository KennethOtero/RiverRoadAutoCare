<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Review</title>
    <link rel="stylesheet" href="../../styles/add_user.css">
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
	if(FALSE) // toggle to false after debugging
	{
        ini_set( 'display_errors', 'true');
        error_reporting(-1);
	}
?>
<script>
    function success(strUserName) {
        alert("Add User Successful.\nLogged in as : " + strUserName);
        window.location.href="../common/add_vehicle.php";
    }
    function debug(message) {
        alert(message);
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
        $conn->set_charset('utf8mb3');
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($conn) {
            // Get form data
            $userid = "";
            $strFirstName = $_POST['txtFirstName'];
            $strLastName = $_POST['txtLastName'];
            $strAddress = $_POST['txtAddress'];
            $strApartmentNumber = $_POST['txtApartmentNumber'];
            $strCity = $_POST['txtCity'];
            $intStateID = (int)$_POST['selState'];
            $strZip = $_POST['txtZip'];
            $strPhoneNumber = $_POST['txtPhone'];
            $strEmail = strtolower($_POST['txtEmail']);        
            $strPassword = $_POST['txtPassword'];
            $strSecurity = $_POST['txtSecurity'];
            $intUserTypeID = 1;

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

            // Check if email exists
            $sql = "CALL uspUserEmailExists('$strEmail')";
            if ($result = mysqli_query($conn,$sql)) {
                //if email doesn't exist
                if (mysqli_num_rows($result) < 1) {
                    //proceed with save
                    $sql = "SET @p_intUserID = ''";
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }
                    $conn->query($sql);
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }
                    $sql = "CALL uspAddUser('$strFirstName','$strLastName','$strAddress','$strApartmentNumber','$strCity', $intStateID,'$strZip','$strPhoneNumber', 
                                            '$strEmail','$strPassword',$intUserTypeID, '$strSecurity', @p_intUserID )";
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }
                    $conn->query($sql);
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }
                    $sql = "SELECT @p_intUserID as intUserID"; //set output variable
                    if ($result = mysqli_query($conn,$sql)) {
                        //get return data
                        $row = $result->fetch_assoc();
                        $strUserName = $_SESSION['strFirstName'] . " " . $_SESSION['strLastName'];
                        $_SESSION['intUserID'] = $row['intUserID'];
                        $_SESSION['blnLoggedIn'] = TRUE;
                        echo "<script>success('" . $strUserName . "');</script>";
                    }
                    else {
                        echo '
                        <div class="ContentMessage">
                            <h1>Failed to add user.</h1>
                            <a href="../common/add_user.php" class="GoBack">Go Back</a>
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
                        $_SESSION['blnAddUserFailed'] = TRUE;
                    }
                }
                else {
                    echo '
                    <div class="ContentMessage">
                        <h1>Email exists.</h1>
                        <a href="../common/add_user.php" class="GoBack">Go back</a>
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
                    $_SESSION['blnAddUserFailed'] = TRUE;
                }
            }
        }
        // Close database connection
        $conn->close();
    } 
    catch (Exception $e) {
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