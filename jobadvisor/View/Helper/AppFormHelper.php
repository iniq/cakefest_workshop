<?php

App::uses('FormHelper');

class AppFormHelper extends FormHelper {
	public function select($fieldName, $options = array(), $attributes = array()) {
		if (!empty($attributes['multiple'])) {
			$attributes['multiple'] = 'checkbox';
		}
		return parent::select($fieldName, $options, $attributes);
	}
}