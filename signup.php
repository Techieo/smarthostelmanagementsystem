<?php
include("db_connect.php");

$firstName = $lastName = $email = $password = $confirmPassword = "";
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMsg = ""; // <-- New variable for success message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars(stripslashes(trim($_POST["first_name"])));
    $lastName = htmlspecialchars(stripslashes(trim($_POST["last_name"])));
    $email = htmlspecialchars(stripslashes(trim($_POST["email"])));
    $password = htmlspecialchars(stripslashes(trim($_POST["password"])));
    $confirmPassword = htmlspecialchars(stripslashes(trim($_POST["confirm_password"])));

    if (empty($firstName)) { $firstNameErr = "First name is required"; }
    if (empty($lastName)) { $lastNameErr = "Last name is required"; }
    if (empty($email)) { $emailErr = "Email is required"; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $emailErr = "Invalid email format"; }
    if (empty($password)) { $passwordErr = "Password is required"; }
    elseif (strlen($password) < 6) { $passwordErr = "Password must be at least 6 characters"; }
    if (empty($confirmPassword)) { $confirmPasswordErr = "Please confirm your password"; }
    elseif ($password !== $confirmPassword) { $confirmPasswordErr = "Passwords do not match"; }

    if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        // Check if email exists
        $checkEmail = "SELECT * FROM students WHERE personal_email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            $emailErr = "Email already registered";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO students (first_name, last_name, personal_email, password, created_at, updated_at) 
                    VALUES ('$firstName', '$lastName', '$email', '$hashedPassword', NOW(), NOW())";

            if ($conn->query($sql) === TRUE) {
                $successMsg = " Account registered successfully! Redirecting to login...";
                // Redirect after 3 seconds
                header("refresh:3;url=login.php");
            } else {
                $successMsg = "❌ Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>


 



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="description"
      content="Smart Hostel Management System - Account Registration"
    />
    <meta name="author" content="Alex Kihara" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="Img/favicon.jpg" />
    <link rel="stylesheet" href="CASCADINGSTYLES/signup_student.css">
    <script src="JAVASCRIPT_SHMS/signup_student.js" defer></script>

    <title>Sign Up | Smart Hostel Management System</title>
  </head>

  <body>
    <div class="signup-container">
      <!-- Left Image Section -->
      <div class="signup-image">
        <img src="Img/UI.jpg" alt="Registration Interface" />
      </div>

      <!-- Right Form Section -->
      <div class="signup-form">
        <header>
          <h1>Account Registration</h1>
          <br />
          <p>To sign up, kindly fill the form below.</p>
        </header>
        <?php if(!empty($successMsg)): ?>
    <div class="success-message" style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:15px;">
        <?php echo $successMsg; ?>
    </div>
<?php endif; ?>

        <form action="signup.php" method="POST" autocomplete="off">
  <div>
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" placeholder="Enter your first name"
           value="<?php echo $firstName; ?>"  />
    <span class="error"><?php echo $firstNameErr; ?></span>
  </div>

  <div>
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name"
           value="<?php echo $lastName; ?>"  />
    <span class="error"><?php echo $lastNameErr; ?></span>
  </div>

  <div>
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" placeholder="Enter your email address"
           value="<?php echo $email; ?>"  />
    <span class="error"><?php echo $emailErr; ?></span>
  </div>

  <div class="password-wrapper">
    <label for="password">Enter Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password"  />
    <span class="error"><?php echo $passwordErr; ?></span>
  </div>

  <div class="password-wrapper">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" />
    <span class="error"><?php echo $confirmPasswordErr; ?></span>
  </div>

  <button type="submit">Register Account</button>
</form>
<footer>
            <p>
                Already have an account?
                <a class="forgotpassword_link" href="login.php">Log in</a>
            </p>
        </footer>
    </div>
</div>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>
