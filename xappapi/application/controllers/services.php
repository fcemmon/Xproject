<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//  Created by Boris on 27/05/2015.
//  Copyright (c) 2015 EV.TECH All rights reserved.
class Services extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('tbl_users');
		$this->load->model('tbl_services');
		$this->load->model('tbl_viewers');
    }
	public function stdToArray($obj){
		$reaged = (array)$obj;
		foreach($reaged as $key => &$field){
			if(is_object($field))$field = stdToArray($field);
		}
		return $reaged;
	}
	protected function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}

		if (is_dir($dirPath)) {
			if (self::is_dir_empty($dirPath)) {
				rmdir($dirPath);
			}
		}
	}
	function is_dir_empty($dir) {
	  if (!is_readable($dir)) return NULL; 
	  $handle = opendir($dir);
	  while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != "..") {
		  return FALSE;
		}
	  }
	  return TRUE;
	}
	function _output_json( $data ){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
        echo json_encode( $data );
		exit;
    }
	////////////////////////////////////////////////////
	function getservices(){	
		
		$posts = $this->input->post();
		/*TEST*/
		/* 
		$posts['auth_token'] = 'abcdefg';
		$posts['service_name'] = 'service';
		$posts['latitude'] = 25.56;
		$posts['longitude']= 37.7907;
		*/
		//
		$auth_token = $posts['auth_token'];
		$service_name = $posts['service_name'];
		$orig_lat = $posts['latitude'];
		$orig_lon = $posts['longitude'];
		$dist = 5;
		$LIMIT = 100;
		
		/*END*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$user_id = $this->tbl_users->bGetUserId($auth_token);
		if($user_id) {
			$response['status'] = "success";
			$response['user_id'] =  $user_id;
			$services = array();
			
			$serviceInfos = $this->tbl_services->bGetServices($user_id,$service_name,$orig_lat,$orig_lon,$dist,$LIMIT);
			//print_r($serviceInfos);
			if($serviceInfos)
			{
				$ind = 0;
				foreach ($serviceInfos as $serviceInfo) {
					$services[$ind]['service_id'] = $serviceInfo['service_id'];
					$services[$ind]['latitude'] = $serviceInfo['latitude'];
					$services[$ind]['longitude'] = $serviceInfo['longitude'];
					$services[$ind]['service_name'] = $serviceInfo['service_name'];
					$services[$ind]['service_image'] = !$serviceInfo['service_image']?'':$serviceInfo['service_image'];
					$services[$ind]['creater_id'] = $serviceInfo['creater_id'];
					$services[$ind]['creater_name'] = $serviceInfo['creater_name'];
					$services[$ind]['like'] = !$serviceInfo['like']?'':$serviceInfo['like'];
					$services[$ind]['comment'] = !$serviceInfo['comment']?'':$serviceInfo['comment'];
					$services[$ind]['distance'] = $serviceInfo['distance'];
					$ind++;
				}
			}
			
			$response['services'] =  $services;
		}
		else {
			$response['status'] = "fail";
		}
		
		$this->_output_json( $response );
	}
	function setlike(){	
		
		$posts = $this->input->post();
		/*TEST*/
		/* 
		$posts['user_id'] = 12;
		$posts['service_id'] = 4;
		$posts['like'] = 1;
		 */
		/*END*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$result = $this->tbl_viewers->bSetLike($posts['user_id'],$posts['service_id'],$posts['like']);
		if($result) {
			$response['status'] = "success";
		}
		else {
			$response['status'] = "fail";
		}
		
		$this->_output_json( $response );
	}
	function setcomment(){
		
		$posts = $this->input->post();
		/*TEST*/
		/* 
		$posts['user_id'] = 12;
		$posts['service_id'] = 4;
		$posts['comment'] = '';
		 */
		/*END*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$result = $this->tbl_viewers->bSetComment($posts['user_id'],$posts['service_id'],$posts['comment']);
		if($result) {
			$response['status'] = "success";
		}
		else {
			$response['status'] = "fail";
		}
		
		$this->_output_json( $response );
	}
	function offerservice(){
		
		$posts = $this->input->post();
		/*TEST*/
		/*
		$posts['user_id'] = 12;
		$posts['user_name'] = 'Bars Connors';
		$posts['phonenumber'] = '123';
		$posts['phone_type'] = '1';
		$posts['email'] = 'a@a.com';
		$posts['email_type'] = '1';
		$posts['address'] = '1';
		$posts['address_type'] = '1';
		$posts['service_name'] = '1';
		$posts['latitude'] = '1';
		$posts['longitude'] = '1';
		$_FILES['photo'] = 'bbb.pdf';
		*/
		
		/*END*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$serviceinfo = array();
		
		$photo_url = '';
			if(isset($_FILES['photo']) && ($_FILES['photo'])){
				$upload_dir="uploads/"; 
				$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
				
				$upload_dir.=$posts['user_id']."/";
				$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
				
				$upload_dir.="photo/";
				$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
				
				$file_name = $_FILES['photo']['name'];
				//$ext=pathinfo($file_name, PATHINFO_EXTENSION);
				
				// upload photo
				move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir.$file_name);
				
				/*	regMedias	*/
				$photo_url = $this->get_full_url().'/'.$upload_dir.$file_name;
				//add photo url
				
				$serviceinfo['photo'] = $photo_url;
				
			}
			
		$serviceinfo['creater_id'] = $posts['user_id'];$serviceinfo['username'] = $posts['user_name'];
		$serviceinfo['phonenumber'] = $posts['phonenumber'];$serviceinfo['phone_type'] = $posts['phone_type'];
		$serviceinfo['email'] = $posts['email'];$serviceinfo['email_type'] = $posts['email_type'];
		$serviceinfo['address'] = $posts['address'];$serviceinfo['address_type'] = $posts['address_type'];
		$serviceinfo['service_name'] = $posts['service_name'];
		$serviceinfo['latitude'] = $posts['latitude'];$serviceinfo['longitude'] = $posts['longitude'];
		
		$result = $this->tbl_services->bOfferService($serviceinfo);
		if($result) {
			$response['status'] = "success";
			$response['service_id'] = $result;
			$response['photo'] = $photo_url;
		}
		else {
			$response['status'] = "fail";
		}
		
		$this->_output_json( $response );
	}
	function getcontacts(){
		
		$posts = $this->input->post();
		/*TEST*/
		/* 
		$posts['user_id'] = 12;
		$posts['phonenumbers'] = array(11,123,13,14,19);
		*/
		
		/*END*/
		//print_r($posts);
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		
		$contactinfos = $this->tbl_viewers->bGetContacts($posts['user_id'],$posts['phonenumbers']);
		if(count($contactinfos)>0){
			$response['status'] = "success";			
			$response['count'] = count($contactinfos);			
			
			$contacts = array();
			$ind = 0;
			foreach($contactinfos as $contactinfo){
				$contacts[$ind]['service_id']= $contactinfo['service_id'];
				$contacts[$ind]['contact_id']= $contactinfo['contact_id'];
				$contacts[$ind]['contact_name']= $contactinfo['contact_name'];
				$contacts[$ind]['phonenumber']= $contactinfo['phonenumber'];
				$contacts[$ind]['email']= $contactinfo['email'];
				$contacts[$ind]['service']= $contactinfo['service'];
				$contacts[$ind]['favorite']= !$contactinfo['favorite']?'':$contactinfo['favorite'];
				
				$ind++;
			}
			
			$response['contacts'] =  $contacts;
		}
		else {
			$response['status'] = "success";
			$response['count'] = 0;
		}
		
		$this->_output_json( $response );
	}
	function setfavorite(){
		
		$posts = $this->input->post();
		/*TEST*/
		/*
		$posts['user_id'] = 12;
		$posts['phonenumber'] = '123123';
		$posts['email'] = 'ddd@fff.com';
		$posts['favorite'] = 0;
		*/
		/*END*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$service_id = $this->tbl_services->bGetServiceIdByPhoneAndEmail($posts['phonenumber'], $posts['email']);
		if($service_id >0 ) {//there is service that has such a phonenumber or an email?
			$viewer_id = $this->tbl_viewers->bSetFavorite($posts['user_id'],$service_id,$posts['favorite']);
			
			if($viewer_id){
				$response['status'] = "success";
				$response['viewer_id'] = $viewer_id;
			}
			else $response['status'] = "fail";
		}else {
			$response['status'] = "fail";
		}
		
		$this->_output_json( $response );
	}
	function getviewers(){
		
		$posts = $this->input->post();
		/*TEST*/
		/*
		$posts['user_id'] = 12;
		*/
		/*END*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$service_id = $this->tbl_services->bCheckService($posts['user_id']);
		if($service_id >0 ) {//there is service that offered by user?
			$viewerinfos = $this->tbl_viewers->bGetViewers($service_id);
			
			if(count($viewerinfos)>0){
				$response['status'] = "success";			
				
				$viewers = array();
				$ind = 0;
				foreach($viewerinfos as $viewerinfo){
					$viewers[$ind]['viewer_id']= $viewerinfo['viewer_id'];
					$viewers[$ind]['viewer_name']= $viewerinfo['viewer_name'];
					$viewers[$ind]['photo']= !$viewerinfo['photo']?'':$viewerinfo['photo'];
					$viewers[$ind]['service_name']= !$viewerinfo['service_name']?'':$viewerinfo['service_name'];
					$viewers[$ind]['latitude']= $viewerinfo['latitude'];
					$viewers[$ind]['longitude']= $viewerinfo['longitude'];

					$ind++;
				}
				
				$response['viewers'] =  $viewers;
			}
			else {
				$response['status'] = "fail";
			}
		}else {
			$response['status'] = "fail";
		}
		
		$this->_output_json( $response );
	}
	
	
}