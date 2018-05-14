<?php
require_once("Database.php");
require_once("QueryConsts.php");
	
class User {	
	public $id;
	public $fio;
	public $email;
	
	public $params;

	public function __construct($id, $fio = null, $email = null) {
		$this->id = $id;
		$this->fio = $fio;
		$this->email = $email;
	}
	
	public function addUser($conn, $params) {	
		$result = $conn->query(QueryConsts::ADD_USER_QUERY, $params);
		return $result;
	}
	
	public function addClientId($conn, $id) {	
		$result = $conn->query(QueryConsts::ADD_CLIENT_ID_QUERY, array($id));
		return $result;
	}
	
	public function editUser($conn, $params) {	
		$result = $conn->query(QueryConsts::UPDATE_USER_QUERY, $params);
		return $result;
	}
	
	public function uploadUserImage($conn, $params) {	
		$result = $conn->query(QueryConsts::UPDATE_USER_IMAGE_QUERY, $params);
		return $result;
	}
	
	public function deleteUser($conn) {
		$result = $conn->query(QueryConsts::DELETE_USER_BY_USER_ID_QUERY, array($this->id));
		return $result;
	}
	
	public function getUserByEmail($conn) {
		$result = $conn->selectRow(QueryConsts::GET_USER_BY_EMAIL_QUERY, array($this->email));
		$this->params = $result;
		return $this;
	}

	public function checkUserWithGivenEmailNotExist($conn) {
		$result = $conn->getAmountOfRows(QueryConsts::GET_USER_BY_EMAIL_QUERY, array($this->email));
		return $result == 0;
	}
	
    public function getUserId() {
		return $this->params['user_id'];
	}
    
	public function getUserName() {
		return $this->params['name'];
	}
    
    public function getUserSurname() {
		return $this->params['surname'];
	}
    
    public function getUserLastname() {
		return $this->params['lastname'];
	}
    
    public function getUserRegistrationDate() {
		return $this->params['registration_date'];
	}
    
    public function getUserEmail() {
		return $this->params['email'];
	}
	
	public function getUserImage() {
		return $this->params['image'];
	}
	
	public function getUserRole() {
		return $this->params['is_admin'];
	}
	
	public function getUserPassword() {
		return $this->params['password'];
	}
	
	public function getUserRoleName() {
		if ($this->getUserRole() == 1)
			return "Администратор";
		else return "Обычный пользователь";		
	}
}
?>