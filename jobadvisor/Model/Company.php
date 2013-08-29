<?php
App::uses('AppModel', 'Model');
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

}
