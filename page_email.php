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
                        <a class="dropdown-item active" href="./page_email.php">Email Contacts <span class="sr-only">(current)</span></a>
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
                <li class="nav-item">
                    <a class="nav-link" href="./page_signup.php">Sign Up</a>
                </li>                    
            </ul>
        </div>
    </nav>
    <div class="container pt-5 pb-2">    
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11 d-flex flex-column flex-md-row justify-content-between align-items-baseline">
                <h2>Add New Contact</h2>
                <p class="text-muted">Sales Rep: <?php echo htmlspecialchars($_SESSION["username"]); ?></p>  
            </div>
        </div>    
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">  
                <?php 
                    require 'contactManager.php';
                    $manager = new ContactManager($_SESSION["email"]);
                    $emails = $manager->getEmails();

                    $send = true;
                    function block($msg, $err) {
                        print <<< HERE
                        <form action="$_SERVER[PHP_SELF]" method="post" class="py-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Sender Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="$_SESSION[username]" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Sender Email</label>
                                        <input type="text" id="email" name="email" class="form-control" placeholder="$_SESSION[email]" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Your Message</label>
                                <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <input type="hidden" name="posted" value="yes" />
                            <div class="row mt-2 align-items-baseline">
                                <div class="col-9">
                                <p class="small text-info">$msg</p>
                                <p class="small text-danger">$err</p>
                                </div>
                                <div class="col-3 text-right">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </form>
HERE;
                    }

                    if (isset($_POST['posted']) != "yes") {
                        block("", "");
                    } else {
                        // check message submitted
                        if ($_POST['message'] == "") {
                            block("", "Please enter a message.");
                            $send = false;
                        }
                        if ($send) {
                            // build the mail to send
                            $toStr = "";
                            foreach($emails as $email) {
                                $toStr .= $email.",";
                            }
                            $to = substr($toStr, 0, -1);
                            $subject = $_POST['subject'];
                            $message = $_POST['message'];
                            $headers  = "From: $_POST[name] < $_POST[email] >\n";
                            $headers .= "Reply-To: $_POST[email]\n";
                            //send the mail
                            mail($to, $subject, $message, $headers);
                            //display confirmation to user
                            block("Your mail has been sent :)", "");
                        } else {
                            //print error messages
                            block("", "Please try again.");
                        }
                    }
                ?>      

            </div>            
        </div>        
    </div>
</body>
</html>