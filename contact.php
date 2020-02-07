<?php

class Contact {
    
    private $id;
    private $firstname;
    private $lastname;
    private $phone;
    private $email;
    private $ad_street;
    private $ad_city;
    private $ad_province;
    private $ad_postalcode;
    private $birthday;
    private $salesrep_id;

    public function __construct($id, $firstname, $lastname, $phone, $email, $street, $city, $prov, $code, $birthday, $rep) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->email = $email;
        $this->ad_street = $street;
        $this->ad_city = $city;
        $this->ad_province = $prov;
        $this->ad_postalcode = $code;
        $this->birthday = $birthday;
        $this->salesrep_id = $rep;
    }

    public function getVars() {
        return get_object_vars($this);
    }

    public function setName($fn, $ln) {
        $this->firstname = $fn;
        $this->lastname = $ln;
    }

    public function setPhone($newPhone) {
        $this->phone = $newPhone;
    }

    public function setEmail($newEmail) {
        $this->email = $newEmail;
    }

    public function setAddress($newSt, $newCity, $newProv, $newCode) {
        $this->address_street = $newSt;
        $this->address_city = $newCity;
        $this->address_province = $newProv;
        $this->address_postalcode = $newCode;
    }

    public function setBirthday($newBday) {
        $this->birthday = $newBday;
    }
}