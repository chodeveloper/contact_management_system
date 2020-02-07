<?php
// check email username and password inputs
if ((!$_POST['username']) || (!$_POST['password'])) {
    header("Location: ./page_signup.php");
    exit;
}

session_start();

$isValid = true;
$_SESSION['signup_msg'] = "";

// validate username -- email
if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
    $email = trim($_POST["username"]);
    // email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_msg'] .= "Please enter valid email address.<br>";
        $isValid = false;
    } 
    // email length -- maximum 50
    if (strlen($email) > 50) {
        $_SESSION['signup_msg'] .= "Your email address is too long.<br>";
        $isValid = false;
    }  
} else {
    $_SESSION['signup_msg'] .= "Please enter your email address.<br>";
    $isValid = false;
}

// validate first and last name 
if (isset($_POST['firstname']) && !empty(trim($_POST['firstname']))) {
    $firstname = trim($_POST["firstname"]);

    if (strlen($firstname) > 50) {
        $_SESSION['signup_msg'] .= "Your first name is too long.<br>";
        $isValid = false;
    }  
} else {
    $_SESSION['signup_msg'] .= "Please enter your first name.<br>";
    $isValid = false;
}

if (isset($_POST['lastname']) && !empty(trim($_POST['lastname']))) {
    $lastname = trim($_POST["lastname"]);

    if (strlen($lastname) > 50) {
        $_SESSION['signup_msg'] .= "Your last name is too long.<br>";
        $isValid = false;
    }  
} else {
    $_SESSION['signup_msg'] .= "Please enter your last name.<br>";
    $isValid = false;
}

// validate passwords 
if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = $_POST["password"];
    // minimum characters = 8
    if (strlen($_POST["password"]) < 8) {
        $_SESSION['signup_msg'] .= "Your password must contain at least 8 characters.<br>";
        $isValid = false;
    } 
    // is it alphanum only?
    if (!ctype_alnum($password)) {
        // same as preg_match('/^[a-zA-Z0-9]+$/', $var)
        $_SESSION['signup_msg'] .= "Your password must contain only letters or digits.<br>";
        $isValid = false;
    }    
} else {
    $_SESSION['signup_msg'] .= "Please enter your passwords.<br>";
    $isValid = false;
}

if (!$isValid) {
    header('Location: ./page_signup.php');
    exit;
}

//secure login password using hashing and salting
$hashed = password_hash($password, PASSWORD_DEFAULT);
    
//set up database and table names
$db_name = "addressbook";
$table_name = "login";

//connect to MySQL and select database to use
require 'dbConnect.php';

$connection = db_connect() or die(mysqli_error($connection));
$db = mysqli_select_db($connection, $db_name) or die(mysqli_error($connection));

//create SQL statement and issue query
$sql1 = "SELECT id FROM $table_name WHERE username = ?";

if ($stmt1 = mysqli_prepare($connection, $sql1)) {
    mysqli_stmt_bind_param($stmt1, 's', $email); 

    if (mysqli_stmt_execute($stmt1)) {
        mysqli_stmt_store_result($stmt1);

        // if anything found, user should take another username email
        if (mysqli_stmt_num_rows($stmt1) > 0) {
            $_SESSION['signup_msg'] .= "This username is already taken. Please try again.<br>";
            header('Location: ./page_signup.php');
            exit;
        } 
    } else {
        $_SESSION['signup_msg'] .= "Invalid username. Please try again.<br>";
        header('Location: ./page_signup.php');
        exit;
    } 
} 
mysqli_stmt_close($stmt1);

// if all inputs are valid 
$sql2 = "INSERT INTO $table_name (username, password, firstname, lastname) VALUES (?, ?, ?, ?)";
if ($stmt2 = mysqli_prepare($connection, $sql2)) {
    mysqli_stmt_bind_param($stmt2, 'ssss', $email, $hashed, $firstname, $lastname); 
    // insert all info to the table to create a new account!
    if (mysqli_stmt_execute($stmt2)) {    
        $_SESSION['signup_msg'] = "Your account was successfully created :)";
        header('Location: ./page_login.php');

    } else {
        $_SESSION['signup_msg'] .= mysqli_stmt_error($stmt2)."<br>Please try again.<br>";
        header('Location: ./page_signup.php');
        exit;
    } 
} else {
    $_SESSION['signup_msg'] .= mysqli_stmt_error($stmt2)."<br>Please try again.<br>";
    header('Location: ./page_signup.php');
    exit;
}

mysqli_stmt_close($stmt2);
mysqli_close($connection);


