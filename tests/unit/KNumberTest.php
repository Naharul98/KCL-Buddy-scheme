<?php
class KNumberTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    function testKnumberPassesTrueTests()
    {
      $Knum = new App\Rules\KNumber();

      $this->assertTrue($Knum->passes("1","k1234567"));
      $this->assertTrue($Knum->passes("1","k7654321"));
      $this->assertTrue($Knum->passes("1","k0000000"));
      $this->assertTrue($Knum->passes("1","k9999999"));
      $this->assertTrue($Knum->passes("1","k1111111"));
      $this->assertTrue($Knum->passes("1","k1918357"));
    }

    function testKnumberPassesFalseTests()
    {
      $Knum = new App\Rules\KNumber();

      $this->assertFalse($Knum->passes("1","k1"));
      $this->assertFalse($Knum->passes("1","k12"));
      $this->assertFalse($Knum->passes("1","k123"));
      $this->assertFalse($Knum->passes("1","k1234"));
      $this->assertFalse($Knum->passes("1","k12345"));
      $this->assertFalse($Knum->passes("1","k123456"));
      $this->assertFalse($Knum->passes("1","k123456789"));

    }

}
