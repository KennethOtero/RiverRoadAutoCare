<!DOCTYPE html>
<html>

<head>
  <title>Scheduler</title>
  <link rel="stylesheet" href="../../styles/u_calendar.css">
  <script src="../../scripts/u_calendar.js"></script>
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
          <li><a href="../restricted/LogOut.php">Log Out</a></li>
          <ul>
      </div>
    </div>
  </div>

  <?php
  // If the user is not logged in, redirect to login page
  if ($_SESSION['blnLoggedIn'] == FALSE) {
    // Change to login location
    header('Location: login.php');
  }

  // If the user is logged in as a tech/admin, redirect to admin calendar
  if ($_SESSION['Tech'] == TRUE) {
    header('Location: calendar.php');
  }
  ?>

  <!-- (A) PERIOD SELECTOR -->
  <div id="calPeriod">
    <?php
      // (A1) MONTH SELECTOR
      // NOTE: DEFAULT TO CURRENT SERVER MONTH YEAR
      $months = [
        1 => "January", 2 => "Febuary", 3 => "March", 4 => "April",
        5 => "May", 6 => "June", 7 => "July", 8 => "August",
        9 => "September", 10 => "October", 11 => "November", 12 => "December"
      ];
      $monthNow = date("m");
      echo "<select id='calmonth'>";
      foreach ($months as $m => $mth) {
        printf(
          "<option value='%s'%s>%s</option>",
          $m,
          $m == $monthNow ? " selected" : "",
          $mth
        );
      }
      echo "</select>";

      // (A2) YEAR SELECTOR
      echo "<input type='number' id='calyear' value='" . date("Y") . "'/>";
    ?>
  </div>

  <!-- (B) u_calendar WRAPPER -->
  <div id="calwrap"></div>

  <!-- (C) EVENT FORM -->
  <div id="calblock">
    <form id="calform">
      <input type="hidden" name="req" value="save" />
      <input type="hidden" id="eventid" name="eid" />
      <label for="start">Date Start</label>
      <input type="datetime-local" id="eventstart" name="start" required />
      <label for="end">Date End</label>
      <input type="datetime-local" id="eventend" name="end" required />
      <label for="txt">Requested Services</label>
      <textarea id="eventtxt" name="txt" required></textarea>
      <input type="hidden" id="eventcolor" name="color" value="#e4edff" />
      <input type="submit" id="calformsave" value="Save" />
      <input type="button" id="calformdel" value="Delete" />
      <input type="button" id="calformcx" value="Cancel" />
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

</body>

</html>