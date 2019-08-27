<?php
class FeedbackControllerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    function testEmailParticipants()
    {
      $controller = new App\Http\Controllers\Staff_Area\FeedbackController();

      $this->assertNotNull($controller->emailParticipants());
    }
}
