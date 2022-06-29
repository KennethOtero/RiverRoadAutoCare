<html>
    <body>
        <?php
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

                // Test connection
                if ($conn) {
                    // Query
                    $query = 'SELECT intRating, dtmDate, ContactName, strReview FROM vHighestReviews';
                    $result = $conn->query($query);

                    // Loop through all rows and print them
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
                } else {
                        echo "Connection could not be established.<br />";
                        die( print_r( sqlsrv_errors(), true));
                }

                // Close DB connection
                $conn->close();
            } catch (Exception $e) {
                // Display error and exit the script
                echo $e;
                exit;
            }
        ?>
    </body>
</html>