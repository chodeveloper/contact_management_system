<?php

require 'contact.php';

class ContactManager extends Contact {

    private $_salesrepId;
    private $_contacts;
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
        $this->_contacts = array();
    }

    public function browseContacts() {
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

            array_push($this->_contacts, $contact);
        }
    }

    public function getContacts() {
        return $this->_contacts;
    }

    public function addContact(Contact $new) {
        //connect to MySQL and select database to use
        require_once 'dbConnect.php';
        $connection = db_connect() or die(mysqli_error($connection));
        $db = mysqli_select_db($connection, $this->db_name) or die(mysql_error());

        $sql = "INSERT INTO $this->table_name (firstname, lastname, phone, email, address_street, address_city, address_provice, address_postalcode 
        birtyday, salesrep_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, $this->_salesrepId)";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssssssss', $new['firstname'], $new['lastname'], $new['phone'], $new['email'],
                                $new['address_street'], $new['address_city'], $new['address_provice'], $new['address_postalcode'],
                                $new['birthday']); 

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
            } 
        } 
        mysqli_stmt_close($stmt);
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