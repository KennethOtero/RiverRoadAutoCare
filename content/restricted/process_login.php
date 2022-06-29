<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Review</title>
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
    function success() {
        alert("Login Successful");
        window.location.href="../../index.php";
    }
</script>
<?php 
        // Start session
        if (!isset($_SESSION)) {
            session_start();
        }
        //$_SESSION['blnLoggedIn'] = FALSE;
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
                $strEmail = strtolower($_POST['txtEmail']);        
                $strPassword = $_POST['txtPassword'];
                $_SESSION['strEmail'] = $strEmail;
                // Check if user exists
                $sql = "CALL uspUserLoginExists('$strEmail','$strPassword')";
                $result = mysqli_query($conn,$sql);
                //If we have rows returned
                if (mysqli_num_rows($result) > 0) {                        
                    $row = $result->fetch_assoc();
                    // Get UserID and set login status to true
                    $_SESSION['intUserID'] = $row['intUserID'];
                    $_SESSION['blnLoggedIn'] = TRUE;

                    // Clear result set
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }

                    // Get the UserType of the logged in user
                    $sql = "SELECT intUserTypeID FROM TUsers WHERE intUserID = ".$_SESSION['intUserID']."";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $UserType = $row['intUserTypeID'];

                        // Set 'Tech' status to true if the user is an admin/technician
                        if ($UserType == 2 || $UserType == 3) {
                            $_SESSION['Tech'] = TRUE;
                        }
                    } else {
                        $_SESSION['Tech'] = FALSE;
                    }
                    
                    // Go to homepage
                    echo "<script>success();</script>";                   
                } else {
                    echo '
                    <div class="ContentMessage">
                        <h1>Login failed. Check Email and Password</h1>
                        <a href="../common/login.php" class="GoBack">Go back</a>
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
                    echo "<script>alert('Log in as - $strEmail : $strPassword - FAILED');</script>";
                    $_SESSION['blnLoginFailed'] = TRUE;
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