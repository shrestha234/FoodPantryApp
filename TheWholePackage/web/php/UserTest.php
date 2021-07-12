<?php
require_once "User.php";
require_once "Classes/Database.php";

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test__construct()
    {
        $user = new User([
            "FirstName" => "Abdullah",
            "LastName" => "Luay",
            "Email" => "abdullah.luay@pcc.edu",
            "Username" => "abdullah.luay",
            "Campus" => "Sylvania"
        ]);
        $this->assertEquals("Abdullah", $user->getFirstName());
        $this->assertEquals("Luay", $user->getLastName());
        $this->assertEquals("abdullah.luay@pcc.edu", $user->getEmail());
        $this->assertEquals("abdullah.luay", $user->getUsername());
        $this->assertEquals("Sylvania", $user->getCampus());
    }

    public function testGetFirstName(){
        $user = new User(["FirstName" => "Abdullah",
            "LastName" => "",
            "Email" => "",
            "Username" => "",
            "Campus" => ""]);
        $this->assertEquals("Abdullah", $user->getFirstName());
    }
    public function testGetLastName(){
        $user = new User(["FirstName" => "",
            "LastName" => "Luay",
            "Email" => "",
            "Username" => "",
            "Campus" => ""]);
        $this->assertEquals("Luay", $user->getLastName());
    }

    public function testGetEmail(){
        $user = new User(["FirstName" => "",
            "LastName" => "",
            "Email" => "abdullah.luay@pcc.edu",
            "Username" => "",
            "Campus" => ""]);
        $this->assertEquals("abdullah.luay@pcc.edu", $user->getEmail());
    }

    public function testGetUsername(){
        $user = new User(["FirstName" => "",
            "LastName" => "",
            "Email" => "",
            "Username" => "abdullah.luay",
            "Campus" => ""]);

        $this->assertEquals("abdullah.luay", $user->getUsername());
    }

    public function testGetCampus(){
        $user = new User(["FirstName" => "",
            "LastName" => "",
            "Email" => "",
            "Username" => "",
            "Campus" => "Sylvania"]);

        $this->assertEquals("Sylvania", $user->getCampus());
    }
}
