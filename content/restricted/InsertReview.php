<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Review</title>
    <link rel="stylesheet" href="../../styles/AddReview.css">
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
                $email = strtolower($_POST['txtEmail']);
                $rating = $_POST['rate'];
                $review = $_POST['txtReview'];
                $date = date('Y-m-d H:i:s');

                // Session variables in case the user has an error and must go back
                $_SESSION['Email'] = $email;
                $_SESSION['Rating'] = $rating;
                $_SESSION['Review'] = $review;
                
                // Check if email exists
                $sql = "SELECT strEmail FROM TUsers WHERE strEmail = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Get UserID
                    $sql = "SELECT intUserID FROM TUsers WHERE strEmail = '$email'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $userID = $row['intUserID'];
                    }

                    /* Add the review
                     - uspAddReview accepts the review, current date,
                     - review type, user ID, rating, and returns the new ReviewID
                    */
                    $sql = "CALL uspAddReview('$review', '$date', 1, $userID, $rating, @intReviewID)";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // Head to the reviews page
                        header('Location: ../common/ViewReviews.php');
                    } else {
                        echo '
                        <div class="ContentMessage">
                            <h1>Review Insert Failed.</h1>
                            <a href="../common/AddReview.php" class="GoBack">Go Back</a>
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
                } else {
                    echo '
                    <div class="ContentMessage">
                        <h1>Email Not Found.</h1>
                        <a href="../common/AddReview.php" class="GoBack">Change Email</a>
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