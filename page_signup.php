<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: .");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Address Book</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mb-0 h1" href=".">
            📕 Address Book
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Contacts
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="./page_browse.php">Browse/Manage</a>
                        <a class="dropdown-item" href="./page_add.php">Add New</a>
                        <a class="dropdown-item" href="./page_birthday.php">Birthday</a>
                        <a class="dropdown-item" href="./page_email.php">Email Contacts</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Import Data</a>
                        <a class="dropdown-item" href="#">Export Data</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./page_login.php">Log In</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="./page_signup.php">Sign Up <span class="sr-only">(current)</span></a>
                </li>                    
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row mt-5 p-4 justify-content-center">
            <div class="col-lg-6 col-md-6">
                <h2>Create Your Account</h2>                
                <form class="mt-4" method="post" action="handler_signup.php">
                    <div class="form-group">
                        <label for="username">Email Address</label>
                        <input type="email" class="form-control" name="username" id="username" placeholder="hello@example.com">
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <ul class="small text-muted mt-2">
                            <li>Only letters and digits</li>
                            <li>Minimum 8 characters required</li>
                        </ul>
                    </div>
                    <div class="form-group d-flex justify-content-between align-items-end pt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="small text-info" href="./page_login.php">Already have an account?</a>
                    </div>                    
                </form>
                <p class="small text-danger">
                    <?php 
                        if(isset($_SESSION['signup_msg'])) {
                            echo $_SESSION['signup_msg'];
                            unset($_SESSION['signup_msg']);                
                        }       
                    ?>
                </p>
            </div>            
        </div>        
    </div>
</body>
</html>