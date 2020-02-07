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
                <li class="nav-item">
                    <a class="nav-link" href="./page_file.php">Admin</a>
                </li>
                <?php
                    session_start();
                    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                        print <<<HERE
                        <li class="nav-item">
                            <a class="nav-link" href="./page_login.php">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./page_signup.php">Sign Up</a>
                        </li>
HERE;
                    } else {
                        print <<<HERE
                        <li class="nav-item">
                            <a class="nav-link" href="./handler_logout.php">Log Out</a>
                        </li>
HERE;
                    }
                ?>
                
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md">
                <?php
                    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                        echo "<h1>Hello!</h1><br>";
                        echo "<h5>Please sign in to use My Contacts menu</h5>";
                    } else {
                        echo "<h1>Hello, ".htmlspecialchars($_SESSION["username"])."!</h1>";                        
                    }
                ?>
            </div>            
        </div>        
    </div>
</body>
</html>
