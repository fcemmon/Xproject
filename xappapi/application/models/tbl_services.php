<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tbl_services extends CI_Model {
	protected $table_name = 'tbl_services';
	var $tbl_viewers = "tbl_viewers";
		
	function bCheckService($creater_id){
		$this->db->where('creater_id',$creater_id);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else return 0;
	}
	//////////////////////////////////////////////
	function bGetServices($user_id,$service_name='',$orig_lat='',$orig_lon='',$dist='100000',$limit='500'){
		if($orig_lat=='' || $orig_lon=='')  return false;
		if($service_name!='')  $dist=100000;
		
		$sql = "SELECT `ts`.`id` AS service_id, `latitude`, `longitude`, `service_name`, `creater_id`,
					   `ts`.`username` AS creater_name, `ts`.`photo` AS service_image, `tv`.`like`, `tv`.`comment`,
								(3959 * 2 * ASIN(SQRT( POWER((SIN(($orig_lat - ABS(ts.latitude)) * PI()/180 / 2)), 2)
													  + COS($orig_lat * PI()/180 ) * COS(ABS(ts.latitude) * PI()/180) * POWER((SIN(($orig_lon - ts.longitude) * PI()/180 / 2)), 2) )))
								  AS distance 
						FROM ($this->table_name as ts)
						LEFT JOIN (SELECT * FROM $this->tbl_viewers WHERE user_id = $user_id) as tv ON `tv`.`service_id` = `ts`.`id`
						WHERE `ts`.`service_name` like '%".$service_name."%'
						HAVING `distance` <= $dist
						ORDER BY `distance` asc, `service_name` asc
						LIMIT $limit";
		
		$query = $this->db->query($sql);
		
		//print_r($this->db->last_query());
		return $query->result_array();
	}
	function bOfferService($data){
		$service_id = $this->bCheckService($data['creater_id']);
		if($service_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $service_id));
			return $service_id;
		}else{
			$this->db->insert($this->table_name, $data);
			$id = $this->db->insert_id();
			if ($id)	return $id;
			else		return 0;			
		}
	}
	function bGetServiceIdByPhoneAndEmail($phonenumber='', $email=''){
		if($phonenumber){
			$this->db->where('phonenumber',$phonenumber);
			$this->db->select('id');
			$result = $this->db->get($this->table_name)->row_array();
			
			if ($result) return $result['id'];
		}
		if($email){
			$this->db->where('email',$email);
			$this->db->select('id');
			$result = $this->db->get($this->table_name)->row_array();
			
			if ($result) return $result['id'];
		}
		return 0;
	}
	
	
	
	
	
	
	
	
	
	function bCheckAssignFile($user_id,$book_name,$chapter_name,$filename){
		$userdata['user_id'] = $user_id;
		$userdata['book_name'] = $book_name;
		$userdata['chapter_name'] = $chapter_name;
		$userdata['filename'] = $filename;
		
		$this->db->where($userdata);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else return 0;
	}
	function bBookDesc($book_name){
		$this->db->select('book_desc');
		$this->db->where("book_name='".$book_name."' and book_desc IS NOT NULL", NULL, FALSE);

		$result = $this->db->get($this->table_name)->row_array();
		//print_r($this->db->last_query());
		if ($result) return $result['book_desc'];
		else return '';
	}
	function bChapterDesc($book_name,$chapter_name){
		$this->db->select('chapter_desc');
		$this->db->where("book_name='".$book_name."' and chapter_name='".$chapter_name."' and chapter_desc IS NOT NULL", NULL, FALSE);

		$result = $this->db->get($this->table_name)->row_array();
		//print_r($this->db->last_query());
		if ($result) return $result['chapter_desc'];
		else return '';
	}
	
	
	
	
	//////////////////////////////////////////////
	function bCreateBook($data){
		$this->db->insert($this->table_name, $data);
		$id = $this->db->insert_id();
		if ($id)	return $id;
		else		return 0;
	}
	function bCreateChapter($data){
		//if exist empty chapter name
		$book_id = $this->bCheckEmptyChapter($data['user_id'], $data['book_name']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
		}else{
			$this->db->insert($this->table_name, $data);
			$book_id = $this->db->insert_id();
		}
		
		if ($book_id)	return $book_id;
		else		return 0;
	}
	function bCreateSubChapter($data){
		//if exist empty chapter name
		$book_id = $this->bCheckEmptySubChapter($data['user_id'], $data['book_name'], $data['chapter_name']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
		}else{
			$this->db->insert($this->table_name, $data);
			$book_id = $this->db->insert_id();
		}
		
		if ($book_id)	return $book_id;
		else		return 0;
	}
	function bUploadFile($data){
		//if exist empty File name
		$book_id = $this->bCheckEmptyFile($data['user_id'], $data['book_name'], $data['chapter_name']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
		}else{
			$this->db->insert($this->table_name, $data);
			$book_id = $this->db->insert_id();
		}
		
		if ($book_id)	return $book_id;
		else		return 0;
	}
	function bGetAppInfoByUserId($user_id){
		$this->db->select('book_name,book_desc,filename', false);
		$this->db->from($this->table_name);
		$this->db->where('user_id', $user_id);
		$this->db->order_by('book_name asc, book_desc desc, filename asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}	
	function bGetBookInfoByUserId($user_id,$book_name){
		$this->db->select('chapter_name,chapter_desc,subchapter_name,filename', false);
		$this->db->from($this->table_name);
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name));
		$this->db->order_by('chapter_name asc, chapter_desc desc, subchapter_name asc, filename asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}
	function bGetChapterInfoByUserId($user_id,$book_name,$chapter_name){
		$this->db->select('subchapter_name,subchapter_desc,filename', false);
		$this->db->from($this->table_name);
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name));
		$this->db->order_by('subchapter_name asc, subchapter_desc desc, filename asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}
	function bAssignFiles($data){
		//if exist empty File name
		$book_id = $this->bCheckAssignFile($data['user_id'], $data['book_name'], $data['chapter_name'], $data['filename']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
			return $book_id;
		}else
			return 0;
	}
	function bDeleteBookByUserId($user_id,$book_name){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	function bDeleteChapterByUserId($user_id,$book_name,$chapter_name){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	function bDeleteSubChapterByUserId($user_id,$book_name,$chapter_name,$subchapter_name){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name, 'subchapter_name'=>$subchapter_name));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	function bDeleteFileByUserId($user_id,$book_name,$chapter_name,$filename){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name, 'filename'=>$filename));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	
	
	
	
	
	
	
}