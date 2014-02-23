<?php

class Users_model extends CI_Model
{
	function check_login()
	{
		$this->db->where('account',$this->input->post('account'));
		$this->db->where('password',$this->input->post('password'));
		
		$user=$this->db->get('users');
		
		if($user->num_rows() > 0)
		{
			// login successfully
			return $user->row_array();
		}
		
		return NULL;
	}
	
	function check_signup()
	{
		$account_input=$this->input->post('account');
		$account_password=$this->input->post('password');
		
		$this->db->where('account',$account_input);
		$this->db->where('password',$account_password);
		
		$user=$this->db->get('users');
		
		if($user->num_rows() > 0)
		{
			// account has been existed
			return 'account has been existed';
		}
		else if($this->input->post('password')!=$this->input->post('password_check'))
		{
			// password is wrong
			return 'password is not identical';
		}
		
		// sign up successfully
		$user_info['account']=$account_input;
		$user_info['password']=$account_password;
		
		if($this->db->insert('users',$user_info))
		{
			return '';
		}
		
		return 'wrong with database';
	}
}


?>