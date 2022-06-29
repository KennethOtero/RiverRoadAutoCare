<html>
    <body>
        <?php 
            // Check if the session has started
            if (!isset($_SESSION)) {
                // Start the session
                session_start();
            }

            // Create login session variables and set to false
            if (!isset($_SESSION['blnLoggedIn'])) {
                $_SESSION['blnLoggedIn'] = false;
            }

            /* Set user type to default to customer
                - Customer = 1
                - Technician = 2
                - Admin = 3
            */
            if (!isset($_SESSION['intUserType'])) {
                $_SESSION['intUserType'] = 1;
            }

            // Login testing - comment out when finished
            // $_SESSION['blnLoggedIn'] = true;
            // //$_SESSION['intUserTypeID'] = 1;

            // Check if the user is logged in
            if ($_SESSION['blnLoggedIn'] == true) {
                // Load navigation bar based on user type
                if ($_SESSION['intUserType'] == 1) {
                    echo '<li><a onclick="menuToggle()" id="Profile">Profile</a></li>';
                } else if ($_SESSION['intUserType'] == 2) {
                    // Include 'tech only' profile menu along with JS here
                    echo '<li><a onclick="menuToggle()" id="Profile">Profile</a></li>';
                } else if ($_SESSION['intUserType'] == 3) {
                    echo '<li><a onclick="menuToggle()" id="Profile">Profile</a></li>';
                }
            } else {
                echo '<li><a href="http://itd1.cincinnatistate.edu/CPDM-OteroK/content/common/login.php" id="Login">Sign In</a></li>';
            }
        ?>
    </body>
</html>