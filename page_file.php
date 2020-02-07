<?php
    // no need to check login
    // use filemanager and contactmanager
    require 'fileManager.php';
    $fmanager = new FileManager();
    $fmanager->createCSV();

    $cmanager = new ContactManager();
    $salesreps = $cmanager->getSalesReps();
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Contacts</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="./page_browse.php">Browse/Manage</a>
                        <a class="dropdown-item" href="./page_add.php">Add New</a>
                        <a class="dropdown-item" href="./page_birthday.php">Birthday</a>
                        <a class="dropdown-item" href="./page_email.php">Email Contacts</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="./page_file.php">Admin <span class="sr-only">(current)</span></a>
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
    <div class="container pt-5 pb-2">      
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">                             
                <div class="row justify-content-around">
                    <div class="col-md-5 mb-5">
                        <h3>Import Data</h3>
                        <p class="small text-muted">Upload a file to update client contact information</p>  
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="salesrep">Select sales representative</label>
                                <select class="form-control" id="salesrep" name="salesrep" required>
                                    <?php foreach($salesreps as $id => $name) { if($id == $vars['salesrep_id']) echo "<option value=\"$id\" selected>$name</option>"; else echo "<option value=\"$id\">$name</option>"; }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="csv">
                            </div> 
                            <div class="form-group mt-4">
                                <input type="hidden" name="check" value="yes" />
                                <input type="submit" class="btn btn-primary form-control" name="upload" value="Upload" />
                            </div> 
                        </form> 
                        <?php 

                            // all-in-one form
                            $err = "";
                            $msg = "";
                            if (isset($_POST['check']) == "yes") {
                                if (isset($_FILES['csv'])) {
                                    unset($_SESSION['upload_error']);
                                    $filename = $_FILES['csv']['name'];
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                    if ($ext != "csv") {
                                        $err = "Please upload a CSV file.";
                                    } else {
                                        $err = "";
                                        if (copy($_FILES['csv']['tmp_name'], "./csv/"."update"."(salesrep_id_".$_POST['salesrep'].").csv")) {
                                            $msg = "Your file was successfully uploaded :)";
                                        } else {
                                            $err = "Please try again.";
                                        }
                                    }
                                                                        
                                } else {
                                    $err = "Please select a file to upload.";
            
                                } 
                            }
                            
                        ?>
                        <p class="small text-danger">
                            <?php echo $err;?>
                        </p>    
                        <p class="small text-info">
                            <?php echo $msg;?>
                        </p>                   
                    </div>         
                    <div class="col-md-5">
                        <h3>Export Data</h3>
                        <p class="small text-muted">Download a file containing all client information</p>  
                        <div class="form-group mt-4">
                            <a href="./csv/clientInfo.csv" class="btn btn-primary form-control" download>Download</a>
                        </div>                    
                    </div>
                </div>            
            </div>            
        </div>        
    </div>
</body>
</html>
