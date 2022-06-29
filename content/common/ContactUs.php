<!DOCTYPE HTML>
<html>
<head>
    <title>Contact Us</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="river road auto care" />
    <meta name="description" content="Custom auto modifications and repairs." />
    <link rel="stylesheet" href="../../styles/ContactUs.css">
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
                    <li><a href="../restricted/LogOut.php">Logout</a></li>
                <ul>
            </div>
        </div>
    </div>
  
   <div class="Contact-Us">
	    <h1> Address </h1>
        <p>5718 River Road, Cincinnati Ohio 45233</p>
	    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3096.3094096552754!2d-84.66951178518083!3d39.09942534261622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8841c96a3c69d387%3A0xc7676b3b73497164!2s5718%20River%20Rd%2C%20Cincinnati%2C%20OH%2045233!5e0!3m2!1sen!2sus!4v1649809078124!5m2!1sen!2sus" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="Map"></iframe>
	    <h2>Business Hours</h2>
	    <table class="center">
			<tr>
				<th>Sunday</th>
				<td>Closed</td>
			</tr>
			<tr>
				<th>Monday</th>
				<td>10am - 4pm</td>
			</tr>
			<tr>
				<th>Tuesday</th>
				<td>10am - 4pm</td>
			</tr>
			<tr>
				<th>Wednesday</th>
				<td>10am - 4pm</td>
			</tr>
			<tr>
				<th>Thursday</th>
				<td>10am - 4pm</td>
			</tr>
			<tr>
				<th>Friday</th>
				<td>10am - 4pm</td>
			</tr>	
			<tr>
				<th>Saturday</th>
				<td>Closed</td>
			</tr>	
	   </table>
	   <h2>Phone Number</h2>
	   <a href="tel:5139418111">Call us at <u>(513) 941-8111</u></a>
   </div>
   
   <div class="Footer">
	    <div>
            <h3>RIVER ROAD AUTO CARE</h3>
            <ul>
                <li>5718 River Road, Cincinnati Ohio 45233</li>
                <li>(513) 941-8111</li>
                <li>Open 10am to 4pm Mon-Fri</li>
            </ul>
        </div>
    </div>
	
</body>
</html>