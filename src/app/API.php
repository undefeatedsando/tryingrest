<?php

namespace App;

use \App\Validator;
use \App\User;

class API {

    private $user, $request, $validator;

    public function ask($request){
    	//initialize objects
    	$this->request = $request;
		$this->validator = new Validator();
		$this->user = new User();
		//check if request is allowed
		//check type of request
		$method = $request->getMethod();
		switch ($method) { 
			case 'GET':
				//gets id through GET, returns json with data
				return $this->getUser();
				break;
			case 'POST':
				$result = $this->createUser();
				$code = 200;
				return array(
						'result' => json_encode($result),
						'code' => $code
					);
				break;

			case 'PUT':
				$result = $this->updateUser();
				$code = 200;
				return array(
						'result' => json_encode($result),
						'code' => $code
					);
				break;

			case 'DELETE':
				//gets id through DELETE
				$id = $request->getParam('id');
				if ($validator->validate('id', $id)) {
					$result = $this->deleteUser($id);
				}
				$result = 'DELETED';
				$code = 200;
				return array(
						'result' => json_encode($result),
						'code' => $code
					);
				break;


			
			default:
				# code...
				break;
				return 0;
		}
	}

	private function getUser(){

		$id = $this->request->getParam('id');

		if (!$id){
			$result = $this->user->getAllUsers();
			$code = $result ? 200 : 404;
			return array(
				'result' => json_encode($result),
				'code' => $code
			);
		}

		if ($this->validator->validate('id', $id)) {
			$result = $this->user->getUserByID($id);
			$code = $result ? 200 : 404;
			return array(
				'result' => json_encode($result),
				'code' => $code
			);
		}
	}
	private function createUser(){
		
		$mustHave = array('name', 'email', 'phone');
		
		$validData = $this->validateData($mustHave);
		if (!$validData) {
			return $this->badRequest();
		}

		$result = $this->user->createUser($validData['name'], $validData['email'], $validData['phone']);
		return $result;
	}
	private function updateUser(){
		
		$mustHave = array('id');
		
		$validData = $this->validateData($mustHave); //necessary data
		if (!$validData) {
			return $this->badRequest();
		}

		$canHave = array('name', 'email', 'phone');

		$validOptionalData = $this->validateData($canHave, true); //optional data
		if (!$validOptionalData) {
			return $this->badRequest();
		}

		$result = $this->user->updateUserByID($validData['id'], $validOptionalData['name'], $validOptionalData['email'], $validOptionalData['phone']);
		return $result;
	}
	private function deleteUser(){
		
	}

	private function validateData($mustHave, $optional = false){
		$fields = array();
		foreach ($mustHave as $field) {
			if ($optional && !($this->request->getParam($field))) {
				continue;
			}
			$fields[$field] = $this->request->getParam($field);
			$valid = $this->validator->validate($field, $fields[$field]);
			if (!$valid) {
				return false;
			}
		}
		return $fields;
	}

	private function badRequest(){
		return array(
		'result' => json_encode('Bad request'),
		'code' => 400
		);
	}
}

?>