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
                        <a class="dropdown-item" href="./page_browse.php">Browse/Manage</a>
                        <a class="dropdown-item active" href="./page_add.php">Add New <span class="sr-only">(current)</span></a>
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
        <div class="row">
            <div class="col-md">
                <h2>Add New Contact</h2>
                <br>
                <p class="text-info">Sales Rep: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>                
                <form action="handler_contact.php?add=" method="post" class="py-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="form-row">
                                    <div class="col">
                                        <select class="form-control" id="year" name="year" required>
                                            <?php for($i=2000;$i>1959;$i--) { if($i==1970) echo "<option value=\"$i\" selected>$i</option>"; else echo "<option value=\"$i\">$i</option>"; } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="month" name="month" required>
                                            <?php for($i=1;$i<=12;$i++) { if($i<10) $m = "0".$i; else $m = $i; echo "<option value=\"$m\">$m</option>"; } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="day" name="day" required>
                                            <?php for($i=1;$i<=31;$i++) { if($i<10) $m = "0".$i; else $m = $i; echo "<option value=\"$m\">$m</option>"; } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ad_street">Street Address</label>
                                <input type="text" class="form-control" id="ad_street" name="ad_street" required>
                            </div>
                            <div class="form-group">
                                <label for="ad_city">City</label>
                                <input type="text" class="form-control" id="ad_city" name="ad_city" required>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="ad_prov">Province</label>
                                        <input type="text" class="form-control" id="ad_prov" name="ad_prov" required>
                                    </div>
                                    <div class="col">
                                        <label for="ad_code">Postal Code</label>
                                        <input type="text" class="form-control" id="ad_code" name="ad_code" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-right">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </form>
            </div>            
        </div>        
    </div>
</body>
</html>
