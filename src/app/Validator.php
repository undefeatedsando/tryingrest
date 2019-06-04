<?php

namespace App;

class Validator{

	public $fieldRegex = array(
		'id' => '/\d/',
		'name' => '/\w/',
		'email' => '/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i',
		'phone' => '/8\d{10}/',
	);

	public function validate($field, $value){
		if (!isset($this->fieldRegex[$field])) {
			return false;
		}
		if (preg_match($this->fieldRegex[$field], $value)) {
			return true;
		}
		return false;
	}

}

?>