<?php
App::uses('ModelBehavior', 'Model');
App::uses('CakeEmail', 'Network/Email');

class CreationReportBehavior extends ModelBehavior {
	public function afterSave(Model $Model, $created) {

		if ($created) {
			// Move me into a queue!
			$mail = CakeEmail::deliver(
				'derek+cakefest@tribehr.com',
				__('New %s created id: %s', $Model->alias, $Model->data[$Model->alias]['id']),
				__('New %s was created', $Model->alias),
				'default'
				);
		}

	}
}