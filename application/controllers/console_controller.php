<?php

class Console_controller extends CI_Controller
{
	function index()
	{
		$this->load->helper('file');
	}
	
	function Consoles_controller()
	{
		parent::__construct();
	}
	
	function send_logout()
	{
		$this->session->sess_destroy();
		redirect("users_controller/show_login_page");
	}
	
	function show_console_page()
	{
		$this->load->model('Images_model');
		
		$data["series"]=$this->Images_model->get_series();
		$data["title"]="Console Page";
		$this->load->view('console_page',$data);
	}
	
	function show_series_page($series_id)
	{
		$this->load->model('Images_model');
		
		$data["title"]="Series Page";
		$data["images"]=$this->Images_model->get_images($series_id);
		$data["series"]=$this->Images_model->get_single_series($series_id);
		$this->load->view("series_page",$data);
	}
	
	function new_series()
	{
		$this->load->model('Images_model');
		
		$this->Images_model->new_series();
		redirect("console_controller/show_console_page", "refresh");
	}
	
	function edit_series()
	{
	}
	
	function delete_series($series_id)
	{
		$this->load->model('Images_model');
		$this->Images_model->delete_series($series_id);
		
		redirect("console_controller/show_console_page", "refresh");
	}
	
	function add_images($series_id)
	{
		$config['upload_path'] = './images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$this->load->library('upload',$config);
		
		$this->load->model('Images_model');
		
		if ( ! $this->upload->do_upload())
		{
			//$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_page',$error);
			echo $this->upload->display_errors();
		}
		else
		{
			//$data = array('upload_data' => $this->upload->data());
			
			if($this->Images_model->add_image_info($series_id, $this->upload->data())!="")
			{
			}
			else 
			{
				redirect("console_controller/show_series_page/{$series_id}", "refresh");				
			}
			
		}
	}
	
	function save_comments($series_id)
	{
		$this->load->model('Images_model');
		$this->Images_model->save_comments($series_id);
		
		redirect("console_controller/show_series_page/{$series_id}", "refresh");
	}
	
	function delete_image($series_id, $image_id)
	{	
		$this->load->model('Images_model');
		$this->Images_model->delete_image($series_id, $image_id);
		
		redirect("console_controller/show_series_page/{$series_id}", "refresh");
	}
	
	function change_series_name($series_id, $name)
	{
		$this->load->model('Images_model');
		$this->Images_model->change_series_name($series_id, $name);
		
		redirect("console_controller/show_series_page/{$series_id}", "refresh");
	}
	
	function change_series_representation($series_id, $image_id)
	{
		$this->load->model('Images_model');
		$this->Images_model->change_series_representation($series_id, $image_id);
	
		redirect("console_controller/show_series_page/{$series_id}", "refresh");
	}
}

?>