<?php

require 'contact.php';
require 'dbConnect.php';

class ContactManager {

    //set up database and table names
    private $db_name = "addressbook";
    private $table_name = "contacts";
    private $connection;
    private $db;

    public function __construct() {
        //connect to MySQL and select database to use        
        $this->connection = db_connect() or die(mysqli_error($this->connection));
        $this->db = mysqli_select_db($this->connection, $this->db_name) or die(mysql_error());
    }

    public function getSalesRepId() {
        $sql = "SELECT * FROM login WHERE username = ?";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $_SESSION["email"]); 

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);

        $row = mysqli_fetch_array($result);
        return $row['id'];        
    }

    public function getSalesReps() {

        $sales = array();
        $sql = "SELECT id, firstname, lastname FROM login";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);
        
        while ($row = mysqli_fetch_array($result)) { 
            $sales[$row['id']] = $row['firstname']." ".$row['lastname'];
        }
        return $sales;
    }

    public function browseContacts() {
        $contacts = array();
        $salesrepId = $this->getSalesRepId();
        
        $sql = "SELECT * FROM $this->table_name WHERE salesrep_id = $salesrepId";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
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

    public function browseAllContacts() {
        $contacts = array();
        
        $sql = "SELECT * FROM $this->table_name";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
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
        $salesrepId = $this->getSalesRepId();
        $sql = "SELECT * FROM $this->table_name WHERE salesrep_id = $salesrepId AND id = ?";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
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
        $month = date("n");
        $salesrepId = $this->getSalesRepId();
        $sql = "SELECT * FROM $this->table_name WHERE salesrep_id = $salesrepId AND MONTH(birthday) = $month";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
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
        $salesrepId = $this->getSalesRepId();
        
        $sql = "INSERT INTO $this->table_name (firstname, lastname, phone, email, address_street, address_city, address_province, address_postalcode, birthday, salesrep_id) VALUES (?,?,?,?,?,?,?,?,?,?)";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
            $vars = $new->getVars();
            mysqli_stmt_bind_param($stmt, 'sssssssssi', $vars['firstname'], $vars['lastname'], $vars['phone'], $vars['email'],
                                $vars['ad_street'], $vars['ad_city'], $vars['ad_province'], $vars['ad_postalcode'],
                                $vars['birthday'], $salesrepId); 

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

        $sql = "UPDATE $this->table_name SET firstname=?, lastname=?, phone=?, email=?, address_street=?, address_city=?, address_province=?, address_postalcode=?, birthday=?, salesrep_id=? WHERE id=?";
        $vars = $selected->getVars();
        if ($stmt = mysqli_prepare($this->connection, $sql)) {

            mysqli_stmt_bind_param($stmt, 'sssssssssii', $vars['firstname'], $vars['lastname'], $vars['phone'], $vars['email'],
                                $vars['ad_street'], $vars['ad_city'], $vars['ad_province'], $vars['ad_postalcode'],
                                $vars['birthday'], $vars['salesrep_id'], $vars['id']); 

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

    public function deleteContact($selected) {
        
        $sql = "DELETE FROM $this->table_name WHERE id = ?";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $selected); 

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

    public function getEmails() {
        $emails = array();
        $salesrepId = $this->getSalesRepId();

        $sql = "SELECT email FROM $this->table_name WHERE salesrep_id = $salesrepId";

        if ($stmt = mysqli_prepare($this->connection, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);

        while ($row = mysqli_fetch_array($result)) {
            $email = $row['email'];
            array_push($emails, $email);
        }
        return $emails;
    }

    public function exportContacts($csv) {
        
    }

    public function importContacts($csv) {

    }
}