<?php
App::uses('Job', 'Model');

/**
 * Job Test Case
 *
 */
class JobTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.job',
		'app.company',
		'app.cv',
		'app.education',
		'app.experience',
		'app.cvs_job'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Job = ClassRegistry::init('Job');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Job);

		parent::tearDown();
	}

	// #fuckyeah mocks!
	public function testTodayIsWorkdaySuccessAndFail() {
		$jobMock = $this->getMockForModel('Job', array('getNow'));
		// $this->at(0) sets up the mock only for the first call
		$jobMock->expects($this->at(0))
			->method('getNow')
			->will($this->returnValue(strtotime('next sunday')));

		// $this->at(1) sets up the mock only for the second call
		$jobMock->expects($this->at(1))
			->method('getNow')
			->will($this->returnValue(strtotime('next thursday')));

		$result = $jobMock->todayIsWorkday(array());
		$this->assertFalse($result, 'next sunday should NOT be a workday');
		$result = $jobMock->todayIsWorkday(array());
		$this->assertTrue($result, 'next thursday should NOT be a workday');
	}
}
