<?php 

namespace App;

class User extends Model{

	public function test(){

		$stmt = $this->pdo->query('SELECT name FROM users');
		while ($row = $stmt->fetch())
		{
		    echo $row['name'] . "\n";
		}

	}

	public function getAllUsers(){
		$sql = $this->pdo->prepare('SELECT * FROM users');
		$sql->execute();
		while($row = $sql->fetch(\PDO::FETCH_ASSOC)){
			$result[] = $row;
		}
		return $result;
	}

	public function getUserByID($id){
		$sql = $this->pdo->prepare('SELECT * FROM users WHERE id=?');
		$sql->execute(array($id));
		$result = $sql->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}
	public function createUser($name, $email, $phone){
		$sql = $this->pdo->prepare('INSERT INTO `users`(`name`, `email`, `phone`) VALUES (?,?,?)');
		$sql->execute(array($name, $email, $phone));
		$sql2 = $this->pdo->prepare('SELECT MAX(id) AS last_user FROM users');
		$sql2->execute();
		$result = $sql2->fetch(\PDO::FETCH_ASSOC);
		return $result['last_user'];
	}
	public function updateUserByID($id, $name=false, $email=false, $phone=false){
		//if no params - get  existing ones
		$sql = $this->pdo->prepare('SELECT * FROM users WHERE id=?');
		$sql->execute(array($id));
		$user = $sql->fetch(\PDO::FETCH_ASSOC);
		$name = $name ? $name : $user['name'];
		$email = $email ? $email : $user['email'];
		$phone = $phone ? $phone : $user['phone'];
		//update itself
		$sql = $this->pdo->prepare('UPDATE users SET name=?, email=?, phone=? WHERE id=?');
		return $sql->execute(array($name, $email, $phone, $user['id']));
	}
	public function deleteUserByID($id){
		$sql = $this->pdo->prepare('DELETE FROM `users` WHERE id=?');
		$sql->execute(array($id));
	}
}

?>