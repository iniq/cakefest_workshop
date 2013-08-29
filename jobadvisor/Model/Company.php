<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * Company Model
 *
 * @property Job $Job
 */
class Company extends AppModel {

	public $displayField = 'display_name';
	public $virtualFields = array(
		'display_name' => "CONCAT(Company.name, '-', Company.id)"
		);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'company_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	public function afterSave(boolean $created) {
		if ($created) {
			// Move me into a queue!
			CakeEmail::deliver(
				'derek+cakefest@tribehr.com',
				__('New company created id: %s', $this->data['Company']['id']),
				__('New company was created'),
				'default'
				);
		}
	}
}
