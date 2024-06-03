<?php
    session_start();
    // $_SESSION["userid"] = 123;
    // $_SESSION["username"] = "Guest";
    //session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiSync LOGIN</title>
    <link rel="icon" type="image/x-icon" href="./assets/logisync-logo-color.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/style.css">  
</head>
<body>
    <?php if(isset($_SESSION["OUTPUT"])): ?> 
        <h6><?php echo $_SESSION["OUTPUT"]; ?></h6>
    <?php endif ?> 
    <div class="wrapper landing">
        <div class="">
            <?php if(isset($_SESSION["userid"])): ?>        
                    <span><a href="#">WELCOME, <?php echo $_SESSION["username"]; ?></a></span>
                    <a href="./includes/logout.php" class="btn btn-primary">Logout</a>
            <?php else: ?>
                    <li><a href="#">SIGN UP</a></li>
                    <li><a href="#" class="header-login-a">LOGIN</a></li>
                    <!-- <button class="btn btn-primary">Login</button> -->
                    <a href="./includes/logout.php" class="btn btn-primary">Logout</a>
            <?php endif ?>    
        </div>
        <div class="card m-5">
            <div class="card-header">SIGN UP</div>
            <div class="card-body">
                <p class="">Don't have an account yet? Sign up here!</p>
                <form id="signupForm" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repassword" class="form-label">Re-enter Password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Re-enter your password" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <button  type="submit" name="signup" class="btn btn-primary" >SIGN UP</button>
                </form>
            </div>
        </div>

        <div class="card m-5">
            <div class="card-header">LOGIN</div>
            <div class="card-body">
                <p class="">Don't have an account yet? Sign up here!</p>
                <form id="loginForm" method="post">
                    <div class="mb-3">
                        <label for="usernameLI" class="form-label">Username</label>
                        <input type="text" class="form-control" id="usernameLI" name="usernameLI" placeholder="Enter your username or email" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordLI" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwordLI" name="passwordLI" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary" >LOG IN</button>
                </form>
            </div>
        </div>
        <div class="card"><button type="button" id="guest-btn" class="btn btn-primary">Guest Account</button></div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../backend/index.js"></script>
    <script src="../backend/script.js"></script>
    <script src="../backend/get.js"></script>
    
</body>
</html>
