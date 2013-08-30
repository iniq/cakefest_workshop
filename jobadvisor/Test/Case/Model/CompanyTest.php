<?php
App::uses('Company', 'Model');

/**
 * Company Test Case
 *
 */
class CompanyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.company',
		'app.job',
		'app.cv',
		'app.education',
		'app.experiences',
		'app.cvs_jobs',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Company = ClassRegistry::init('Company');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Company);

		parent::tearDown();
	}

	public function testGetRelatedJobs() {
		$companyId = 1;

		// are there 2 jobs?
		$jobs = $this->Company->getRelatedJobs($companyId);
		$this->assertEquals(2, count($jobs));

		// do the jobs belong to company ID = $companyId?
		$companyIdExtracted = Hash::extract($jobs, '{n}.Job.company_id');	// wtf is Hash::extract?
		$this->assertEquals(1, count(array_unique($companyIdExtracted)));

		// are they in the right order?
		$jobIdExtracted = Hash::extract($jobs, '{n}.Job.id');
		$expectedIdOrder = array(1, 2);
		$this->assertEquals($expectedIdOrder, $jobIdExtracted, 'Jobs are not ordered by date');
	}
}
