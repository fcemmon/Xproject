<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//  Created by Boris on 02/03/2015.
//  Copyright (c) 2014 EV. All rights reserved.
class Users extends CI_Controller {

	function index()
	{
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "This page is available.";
		} else{
			$data['title'] = "Users";
			$data['header'] = "users";
			$data['page'] = "users";
			$data["base_url"] = $this->config->item("base_url");//config data

			$this->load->model('tbl_users');
			$users = $this->tbl_users->getData();     
			$data['users'] = $users;

			$this->load->view('header',$data);
			$this->load->view('users/content', $data);
			$this->load->view('footer');
		}
	}
	function details()
	{
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "This page is available.";
		} else{
			$id = $_GET['id'];
			$data['title'] = "Details - Users";
			$data['header'] = "users";
			$data['page'] = "users_details";
			$data["base_url"] = $this->config->item("base_url");//config data
			
			$this->load->model('tbl_users');
			$users = $this->tbl_users->getDataById($id);                                

			$data['users'] = $users[0];

			$this->load->view('header',$data);
			$this->load->view('users/content', $data);
			$this->load->view('footer');
		}
	}
	function edit()
	{
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "This page is available.";
		} else{
			$id = $_GET['id'];
			$data['title'] = "Edit - Users";
			$data['header'] = "users";
			$data['page'] = "users_edit";
			$data["base_url"] = $this->config->item("base_url");//config data
			
			$this->load->model('tbl_users');
			$users = $this->tbl_users->getDataById($id);
			$data['users'] = $users[0];

			$this->load->view('header',$data);
			$this->load->view('users/content', $data);
			$this->load->view('footer');
		}
	}
	function add_diag(){
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "This page is available.";
		} else{
			$data['title'] = "Add - Users";
			$data['header'] = "users";
			$data['page'] = "users_add";
			$data["base_url"] = $this->config->item("base_url");//config data                
			
			$this->load->view('header',$data);
			$this->load->view('users/content', $data);
			$this->load->view('footer');
		}
	}
	function sendEmail($data)
	{
		$to = $data['email'];

		$subject = 'Hi, '.$data['username'];

		$headers = "Header\r\n";			
		
		$message = 'test';			
		
		mail($to, $subject, $message, $headers);
		return;
	}
	function add(){
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "0";
		} else{
			$posts = $this->input->post();
			if (isset($posts) && !empty($posts)){
				$this->load->model('tbl_users');
				$result = $this->tbl_users->add($posts);
			} else {
				$result = 0;
			}
			if ($result == 0) echo 0;
			else {
				//$this->sendEmail($posts);
				echo 1;
			}
		}
	}
	function save(){
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "0";
		} else{
			$posts = $this->input->post();
			if (isset($posts) && !empty($posts)){
				$this->load->model('tbl_users');
				$result = $this->tbl_users->save($posts);
			} else {
				$result = 0;
			}
			if ($result == 0) echo 0;
			else echo 1;
		}
	}
	function deleteCheck(){
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
				echo "0";
		} else{
			$posts = $this->input->post();
			if (isset($posts) && !empty($posts)){
					$this->load->model('tbl_orders');
					$orders = $this->tbl_orders->getDataByUser_id($posts['id']);
					if (count($orders) > 0) echo 0;
					else echo 1;
			} else {
					echo 0;
			}
		}
	}
	function delete(){
		session_start();
		if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
			echo "0";
		} else{
			$posts = $this->input->post();
			if (isset($posts) && !empty($posts)){
				$this->load->model('tbl_users');
				$result = $this->tbl_users->delete($posts['id']);
				
				$this->load->model('tbl_devices');
				$result = $this->tbl_devices->removeDevice($posts['id']);
				
				$this->load->model('tbl_notifications');
				$result = $this->tbl_notifications->deleteNotificationByUser($posts['id']);
				
			} else {
				$result = 0;
			}
			if ($result == 0) echo 0;
			else echo 1;
		}
	}
}
