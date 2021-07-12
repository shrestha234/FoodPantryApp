<?php

class User
{
    private $firstName;
    private $lastName;
    private $email;
    private $username;
    private $campus;

    public function __construct($properties)
    {
        $this->firstName = $properties["FirstName"];
        $this->lastName = $properties["LastName"];
        $this->email = $properties["Email"];
        $this->username = $properties["Username"];
        $this->campus = $properties["Campus"];
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getCampus(){
        return $this->campus;
    }
}