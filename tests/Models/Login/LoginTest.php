<?php

declare(strict_types=1);

use App\Model\Login;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testEmail()
    {
        $login = new Login("test1@gmail.com", "#4wweer");
        $this->assertEquals("test1@gmail.com", $login->getEmail());
    }
    public function testPassword()
    {
        $login = new Login("test1@gmail.com", "#4wweer");
        $this->assertEquals("#4wweer", $login->getPassword());
    }
}
