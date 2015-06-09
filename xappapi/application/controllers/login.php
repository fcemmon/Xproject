<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

		function index()
		{
			$data['title'] = "Login - API";
			$data["base_url"] = $this->config->item("base_url");//config data
			$this->load->view('login/content', $data);           
		}
        
        function register(){
            $posts = $this->input->post();
            if (isset($posts) && !empty($posts)){
                $posts['usergrade'] = 2;
                $this->load->model('tbl_users');
                $inserted_id = $this->tbl_users->register($posts);
            } else {
                $inserted_id = 0;
            }
            if ($inserted_id == 0) echo 0;
            else echo 1;
        }
        
        function loginCheck(){
			header("Access-Control-Allow-Origin: *");
			header('Access-Control-Allow-Headers: Content-Type');
		
            $posts = $this->input->post();
			print_r( $posts['phonenumbers']);
            $this->load->model('tbl_users');
            if($this->tbl_users->loginCheck($posts))
            {
                session_start();
                $_SESSION["username"] = $posts['username'];
                $_SESSION["password"] = $posts['password'];
                echo 1;
            }
            else echo 0;
        }
        function out(){
            session_start();
            session_destroy();
            echo 1;
        }
        
        function changepassword(){
            session_start();
            if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
                echo "0";
            } else{
                $this->load->model('tbl_users');
                if($_SESSION["password"] != $this->input->post("oldpw")){
                	echo 0;
                	return;
                }
                
				echo $this->tbl_users->changePassword(array('username'=>$_SESSION["username"],"password"=>$this->input->post("newpw")));
            }
        }
        function adduser(){
            session_start();
            if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
                echo "0";
            } else{
                $this->load->model('tbl_users');
                $manager = $this->tbl_users->getManager();
                $found = false;
                foreach($manager as $m)
                {
                	if($m["username"]==$_SESSION["username"])
                	{
                		$found = true;
                	} // if the current user is one of managers
                }
                if($found==false) {
                	echo 0;
                	return;
                }
                echo $this->tbl_users->register($this->input->post());
            }
        }
        
        function manageuser(){
            session_start();
            if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
                echo "0";
            } else{
                $this->load->model('tbl_users');
                $manager = $this->tbl_users->getManager();
                $found = false;
                foreach($manager as $m)
                {
                	if($m["username"]==$_SESSION["username"])
                	{
                		$found = true;
                	} // if the current user is one of managers
                }
                if($found==false) {
                	echo "You do not have privilege to view this page.";
                	return;
                }
                
                $data['title'] = "Manage - Users";
                $data['header'] = "users";
                $data['page'] = "manage-users";
                $data["base_url"] = $this->config->item("base_url");//config data
                
                $this->load->model('tbl_users');
                $u = $this->tbl_users->getUsers();
                $data['users'] = $u;
                
                $this->load->view('header',$data);
                $this->load->view('login/user_mng', $data);
                $this->load->view('footer');
                
            }
        }
        function deleteuser(){
             session_start();
            if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
                echo "0";
            } else{
                $this->load->model('tbl_users');
                $manager = $this->tbl_users->getManager();
                $found = false;
                foreach($manager as $m)
                {
                	if($m["username"]==$_SESSION["username"])
                	{
                		$found = true;
                	} // if the current user is one of managers
                }
                if($found==false) {
                	echo 0;
                	return;
                }
               
                $posts = $this->input->post();
	        if (isset($posts) && !empty($posts)){
				$this->load->model('tbl_users');
	        	$result = $this->tbl_users->delete($posts['id']);
	        } else {
	             $result = 0;
        	}
	        if ($result == 0) echo 0;
         	else echo 1;
            }
        }
        function changeuserpassword(){
            session_start();
            if (!isset($_SESSION["password"]) && empty($_SESSION["password"])) {
                echo "0";
            } else{
            	$post = $this->input->post();
				$this->load->model('tbl_users');
                $manager = $this->tbl_users->getManager();
                $found = false;
                foreach($manager as $m)
                {
                	if($m["username"]==$_SESSION["username"])
                	{
                		$found = true;
                	} // if the current user is one of managers
                }
                if($found==false) {
                	echo 0;
                	return;
                }
                
                if(!$this->tbl_users->loginCheck(array("username"=>$post["username"],"password"=>$post["oldpw"])))
                {
                	echo 0;
                	return;
                }
                
                $this->load->model('tbl_users');              
				echo $this->tbl_users->changePassword(array('username'=>$post["username"],"password"=>$post["newpw"]));
            }
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */