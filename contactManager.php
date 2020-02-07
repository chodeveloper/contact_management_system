<?php

require 'contact.php';

class ContactManager {

    private $_salesrepId;
    //set up database and table names
    private $db_name = "addressbook";
    private $table_name = "contacts";

    public function __construct($username) {
        //connect to MySQL and select database to use
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());

        $sql = "SELECT * FROM login WHERE username = ?";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username); 

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);

        $row = mysqli_fetch_array($result);
        $this->_salesrepId = $row['id'];
    }

    public function getSalesRepId() {
        return $this->_salesrepId;
    }

    public function browseContacts() {
        $contacts = array();
        //connect to MySQL and select database to use
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());

        $sql = "SELECT * FROM $this->table_name WHERE salesrep_id = $this->_salesrepId";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);

        while ($row = mysqli_fetch_array($result)) {
            $contact = new Contact($row['id'], stripslashes($row['firstname']), stripslashes($row['lastname']),
                                    stripslashes($row['phone']), stripslashes($row['email']),
                                    stripslashes($row['address_street']), stripslashes($row['address_city']), stripslashes($row['address_province']),
                                    stripslashes($row['address_postalcode']), stripslashes($row['birthday']), stripslashes($row['salesrep_id']));

            array_push($contacts, $contact);
        }
        return $contacts;
    }

    public function getContact($id) {

        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());

        $sql = "SELECT * FROM $this->table_name WHERE salesrep_id = $this->_salesrepId AND id = ?";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id); 
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);

        $row = mysqli_fetch_array($result);
        $contact = new Contact($row['id'], stripslashes($row['firstname']), stripslashes($row['lastname']),
                                stripslashes($row['phone']), stripslashes($row['email']),
                                stripslashes($row['address_street']), stripslashes($row['address_city']), stripslashes($row['address_province']),
                                stripslashes($row['address_postalcode']), stripslashes($row['birthday']), stripslashes($row['salesrep_id']));

        return $contact;
    }

    public function getBirthdayContacts() {
        $bdayContacts = array();
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());

        $month = date("n");

        $sql = "SELECT * FROM $this->table_name WHERE salesrep_id = $this->_salesrepId AND MONTH(birthday) = $month";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);

        while ($row = mysqli_fetch_array($result)) {
            $contact = new Contact($row['id'], stripslashes($row['firstname']), stripslashes($row['lastname']),
                                    stripslashes($row['phone']), stripslashes($row['email']),
                                    stripslashes($row['address_street']), stripslashes($row['address_city']), stripslashes($row['address_province']),
                                    stripslashes($row['address_postalcode']), stripslashes($row['birthday']), stripslashes($row['salesrep_id']));

            array_push($bdayContacts, $contact);
        }

        return $bdayContacts;
    }

    public function addContact(Contact $new) {
        //connect to MySQL and select database to use
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());

        $sql = "INSERT INTO $this->table_name (firstname, lastname, phone, email, address_street, address_city, address_province, address_postalcode, birthday, salesrep_id) VALUES (?,?,?,?,?,?,?,?,?,?)";


        if ($stmt = mysqli_prepare($connection, $sql)) {
            $vars = $new->getVars();
            mysqli_stmt_bind_param($stmt, 'sssssssssi', $vars['firstname'], $vars['lastname'], $vars['phone'], $vars['email'],
                                $vars['ad_street'], $vars['ad_city'], $vars['ad_province'], $vars['ad_postalcode'],
                                $vars['birthday'], $this->_salesrepId); 

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return true;
            } 
        } 
        mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        return false;
    }

    public function modifyContact(Contact $selected) {
        //connect to MySQL and select database to use
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());
        $selectedId = $selected['id'];

        $sql = "UPDATE $this->table_name SET firstname = ?, lastname = ?, phone = ?, email = ?, address_street = ?, address_city = ?, address_provice = ?, address_postalcode 
        birtyday = ?) WHERE id = $selectedId";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssssssss', $selected['firstname'], $selected['lastname'], $selected['phone'], $selected['email'],
                                $selected['address_street'], $selected['address_city'], $selected['address_provice'], $selected['address_postalcode'],
                                $selected['birthday']); 

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);
    }

    public function deleteContact(Contact $selected) {
        //connect to MySQL and select database to use
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());
        $selectedId = $selected['id'];

        $sql = "DELETE FROM $this->table_name WHERE id = $selectedId";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);
    }

    public function exportContacts($csv) {
        
    }

    public function importContacts($csv) {

    }
}