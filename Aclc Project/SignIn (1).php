<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="SignIn.css">
</head>
<body>
    <!-- SIGN IN FORM-->
     <!--Header-->
    <div class="container">
          <div class="signin_form">
          <div class="circle_icon">
                <span></span>
            </div>
            <h2>Sign In</h2>
        <form action="" method="POST">
            <div class="label_container">
                <label for="Username">Username</label>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="label_container">
                <label for="Password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="check_option">
                <div class="check">
                    <input type="checkbox" name="check" id="check">
                    <label for="checkbox">Remember Password</label>
                </div>
                <div class="check">
                    <p><a href="#">Forgot Password ?</a></p>
                </div>
            </div>
            <div class="submit">
                <input type="button" value="SignIn">
            </div>
            
        </form>
          </div>
    </div>
</body>
</html>