<?php

class Users_controller extends CI_Controller
{
	function index()
	{
	}
	
	function Users_controller()
	{
		parent::__construct();
		$this->load->model("Users_model");
	}
	
	function show_login_page()
	{
		$data['title']='Login Page';
		
		if($this->session->userdata('logged_in'))
		{
			// has been logged in
			//redirect('console_controller/show_console_page', 'refresh');
		}
		else
		{
			//$this->load->view('login_page',$data);
		}
		
		$this->load->view('login_page',$data);
	}
	
	function show_signup_page($msg='')
	{
		$data['title']='Signup Page';
		$data['msg']=$msg;
		$this->load->view('signup_page',$data);
	}
	
	function send_login()
	{
		$user=$this->Users_model->check_login();
		
		if($user==null)
		{
			redirect("users_controller/show_login_page", "refresh");
		}
		else 
		{
			// login successfully
			$newdata = array(
				'id' => $user['id'],
				'account'  => $user['account'],
				'logged_in' => true
			);
			
			$this->session->set_userdata($newdata);
			
			redirect('console_controller/show_console_page', 'refresh');
		}
	}
	
	function send_signup()
	{
		$this->Users_model->check_signup();
		
		redirect("users_controller/show_login_page", "refresh");
	}
	
	function send_logout()
	{
		$this->session->sess_destroy();
		redirect("users_controller/show_login_page");
	}
}

?>