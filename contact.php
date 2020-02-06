<?php

class Contact {
    
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $phone;
    protected $email;
    protected $address_street;
    protected $address_city;
    protected $address_province;
    protected $address_postalcode;
    protected $birthday;
    protected $salesrep_id;

    public function __construct($id, $firstname, $lastname, $phone, $email, $street, $city, $prov, $code, $birthday, $rep) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->email = $email;
        $this->address_street = $street;
        $this->address_city = $city;
        $this->address_province = $prov;
        $this->address_postalcode = $code;
        $this->birthday = $birthday;
        $this->salesrep_id = $rep;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->firstname." ".$this->lastname;
    }

    public function setName($fn, $ln) {
        $this->firstname = $fn;
        $this->lastname = $ln;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($newPhone) {
        $this->phone = $newPhone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($newEmail) {
        $this->email = $newEmail;
    }

    public function getAddress() {
        return $this->address_street. " " . $this->address_city. ", " . $this->address_province . " " . $this->address_postalcode;
    }

    public function setAddress($newSt, $newCity, $newProv, $newCode) {
        $this->address_street = $newSt;
        $this->address_city = $newCity;
        $this->address_province = $newProv;
        $this->address_postalcode = $newCode;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($newBday) {
        $this->birthday = $newBday;
    }

    public function getSalesRepId() {
        return $this->salesrep_id;
    }
}