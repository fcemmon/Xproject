<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//edit boris	user.rb
class Tbl_users extends CI_Model {
	protected $table_name = 'tbl_users';
	
	public function __construct(){
		date_default_timezone_set( 'Europe/London' );		
	}
	
	//backend processing
	function bGetUserId($auth_token){
		$this->db->where('auth_token', $auth_token);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else {
			$this->db->insert($this->table_name, array('auth_token' => $auth_token));
			$id = $this->db->insert_id();
			if ($id)	return $id;
			else		return 0;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function bLoginCheck($username, $password){
		
		$this->db->where('(username="'.$username.'" or email="'.$username.'") and password= "'.$password.'"');	
		
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query();
		$result = $query->row_array();
		
		//user exist
		if ($result) {
			return $result;
		}
		else {
			return 0;
		}		
	}
	function bRegister($userdata){
		//username exist
		$this->db->where('username', $userdata['username']);
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query();
		//var_dump(count($query->result()));exit;
		if (count($query->result()) > 0) {
			return -1;
		}
		//email exist
		$this->db->where('email', $userdata['email']);
		$query = $this->db->get($this->table_name);
		if (count($query->result()) > 0) {
			return -2;
		}
		
		$this->db->insert($this->table_name, $userdata);
		$id = $this->db->insert_id();
		if ($id)	return $id;
		else		return 0;
	}
	function bGetDataById($nId){
		$this->db->where('id',$nId);
		$query = $this->db->get($this->table_name);
		return $query->row_array();
	}
	function bUpdateDataById($data,$nId){
		$result = $this->db->update($this->table_name, $data, array('id' => $nId));
		//echo $this->db->last_query();
		return $result;
	}
	
	
	
	function loginCheck($userdata){
		//$userdata['password'] = md5($userdata['password']);
		$this->db->where($userdata);
		
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query();
		if (count($query->result()) > 0) {
			return 1;
		}
		else return 0;
	}
	
	function register($userdata){
		//user_id exist
		$this->db->where('username', $userdata['username']);
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query();
		//var_dump(count($query->result()));exit;
		if (count($query->result()) > 0) {
			return -1;
		}
		
		$userdata['password'] = ($userdata['password']);
		$this->db->insert($this->table_name, $userdata);
		$id = $this->db->insert_id();
		if ( $id > 0 ){
			$this->bGetToken( $id );
			return $id;
		}
		else
			return 0;
	}

	// user filter by search items 
	function getUserFilter($username='', $name='', $email='', $age_down='', $age_up='', $push_enable=''){
		$this->db->select('*');

		if($username)	$this->db->where('username like "%'.$username.'%"');
		///if($username)	$this->db->where(' INSTR(username,"'.$username.'") > 0 ');
		if($name)	$this->db->where('concat(firstname, lastname) like "%'.$name.'%"');		
		//if($name)	$this->db->where(' INSTR(concat(firstname, lastname) ,"'.$name.'") > 0 ');		
		if($email)	$this->db->where('email', $email);
		if($age_down)	$this->db->where('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >=',$age_down);
		if($age_up)		$this->db->where('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) <=',$age_up);			
		
		if($push_enable)	$this->db->where('push_enable', $push_enable);
		
		$this->db->order_by('id', 'asc');//username
		
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	// Site Adminarea use function
	function getData(){
		//$this->db->where('usergrade',0);
		$this->db->order_by('id','asc');
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}

	function getDataById($nId){
		$this->db->where('id',$nId);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	function getUsers(){
		$this->db->select('id, username, usergrade');
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	function getManager(){
		$this->db->where('usergrade', 1);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	function changePassword($userdata){
		$this->db->where('username',$userdata["username"]);
		$result = $this->db->update($this->table_name,array("password"=>$userdata["password"]));
		return $result;
	}
	
	function save($data){
		$result = $this->db->update($this->table_name, $data, array('id' => $data['id']));
		return $result;
	}
	function add($data){
		$result = $this->db->insert($this->table_name,$data);
		return $result;
	}
	function delete($id){
		$this->db->where('id', $id);
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	
	function bGetId($userdata){            
		$this->db->where($userdata);
		$query = $this->db->get($this->table_name);				
		$row = $query->result_array();
		return $row[0]['id'];
	}
	
	function getDataByToken($token){
		$this->db->where('authentication_token',$token);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	function bExistByToken($token){
		$this->db->where('authentication_token',$token);
		$query = $this->db->get($this->table_name);				
		if (count($query->result()) > 0) {
			return 1;
		}
		else {
			return 0;
		}
	}
	
	function bGetToken($nId){
		$this->db->where('id',$nId);
		$query = $this->db->get($this->table_name);
		$row = $query->result_array();
		$random = chr(mt_rand(0, 1000));
		$new_token = hash('md4', $row[0]['email'].$random);
		$data['authentication_token'] = $new_token;
		$result = $this->db->update($this->table_name, $data, array('id' => $nId));
		return $new_token;
	}
	function setResetPasswordToken( $user ){
		$token = $this->bGetToken( $user['id'] );
		$user['reset_password_token']		=	$token;
		$user['reset_password_sent_at']		=	date( 'Y-m-d H:i:s' );
		$this->db->where( 'id', $user['id'] );
		$this->db->update( $this->table_name, $user );

		return $user;
	}
	
	
	
	
	
	
	
}