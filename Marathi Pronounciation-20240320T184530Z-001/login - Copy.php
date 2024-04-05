<?php
session_start();
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

if(isset($_POST['college_name'])){
    $name = $_POST['college_name'];
    $password = $_POST['password'];
    $conn = mysqli_connect("localhost","root","","signup");
    if($conn){
        $sql = "select * from users where username='$name' and password='$password'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $_SESSION['admin'] = $name;
            header("Location: ./home.html");
        }
        else{
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
    else{
        echo "<script>alert('Something went wrong');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Admin Login</title>
		<link rel="stylesheet" href="style.css" />
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<style>
			.captchaContainer {
				display: flex;
				justify-content: center;
				align-items: center;
			}
		</style>
		<script>
			let captchaFlag = false;
			const captchaCallback = () => {
				captchaFlag = true;
			};
			window.captchaCallback = captchaCallback;
		</script>
	</head>

	<body>
	<div class="Navbar">
        <a href="aboutus.html"><img src="LElogo.jpg" alt="logo" class="logo"></a>
        <ul>
          <li><a  href="aboutus.html">About us</a></li>
          <li><a href="contactus.html">Contact Us</a></li>
        </ul>
      </div>
		<div class="main-content">
			<div id="formdiv">
			<h1 id="header">Login</h1>
				<form
					id="login-form"
					method="post"
					action="./login.php"
					onsubmit="return checkLogin();"
				>
					<input
						class="adminentry"
						id="name"
                        name="college_name"
						type="text"
						placeholder="Name"
						required
					/>
					<br /><br />
					<input
						class="adminentry"
						id="pass"
                        name="password"
						type="password"
						placeholder="Password"
						required
					/>
					<br />
					<p>do not have a account? <a href="./signup.php">Register</a></p>
					<!-- <br />
					<div class="captchaContainer">
						<div
							id="recaptcha"
							class="g-recaptcha"
							data-callback="captchaCallback"
							data-sitekey="6LfCS-EkAAAAAEPka1ysYwAr4HLyeeqto50prPWz"
						></div>
					</div> -->
					<input class="submit" type="submit" value="login" />
				</form>
			</div>
		</div>
		<script src="adminValidation.js"></script>
		<script type="text/javascript">
			var onloadCallback = function () {
				alert("grecaptcha is ready!");
			};
			const validateName = () => {
				var name = document.getElementById("name").value.length;
				// if (name < 8) {
				// 	return true;
				// }
				return false;
			};
			const validatePass = () => {
				var pass = document.getElementById("pass").value;
				// var passFormat = /[a-zA-Z0-9]*[@#$$%^&?][a-zA-Z0-9]*$/;
				// if (!pass.match(passFormat) || pass.length < 6) {
					// return true;
				// }
				return false;
			};
			const validateCaptcha = () => {
				console.log(captchaFlag);
			};
			const checkLogin = () => {
				if (validateName()) {
					alert("College Name should be more than 8 characters !!");
					return false;
				} else if (validatePass()) {
					alert("Enter a valid password !!");
					return false;
				} 
			};
		</script>
	</body>
</html>
