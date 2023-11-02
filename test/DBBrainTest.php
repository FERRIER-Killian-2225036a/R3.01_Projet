<?php


use PHPUnit\Framework\TestCase;

class DBBrainTest extends TestCase
{

    public function testGetConn()
    {

    }

    public function testIsValidEmail()
    {
        $dbBrain = new DBBrain();

        // Test d'un email valide
        $validEmail = 'test@example.com';
        $this->assertTrue($dbBrain->isValidEmail($validEmail));

        // Test d'un email invalide
        $invalidEmail = 'invalid_email';
        $this->assertFalse($dbBrain->isValidEmail($invalidEmail));
    }

    public function test__construct()
    {

    }

    public function testIsPasswordNotSafe()
    {

    }

    public function testIsValidPseudo()
    {

    }

    public function testArgonifiedPassword()
    {

    }
}
