<?php
// check email username and password
if ((!$_POST['username']) || (!$_POST['password'])) {
    header("Location: ./page_login.php");
    exit;
}
session_start();

$isValid = true;
$_SESSION['login_error'] = "";

// validate username -- email
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $email = $_POST["username"];
    // email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] .= "Please enter valid email address.<br>";
        $isValid = false;
    } 
} else {
    $_SESSION['login_error'] .= "Please enter your email address.<br>";
    $isValid = false;
}

// validate password
if (isset($_POST['password']) && !empty($_POST['password'])) {
    // check minimum length
    $password = $_POST["password"];
    if (strlen($_POST["password"]) < 8) {
        $_SESSION['login_error'] .= "Your password must contain at least 8 characters.<br>";
        $isValid = false;
    } 
    // check characters
    if (!ctype_alnum($password)) {
        // same as preg_match('/^[a-zA-Z0-9]+$/', $var)
        $_SESSION['login_error'] .= "Your password must contain only letters or digits.<br>";
        $isValid = false;
    }    
} else {
    $_SESSION['login_error'] .= "Please enter your passwords.<br>";
    $isValid = false;
}

if (!$isValid) {
    header('Location: ./page_login.php');
    exit;
}
   
//set up database and table names
$db_name = "addressbook";
$table_name = "login";

//connect to MySQL and select database to use
require 'dbConnect.php';

$connection = db_connect() or die(mysqli_error($connection));
$db = mysqli_select_db($connection, $db_name) or die(mysqli_error($connection));


//create SQL statement and issue query
$sql = "SELECT username, password, firstname, lastname FROM $table_name WHERE username = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $email); 

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            
            mysqli_stmt_bind_result($stmt, $username, $hashedPw, $fn, $ln);
            
            if (mysqli_stmt_fetch($stmt)) {
                // if password is verified
                if (password_verify($password, $hashedPw)) {
                    // store useful data in session
                    unset($_SESSION['login_error']);                    
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $username;  
                    $_SESSION['username'] = $fn." ".$ln;  
                    header('Location: .');      
                } else {
                    $_SESSION['login_error'] .= "Email address and/or passwords are incorrect. Please try again.<br>";
                    header('Location: ./page_login.php');
                    exit;
                }
            }
            
        } else {
            $_SESSION['login_error'] .= "Email address and/or passwords are incorrect. Please try again.<br>";
            header('Location: ./page_login.php');
            exit;
        }
    
    } else {
        $_SESSION['login_error'] .= "Something went wrong. Please try again.<br>";
        header('Location: ./page_login.php');
        exit;
    } 
}

mysqli_stmt_close($stmt);
mysqli_close($link);


