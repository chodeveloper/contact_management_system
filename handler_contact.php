<?php
// fetch the passed request
$request = $_SERVER['QUERY_STRING'];
//parse the request and selected contact
list($action, $selected) = explode('=', $request);



if ($action == "add") {

    if(strlen(trim($_POST['firstname']))<=0 || strlen(trim($_POST['lastname']))<=0){
        header("Location: ./page_add.php");
    } else {
        if (isset($_POST['yearBirth']) && isset($_POST['yearSchool']) && 
            isset($_POST['timeBedHH']) && isset($_POST['timeBedMM']) &&  
            isset($_POST['timeWakeHH']) && isset($_POST['timeWakeMM']) &&
            isset($_POST['timeHomework']) && isset($_POST['timeWatching']) && isset($_POST['timeComputer']) && 
            isset($_POST['timeFamily']) && isset($_POST['timeOutside'])) {
    
            }
        }
    $newContact = new Contact();
}


