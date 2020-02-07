<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: ./page_login.php");
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
    <script src="https://kit.fontawesome.com/6202e2ac09.js"></script>
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
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Contacts <span class="sr-only">(current)</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item active" href="./page_browse.php">Browse/Manage <span class="sr-only">(current)</span></a>
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
                    <a class="nav-link" href="./handler_logout.php">Log Out</a>
                </li>                    
            </ul>
        </div>
    </nav>
    <div class="container py-5">    
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11 d-flex flex-column flex-md-row justify-content-between align-items-baseline">
                <h2>Delete Contact</h2>
                <p class="text-muted">Sales Rep: <?php echo htmlspecialchars($_SESSION["username"]); ?></p>  
            </div>
        </div>    
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">   
                <?php 
                    // fetch the passed request
                    $request = $_SERVER['QUERY_STRING'];
                    //parse the request and selected contact
                    list($var, $selected) = explode('=', $request);

                    if ($var != "id" || !ctype_digit($selected)) {
                        header("Location: ./page_browse.php");
                        exit;
                    }
                    require 'contactManager.php';
                    $manager = new ContactManager($_SESSION["email"]);
                    $vars = $manager->getContact($selected)->getVars();
                ?>                          
                <form action="handler_contact.php?delete=<?php echo $selected; ?>" method="post" class="py-4">
                    <div class="row">
                        <div class="col">
                            Do you really want to delete the contact of 
                            <?php echo "<span class=\"font-weight-bold\">".$vars['firstname']." ".$vars['lastname']."</span>"?>?
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-right">
                            <input type="submit" class="btn btn-danger" value="Delete">
                            <a href="./page_browse.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
                <p class="small text-danger">
                    <?php 
                        if(isset($_SESSION['submit_error'])) {
                            echo $_SESSION['submit_error'];
                            unset($_SESSION['submit_error']);                
                        }       
                    ?>
                </p>
            </div>            
        </div>        
    </div>
</body>
</html>
