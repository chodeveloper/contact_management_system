<?php

require 'contactManager.php';

class FileManager {

    // class property -- only to create csv file to export
    private $_contacts;

    public function __construct() {

        $manager = new ContactManager();
        // admins want ALL contact data
        $this->_contacts = $manager->browseAllContacts();
    }

    public function createCSV() {
        // overwrite the file if exists
        if ($csv = fopen("./csv/clientInfo.csv", "w")) {
           // write a file
            foreach ($this->_contacts as $contact) {
                $vars = $contact->getVars();
                $data = [$vars['id'], $vars['firstname'], $vars['lastname'], $vars['phone'], $vars['email'], 
                        $vars['ad_street'], $vars['ad_city'], $vars['ad_province'], $vars['ad_postalcode'],
                        $vars['birthday'], $vars['salesrep_id']];
                fputcsv($csv, $data);
            }
            fclose($csv);
        }         
    }

}


