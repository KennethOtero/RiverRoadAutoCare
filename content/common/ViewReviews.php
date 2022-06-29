<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="../../styles/ViewReviews.css">
    <script src="../../scripts/ProfileMenu.js"></script>
</head>

<body>
    <?php
    // Check if the session has started
    if (!isset($_SESSION)) {
        // Start the session
        session_start();
    }
    ?>
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
                    <li><a href="../restricted/LogOut.php">Log Out</a></li>
                    <ul>
            </div>
        </div>
    </div>

    <?php 
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

        // Display errors
        if(TRUE) // toggle to false after debugging
        {
          ini_set( 'display_errors', 'true');
          error_reporting(-1);
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
                // Get average rating
                $sql = "SELECT Rating FROM vViewAverageRating";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $AverageRating = $row['Rating'];
                    // Remove decimal places, since it is rounding to a whole number,
                    // the average review may seem to be 'incorrect'. Rounding to a whole number is
                    // necessary to populate the average star rating on the Reviews page.
                    $AverageRating = round($AverageRating, 0);
                }

                // Get total ratings
                $sql = "SELECT COUNT(intReviewID) as Ratings FROM TReviews";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $TotalRatings = $row['Ratings'];
                }

                // Get number of each star rating (1-5)
                // Get the count of 1 star ratings
                $sql = "SELECT COUNT(intRating) as OneStar FROM TReviews WHERE intRating = 1";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $OneStarRating = $row['OneStar'];
                }
                // Get the count of 2 star ratings
                $sql = "SELECT COUNT(intRating) as TwoStar FROM TReviews WHERE intRating = 2";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $TwoStarRating = $row['TwoStar'];
                }
                // Get the count of 3 star ratings
                $sql = "SELECT COUNT(intRating) as ThreeStar FROM TReviews WHERE intRating = 3";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $ThreeStarRating = $row['ThreeStar'];
                }
                // Get the count of 4 star ratings
                $sql = "SELECT COUNT(intRating) as FourStar FROM TReviews WHERE intRating = 4";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $FourStarRating = $row['FourStar'];
                }
                // Get the count of 5 star ratings
                $sql = "SELECT COUNT(intRating) as FiveStar FROM TReviews WHERE intRating = 5";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $FiveStarRating = $row['FiveStar'];
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    ?>

    <div class="AverageRating">
        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <span class="heading">User Rating</span>
        <?php
            // Load star rating based on intRating
            if ($AverageRating == 0) {
                echo 
                '
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                ';
            } else if ($AverageRating == 1) {
                echo 
                '
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                ';
            } else if ($AverageRating == 2) {
                echo 
                '
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                ';
            } else if ($AverageRating == 3) {
                echo 
                '
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                ';
            } else if ($AverageRating == 4) {
                echo 
                '
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                ';
            } else if ($AverageRating == 5) {
                echo 
                '
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                ';
            }

            // Calculate percentage values from ratings compared to total ratings
            $OneStarPercentage = round(($OneStarRating / $TotalRatings) * 100, 0);
            $TwoStarPercentage = round(($TwoStarRating / $TotalRatings) * 100, 0);
            $ThreeStarPercentage = round(($ThreeStarRating / $TotalRatings) * 100, 0);
            $FourStarPercentage = round(($FourStarRating / $TotalRatings) * 100, 0);
            $FiveStarPercentage = round(($FiveStarRating / $TotalRatings) * 100, 0);
        ?>
        <p><?php echo $AverageRating;?> star average based on <?php echo $TotalRatings;?> reviews.</p>
        <hr style="border:3px solid #f1f1f1">
        <div class="row">
            <div class="side">
                <div>5 star</div>
            </div>
            <div class="middle">
                <div class="bar-container">
                    <div class="bar-5">
                        <?php 
                            echo '<style>
                                    .bar-5 {
                                        width: ' . $FiveStarPercentage . '%;
                                        height: 18px;
                                        background-color: #0075db;
                                    }
                                  </style>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="side right">
                <div><?php echo $FiveStarRating;?></div>
            </div>
            <div class="side">
                <div>4 star</div>
            </div>
            <div class="middle">
                <div class="bar-container">
                    <div class="bar-4">
                        <?php 
                            echo '<style>
                                    .bar-4 {
                                        width: ' . $FourStarPercentage . '%;
                                        height: 18px;
                                        background-color: #0075db;
                                    }
                                  </style>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="side right">
                <div><?php echo $FourStarRating;?></div>
            </div>
            <div class="side">
                <div>3 star</div>
            </div>
            <div class="middle">
                <div class="bar-container">
                    <div class="bar-3">
                        <?php 
                            echo '<style>
                                    .bar-3 {
                                        width: ' . $ThreeStarPercentage . '%;
                                        height: 18px;
                                        background-color: #0075db;
                                    }
                                  </style>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="side right">
                <div><?php echo $ThreeStarRating;?></div>
            </div>
            <div class="side">
                <div>2 star</div>
            </div>
            <div class="middle">
                <div class="bar-container">
                    <div class="bar-2">
                        <?php 
                            echo '<style>
                                    .bar-2 {
                                        width: ' . $TwoStarPercentage . '%;
                                        height: 18px;
                                        background-color: #0075db;
                                    }
                                  </style>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="side right">
                <div><?php echo $TwoStarRating;?></div>
            </div>
            <div class="side">
                <div>1 star</div>
            </div>
            <div class="middle">
                <div class="bar-container">
                    <div class="bar-1">
                        <?php 
                            echo '<style>
                                    .bar-1 {
                                        width: ' . $OneStarPercentage . '%;
                                        height: 18px;
                                        background-color: #0075db;
                                    }
                                  </style>';
                        ?>
                    </div>
                </div>
            </div>
            <div class="side right">
                <div><?php echo $OneStarRating;?></div>
            </div>
        </div>
    </div>

    <div class="RatingSelection">
            <form action="" method="POST" name="frmSelect" id="frmSelect">
                Sort Reviews
                <select id="ReviewSelect" name="ReviewSelect">
                    <option value="" selected="selected"></option>
                    <option value="HighToLow">Highest to Lowest</option>
                    <option value="LowToHigh">Lowest to Highest</option>
                </select>
                <a href="ViewReviews.php"><input type="submit" name="btnSubmit" id="btnSubmit" value="Update Reviews"></a>
            </form>
    </div>

    <hr class="ReviewSeparator">

    <div class="RatingsList">
            <?php 
                // Get review selection
                if (isset($_POST['ReviewSelect'])) {
                    $Selected = $_POST['ReviewSelect'];
                } else {
                    $Selected = "";
                }

                // Load reviews from highest to lowest (the default view)
                if ($Selected == 'HighToLow' || $Selected == "") {
                    // Get highest to lowest reviews, limit 50
                    $sql = "SELECT
                                TR.intReviewID
                                ,TR.strReview
                                ,TR.dtmDate
                                ,TR.intRating
                                ,TRT.strReviewType
                                ,TU.intUserID
                                ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
                            FROM
                                TReviews as TR JOIN TUsers as TU
                                    ON TR.intUserID = TU.intUserID
                                JOIN TReviewTypes as TRT
                                    ON TRT.intReviewTypeID = TR.intReviewTypeID
                            ORDER BY 
                                TR.intRating DESC LIMIT 50";
                    $result = $conn->query($sql);

                    // Formatting
                    echo '<h1>Highest Rated Reviews</h1>';

                    while ($obj = $result->fetch_assoc()) {
                        // Print each review div
                        echo '<div class="Review"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
                        // Grab the rating
                        $rating = $obj['intRating'];
    
                        // Load star rating based on intRating
                        if ($rating == 0) {
                            echo 
                            '
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 1) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 2) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 3) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 4) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 5) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            ';
                        }
    
                        // Load date and format it into Day/Month/Year
                        echo '<p class="date">';
                        $Date = strtotime($obj["dtmDate"]);
                        $Date = date('m-d-Y', $Date);
                        echo $Date;
                        echo '</p>';
    
                        // Load name
                        echo '<h3>';
                        echo $obj['ContactName'];
                        echo '</h3>';
    
                        // Load review
                        echo '<p>';
                        echo $obj['strReview'];
                        echo '</p> </div>';
                    }
                }

                // Get lowest to highest reviews, limit 50
                if ($Selected == 'LowToHigh') {
                    // Get lowest to highest reviews, limit 50
                    $sql = "SELECT
                                TR.intReviewID
                                ,TR.strReview
                                ,TR.dtmDate
                                ,TR.intRating
                                ,TRT.strReviewType
                                ,TU.intUserID
                                ,CONCAT(TU.strFirstName,' ',TU.strLastName) as ContactName
                            FROM
                                TReviews as TR JOIN TUsers as TU
                                    ON TR.intUserID = TU.intUserID
                                JOIN TReviewTypes as TRT
                                    ON TRT.intReviewTypeID = TR.intReviewTypeID
                            ORDER BY 
                                TR.intRating ASC LIMIT 50";
                    $result = $conn->query($sql);

                    // Formatting
                    echo '<h1>Lowest Rated Reviews</h1>';

                    while ($obj = $result->fetch_assoc()) {
                        // Print each review div
                        echo '<div class="Review"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
                        // Grab the rating
                        $rating = $obj['intRating'];
    
                        // Load star rating based on intRating
                        if ($rating == 0) {
                            echo 
                            '
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 1) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 2) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 3) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 4) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            ';
                        } else if ($rating == 5) {
                            echo 
                            '
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            ';
                        }
    
                        // Load date and format it into Day/Month/Year
                        echo '<p class="date">';
                        $Date = strtotime($obj["dtmDate"]);
                        $Date = date('m-d-Y', $Date);
                        echo $Date;
                        echo '</p>';
    
                        // Load name
                        echo '<h3>';
                        echo $obj['ContactName'];
                        echo '</h3>';
    
                        // Load review
                        echo '<p>';
                        echo $obj['strReview'];
                        echo '</p> </div>';
                    }
                }

                // Close database connection
                $conn->close();
            ?>
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