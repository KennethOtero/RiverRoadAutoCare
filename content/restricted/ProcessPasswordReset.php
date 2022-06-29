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
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

        try {
            // Get form data
            $email = strtolower($_POST['txtEmail']);
            $security = $_POST['txtSecurity'];
            $userPassword = $_POST['txtPassword'];
            $confirmPassword = $_POST['txtConfirmPassword'];

            // Session variables in case the user needs to go back
            $_SESSION['Email'] = $email;
            $_SESSION['Security'] = $security;
            $_SESSION['Password'] = $userPassword;
            $_SESSION['Confirm'] = $confirmPassword;

            // Connect to database
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

            // Test connection
            if ($conn) {
                // Check if email exists
                $sql = "SELECT strEmail FROM TUsers WHERE strEmail = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    // Clear result set
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }

                    // Check if security question is correct
                    $sql = "SELECT strSecurity FROM TUsers WHERE strSecurity = '$security'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        // Clear result set
                        while($conn->more_results()){
                            $conn->next_result();
                            if($res = $conn->store_result())
                            {
                                $res->free(); 
                            }
                        }

                        if ($userPassword === $confirmPassword) {
                            // Encrypt password
                            //$newPassword = password_hash($confirmPassword, PASSWORD_BCRYPT);
                            $newPassword = $confirmPassword;
                            $strModifiedReason = "User updated password.";
    
                            // Check if password wasn't the same as the last password
                            $sql = "SELECT strPassword FROM TUsers WHERE strEmail = '$email'";
                            $result = $conn->query($sql);
    
                            // If Query was successful
                            if ($result->num_rows > 0) {
                                // Get old password
                                while ($row = $result->fetch_assoc()) {
                                    // Make sure new password is not the same as the old password
                                    if ($newPassword == $row['strPassword']) {
                                        // Display error
                                        echo '
                                        <div class="ChangedPassword">
                                            <h1>Password Unsuccessfully Changed. <br> You Password Must Be Different From Your Last Password.</h1>
                                            <a href="../common/ResetPassword.php" class="Homepage">Change Password</a>
                                        </div>';
                                        exit;
                                    }
                                }
                            }
    
                            // Update password query
                            $result = mysqli_query($conn,"CALL uspUpdatePassword('$email', '$newPassword', '$strModifiedReason')");
    
                            if ($result) {
                                // Display successful password change
                                echo '
                                <div class="ChangedPassword">
                                    <h1>Password Successfully Changed.</h1>
                                    <a href="../common/login.php" class="Homepage">Sign In</a>
                                </div>';
                            } else {
                                // Display error
                                echo '
                                <div class="ChangedPassword">
                                    <h1>Password Unsuccessfully Changed.</h1>
                                    <a href="../common/ResetPassword.php" class="Homepage">Change Password</a>
                                </div>';
                            }
                        }
                    } else {
                        // Display error
                        echo '
                        <div class="ChangedPassword">
                            <h1>Invalid Security Data.</h1>
                            <a href="../common/ResetPassword.php" class="Homepage">Go Back</a>
                        </div>';
                    }
                } else {
                    echo '
                    <div class="ChangedPassword">
                        <h1>Email Not Found.</h1>
                        <a href="../common/ResetPassword.php" class="Homepage">Change Email</a>
                    </div>';
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