<?php

declare(strict_types=1);

use App\Model\Signup;
use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase
{
    public function testEmail()
    {
        $signup = new Signup("test1@gmail.com", "#4wweer", "Adam", "May", "1999-01-01");
        $this->assertEquals("test1@gmail.com", $signup->getEmail());
    }
    public function testPassword()
    {
        $signup = new Signup("test1@gmail.com", "#4wweer", "Adam", "May", "1999-01-01");
        $this->assertEquals("#4wweer", $signup->getPassword());
    }
    public function testName()
    {
        $signup = new Signup("test1@gmail.com", "#4wweer", "Adam", "May", "1999-01-01");
        $this->assertEquals("Adam", $signup->getName());
    }
    public function testSurname()
    {
        $signup = new Signup("test1@gmail.com", "#4wweer", "Adam", "May", "1999-01-01");
        $this->assertEquals("May", $signup->getSurname());
    }
    public function testBirthday()
    {
        $signup = new Signup("test1@gmail.com", "#4wweer", "Adam", "May", "1999-01-01");
        $this->assertEquals("1999-01-01", $signup->getBirthday());
    }
}
