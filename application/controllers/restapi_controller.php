<?php

require APPPATH.'/libraries/REST_Controller.php';

class Restapi_controller extends REST_Controller
{
	function collections_get()
	{
		$response=[];
		$this->load->model('Images_model');
		
		$series=$this->Images_model->get_all_series();
		
		$count=0;
		foreach ($series as $item)
		{
			if($count < $this->get('offset'))
			{
				$count++;
				continue;
			}
			
			if($count >= $this->get('limit'))
			{
				break;
			}
			
			$author=$this->Images_model->get_owner($item["id"]);
			
			$response[$item["id"]]=array(
				"name" => $item["name"],
				"author" => $author["account"],
				"thumbnail" => base_url("images/{$item["represented_image_file_name"]}"),
				"rating" => 0
			);
			
			$count++;
		}
		
		//$encoded = json_encode($response);
		
		$this->response($response, 200);
	}
	
	function collection_get()
	{
		$this->load->model('Images_model');
		
		$series_id = $this->get("id");
		$series = $this->Images_model->get_single_series($series_id);
		$images = $this->Images_model->get_images($series_id);
		$author=$this->Images_model->get_owner($series["id"]);
		
		$stickers = [];
		foreach ($images as $image)
		{
			$stickers[$image["raw_name"]] = base_url("images/{$image["file_name"]}");
		}
		
		$response=array(
				"name" => $series["name"],
				"author" => $author["account"],
				"thumbnail" => base_url("images/{$series["represented_image_file_name"]}"),
				"rating" => 0,
				"stickers" => $stickers
		);
		
		//$encoded = json_encode($response);
		
		$this->response($response, 200);
	}
}


?>