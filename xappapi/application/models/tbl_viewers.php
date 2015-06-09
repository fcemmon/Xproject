<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tbl_viewers extends CI_Model {
	protected $table_name = 'tbl_viewers';
	var $tbl_services = "tbl_services";

	//backend processing
	function bSetLike($user_id,$service_id,$like){
		$this->db->where('user_id', $user_id);
		$this->db->where('service_id', $service_id);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result){
			$id = $result['id'];
			
			$flag = $this->db->update($this->table_name, array("like"=>$like), array('id' => $id));
			if ($flag)	return $id;
			else		return 0;
		}
		else {
			$this->db->insert($this->table_name, array('user_id' => $user_id,'service_id' => $service_id,'like' => $like));
			$id = $this->db->insert_id();
			if ($id)	return $id;
			else		return 0;
		}
	}
	function bSetComment($user_id,$service_id,$comment){
		$this->db->where('user_id', $user_id);
		$this->db->where('service_id', $service_id);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result){
			$id = $result['id'];
			
			$flag = $this->db->update($this->table_name, array("comment"=>$comment), array('id' => $id));
			if ($flag)	return $id;
			else		return 0;
		}
		else {
			$this->db->insert($this->table_name, array('user_id' => $user_id,'service_id' => $service_id,'comment' => $comment));
			$id = $this->db->insert_id();
			if ($id)	return $id;
			else		return 0;
		}
	}
	function bGetFavoriteByUserId($user_id){
		if(!$user_id)  return false;
		
		$sql = "SELECT ts.creater_id AS contact_id,ts.username AS contact_name,phonenumber, email, favorite, 1 as service 
						FROM ($this->table_name as tv)
						JOIN $this->tbl_services as ts ON `tv`.`service_id` = `ts`.`id`
						WHERE `tv`.`user_id` = '".$user_id."'";
		
		$query = $this->db->query($sql);
		
		//print_r($this->db->last_query());
		return $query->result_array();
	}
	function bGetContacts($user_id,$phonenumbers){
		if(!$user_id)  return false;
		$phone_string = implode("','",$phonenumbers);
		
		$sql = "SELECT ts.id AS service_id, ts.creater_id AS contact_id, ts.username AS contact_name,  phonenumber, email, 1 AS service, favorite
				FROM ( SELECT id, creater_id, username, phonenumber,email FROM tbl_services WHERE phonenumber  IN ('".$phone_string."') ) AS ts
				LEFT JOIN ( SELECT service_id, favorite FROM tbl_viewers WHERE user_id = '".$user_id."' ) AS tv ON ts.id = tv.service_id";
		
		$query = $this->db->query($sql);
		
		//print_r($this->db->last_query());
		return $query->result_array();
	}
	function bSetFavorite($user_id,$service_id,$favorite){
		$this->db->where('user_id', $user_id);
		$this->db->where('service_id', $service_id);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result){
			$id = $result['id'];
			
			$flag = $this->db->update($this->table_name, array("favorite"=>$favorite), array('id' => $id));
			if ($flag)	return $id;
			else		return 0;
		}
		else {
			$this->db->insert($this->table_name, array('user_id' => $user_id,'service_id' => $service_id,'favorite' => $favorite));
			$id = $this->db->insert_id();
			if ($id)	return $id;
			else		return 0;
		}
	}
	function bGetViewers($service_id){
		if(!$service_id)  return false;
		
		$this->db->select('tv.user_id AS viewer_id, ts.username AS viewer_name, photo, service_name, latitude, longitude', false);
		$this->db->from($this->table_name.' as tv');
		$this->db->join($this->tbl_services.' as ts', 'ts.creater_id=tv.user_id');
		$this->db->where('tv.service_id', $service_id);
		$this->db->order_by('username asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function registerDevice( $user_id, $dev_id )
	{
		$this->db->where( 'user_id', $user_id );
		$this->db->where( 'dev_id', $dev_id );
		$query = $this->db->get('devices');
		if ( count( $query->result() ) <= 0) {

			$dev_info = array( "platform"=>'ios', "dev_id"=>$dev_id, "user_id"=>$user_id );
			$ret = $this->db->insert( 'devices', $dev_info );
		}
		return $ret;
	}

	function removeDevice( $user_id )
	{
		$this->db->where( 'user_id', $user_id );
		$ret = $this->db->delete( 'devices' );
	}
}
		
?>