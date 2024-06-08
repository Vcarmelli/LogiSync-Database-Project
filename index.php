<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiSync</title>
    <link rel="icon" type="image/x-icon" href="./assets/logisync-logo-color.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/style.css">  
</head>
<body id="homepage" class="landing">
    <div class="wrapper">
        <div class="landing-logo">
            <button id="logo-btn" type="button"><img src="../assets/logisync.png" alt="LogiSync" height="50"></button>
        </div>
        <div id="landing-main" class="flex-column w-50 mt-4 main-desc">
            <div>
                <h1 class="landing-text m-0 mt-5">SUPPLY CHAIN MANAGEMENT</h1>
                <p>Seamlessly integrate suppliers and retailers into a cohesive network, optimizing logistics and minimizing delays. Get started today and unlock new levels of efficiency and success!</p>
                <?php if(isset($_SESSION["username"])): ?>
                    <div class="mx-4">
                        <div class="my-3 pt-4"><a href="./pages/dashboard.php" class="fs-5 dashboard-back">Go back to Dashboard? <?php echo $_SESSION["username"]; ?></a></div>
                        <div><a href="./includes/logout.php" class="btn btn-primary">Logout</a></div>
                    </div>   
                <?php else: ?>
                    <div class="mx-4">
                        <div><a href="#" id="log-btn" class="btn btn-primary my-3">Login as User</a></div>
                        <div><a href="#" id="guest-btn"><i>Continue as Guest</i></a></div>
                    </div>
                        
                <?php endif ?>    
            </div>
        </div>


        <div id="logtypes" class="d-flex flex-column d-none">
            <div class="logtypes-header gap-3 mb-4">
                <div class="logtypes-header-text landing-text">Login</div>
                <ul class="nav nav-underline nav-text">
                    <li class="nav-item">
                        <a href="#" id="admin" class="type-btn nav-link active" aria-current="page">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" id="manager" class="type-btn nav-link" aria-current="page">Manager</a>
                    </li>
                </ul>
            </div>
            
            <div class="logtypes-content">
                <div id="landing-login" class="flex-column">
                    <form id="loginForm" method="post">
                        <div class="mb-3">
                            <label for="usernameLI" class="form-label">Username</label>
                            <input type="text" class="form-control" id="usernameLI" name="usernameLI" placeholder="Enter your username or email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2">
                            <label for="passwordLI" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passwordLI" name="passwordLI" placeholder="Enter your password" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-4 text-center"><a class="account-btn"><i>Don't have an account yet? Sign up here!</i></a></div>
                        <button type="submit" name="login" class="btn btn-primary logsign-btn">LOG IN</button>
                    </form>
                </div>               
            </div>
        </div>

        <div id="landing-signup" class="flex-column d-none">
            <div class="landing-text text-center mb-3">Sign Up</div>
            <form id="signupForm" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-2">
                    <label for="repassword" class="form-label">Re-enter Password</label>
                    <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Re-enter your password" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-4 text-center"><a class="account-btn"><i>Already have an account? Login here!</i></a></div>
                <button type="submit" name="signup" class="btn btn-primary logsign-btn">SIGN UP</button>
            </form>
        </div>
        
            
        
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
