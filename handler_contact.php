<?php
// fetch the passed request
$request = $_SERVER['QUERY_STRING'];
//parse the request and selected contact
list($action, $selected) = explode('=', $request);

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: ./page_login.php");
    exit;
}

require 'contactManager.php';
$manager = new ContactManager();

if ($action == "add" || $action == "edit") {
    if(strlen(trim($_POST['firstname']))<=0 || strlen(trim($_POST['lastname']))<=0 ||
       strlen(trim($_POST['phone']))<=0 || strlen(trim($_POST['email']))<=0 ||
       strlen(trim($_POST['ad_street']))<=0 || strlen(trim($_POST['ad_city']))<=0 ||
       strlen(trim($_POST['ad_prov']))<=0 || strlen(trim($_POST['ad_code']))<=0 ||
       $_POST['year']==0 || $_POST['month']==0 || $_POST['day']==0){
        $_SESSION['submit_error'] = "Please enter valid data.<br>Do not leave any boxes blank.";
        header("Location: ./page_add.php");
    } else {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && 
            isset($_POST['phone']) && isset($_POST['email']) &&  
            isset($_POST['ad_street']) && isset($_POST['ad_city']) &&
            isset($_POST['ad_prov']) && isset($_POST['ad_code']) && isset($_POST['year']) && 
            isset($_POST['month']) && isset($_POST['day'])) {

            $birthday = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

            if ($action == "add") {
                $salesrepId = $manager->getSalesRepId();
                $newContact = new Contact(0, $_POST['firstname'], $_POST['lastname'], $_POST['phone'], 
                                        $_POST['email'], $_POST['ad_street'], $_POST['ad_city'],
                                        $_POST['ad_prov'], $_POST['ad_code'], $birthday, $salesrepId);

                if ($manager->addContact($newContact)) {
                    $_SESSION['submit_msg'] = "Your new contact data was successfully added :)";
                    header("Location: ./page_add.php");
                } else {
                    $_SESSION['submit_error'] = "Please try again.";
                    header("Location: ./page_add.php");
                }   
            } else {
                
                $editedContact = new Contact($selected, $_POST['firstname'], $_POST['lastname'], $_POST['phone'], 
                                        $_POST['email'], $_POST['ad_street'], $_POST['ad_city'],
                                        $_POST['ad_prov'], $_POST['ad_code'], $birthday, $_POST['salesrep']);

                if ($manager->modifyContact($editedContact)) {
                    $_SESSION['submit_msg'] = "Your contact data was successfully modified :)";
                    header("Location: ./page_browse.php");
                } else {
                    $_SESSION['submit_error'] = "Please try again.";
                    header("Location: ./page_edit.php?id=$selected");
                }   
            }           
        }
    }   

} elseif ($action == "delete") {
    if ($manager->deleteContact($selected)) {
        $_SESSION['submit_msg'] = "Your contact data was successfully deleted :)";
        header("Location: ./page_browse.php");
    } else {
        $_SESSION['submit_error'] = "Please try again.";
        header("Location: ./page_delete.php?id=$selected");
    }  
}


