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
                <h2>Add New Contact</h2>
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
                    $year = explode("-", $vars['birthday'])[0];
                    $month = explode("-", $vars['birthday'])[1];
                    $day = explode("-", $vars['birthday'])[2];
                    $salesreps = $manager->getSalesReps();
                ?>
                <form action="handler_contact.php?edit=<?php echo $vars['id']; ?>" method="post" class="py-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $vars['firstname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $vars['lastname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $vars['phone']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $vars['email']; ?>" required>
                            </div>
                        </div>         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ad_street">Street Address</label>
                                <input type="text" class="form-control" id="ad_street" name="ad_street" value="<?php echo $vars['ad_street']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ad_city">City</label>
                                <input type="text" class="form-control" id="ad_city" name="ad_city" value="<?php echo $vars['ad_city']; ?>" required>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="ad_prov">Province</label>
                                        <input type="text" class="form-control" id="ad_prov" name="ad_prov" value="<?php echo $vars['ad_province']; ?>" required>
                                    </div>
                                    <div class="col">
                                        <label for="ad_code">Postal Code</label>
                                        <input type="text" class="form-control" id="ad_code" name="ad_code" value="<?php echo $vars['ad_postalcode']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="form-row">
                                    <div class="col">
                                        <select class="form-control" id="year" name="year" required>
                                            <?php for($i=1960;$i<=2000;$i++) { if($year == $i) echo "<option value=\"$i\" selected>$i</option>"; else echo "<option value=\"$i\">$i</option>"; }?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="month" name="month" required>
                                            <?php for($i=1;$i<=12;$i++) { 
                                                if($i<10) $m = "0".$i; else $m = $i;  
                                                if($month == $m) echo "<option value=\"$m\" selected>$m</option>"; else echo "<option value=\"$m\">$m</option>"; 
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="day" name="day" required>
                                            <?php for($i=1;$i<=31;$i++) { 
                                                if($i<10) $m = "0".$i; else $m = $i;  
                                                if($day == $m) echo "<option value=\"$m\" selected>$m</option>"; else echo "<option value=\"$m\">$m</option>";
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="salesrep">Sales Representative</label>
                                <select class="form-control" id="salesrep" name="salesrep" required>
                                    <?php foreach($salesreps as $id => $name) { if($id == $vars['salesrep_id']) echo "<option value=\"$id\" selected>$name</option>"; else echo "<option value=\"$id\">$name</option>"; }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 align-items-baseline">
                        <div class="col">
                            <p class="small text-danger">
                                <?php 
                                    if(isset($_SESSION['submit_error'])) {
                                        echo $_SESSION['submit_error'];
                                        unset($_SESSION['submit_error']);                
                                    }       
                                ?>
                            </p>
                        </div>
                        <div class="col text-right">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="./page_browse.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
                
            </div>            
        </div>        
    </div>
</body>
</html>
