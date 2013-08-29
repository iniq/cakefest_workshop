<?php
App::uses('AppModel', 'Model');
/**
 * Job Model
 *
 * @property Company $Company
 * @property Cv $Cv
 */
class Job extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Cv' => array(
			'className' => 'Cv',
			'joinTable' => 'cvs_jobs',
			'foreignKey' => 'job_id',
			'associationForeignKey' => 'cv_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	public $validate = array(
		// only accept *new* Jobs on weekdays
		'name' => array(	// validating on the name fields just for funsies, because this rule actually doesn't care about any of the fields. Error will show as associated to 'name' field, though
			'todayIsWorkday' => array(
				'rule' => array('todayIsWorkday'),
				'message' => "You can't create new jobs on the weekend",
				'on' => 'create',
				'last' => true,
				)
			)
		);

	public function todayIsWorkday($check) {
		$weekday = date('w', $this->getNow());	// see below for "getNow()?!"
		return ($weekday != 0 && $weekday != 6);
	}

	// created this so that we can easily test/mock different times!
	protected function getNow() {
		return strtotime('now');
	}
}
