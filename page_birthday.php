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
                        <a class="dropdown-item" href="./page_add.php">Add New</a>
                        <a class="dropdown-item active" href="./page_birthday.php">Birthday <span class="sr-only">(current)</span></a>
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
    <div class="container pt-5">
        <div class="row">
            <div class="col d-flex flex-column flex-md-row justify-content-between align-items-baseline">
                <h2>Birthday Contacts List</h2>
                <p class="text-info">Sales Rep: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>  
            </div>
        </div>           
        <div class="row">
            <div class="col">             
                <div class="table-responsive py-4">
                    <table class="table table-hover table-sm small">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>DOB</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require 'contactManager.php';
                                $manager = new ContactManager($_SESSION["email"]);   
                                $contacts = $manager->getBirthdayContacts();
                                $list = "";
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $c) {
                                        $cVars = $c->getVars();
                                        if ($cVars['salesrep_id'] == $manager->getSalesRepId()) {
                                            $list .= "<tr><td>".$cVars['firstname']." ".$cVars['lastname']."</td>";
                                            $list .= "<td>".$cVars['phone']."</td>";
                                            $list .= "<td style=\"word-break:break-all;\">".$cVars['email']."</td>";
                                            $list .= "<td>".$cVars['ad_street']." ".$cVars['ad_city'].", ".$cVars['ad_province']." ".$cVars['ad_postalcode']."</td>";
                                            $list .= "<td>".$cVars['birthday']."</td></tr>";
                                        }                                    
                                    }
                                    echo $list;
                                } else {
                                    echo "<tr><td colspan=5 class=\"text-center\">No Data</td></tr>";
                                }
                                
                            ?>                        
                        </tbody>  
                    </table>
                </div>
            </div>            
        </div>        
    </div>
</body>
</html>
