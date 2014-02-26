<?php

class Images_model extends CI_Model
{
	function get_series()
	{	
		$series=[];
		
		$sids_query = $this->db->query(
			"
			SELECT series_id
			FROM series_mapping 
			WHERE user_id={$this->session->userdata("id")};
			"
		);
		foreach ($sids_query->result_array() as $result)
		{
			$series_query = $this->db->query(
				"
				SELECT *
				FROM series 
				WHERE id={$result["series_id"]};
				"
			);
			
			array_push($series, $series_query->row_array());
		}
		
		return $series;
	}
	
	
	function get_all_series()
	{
		$series_query = $this->db->query(
			"
			SELECT *
			FROM series
			"
		);
		
		$series = $series_query->result_array();
	
		return $series;
	}
	
	function get_owner($series_id)
	{
		$series=[];
		
		$uids_query = $this->db->query(
			"
			SELECT *
			FROM series_mapping 
			WHERE series_id={$series_id};
			"
		);
		
		$result = $uids_query->row_array();
		
		$user_query = $this->db->query(
			"
			SELECT *
			FROM users 
			WHERE id={$result["user_id"]};
			"
		);
		
		$user=$user_query->row_array();
		
		return $user;
	}
	
	
	function get_images($series_id)
	{
		$images=[];
		
		$iids_query = $this->db->query(
			"
			SELECT image_id
			FROM image_mapping
			WHERE series_id={$series_id}
			"
		);
		foreach ($iids_query->result_array() as $result)
		{
			$images_query = $this->db->query(
				"
				SELECT *
				FROM images
				WHERE id={$result["image_id"]}
				"
			);
			
			array_push($images, $images_query->row_array());
		}
		
		return $images;
	}
	
	function add_image_info($series_id, $image_files)
	{
		for($i=0;$i<count($image_files["name"]);$i++)
		{
			$series_query=$this->db->query(
				"
				SELECT *
				FROM series
				WHERE id={$series_id}
				"
			);
			$series=$series_query->row_array();
			
			$image_info["original_name"]=$image_files['name'][$i];
			//$image_info['raw_name']=$info['raw_name'];
			// $image_info["file_name"]=$info["file_name"];
			$sub_file_name=substr($image_files["name"][$i], strrpos($image_files["name"][$i], ".")+1);
			$new_name=$this->session->userdata("account") . "_" . $series["name"] . "_" . date("YmdHis", time()) . "_" . $i . "." . $sub_file_name;
			$image_info["file_name"]=$new_name;
			$image_info["comment"]="";
			
			if($this->db->insert('images',$image_info))
			{
				rename("./images/{$image_files["name"][$i]}", "./images/{$new_name}");
					
				$num=$this->db->insert_id();
					
				$mapping_info["series_id"]=$series_id;
				$mapping_info["image_id"]=$num;
				$this->db->insert("image_mapping",$mapping_info);
				
				if($series["represented_image_id"]<0)
				{
					$this->db->query(
						"
						UPDATE series
						SET represented_image_id={$num},
						represented_image_file_name='{$image_info["file_name"]}'
						WHERE id={$series["id"]}
						"
					);
				}
			}
			else 
			{
				return 'wrong with database';
			}
		}
		
		return '';
	}
	
	function new_series()
	{
		// can reference the send_signup() in users_model
		$series_info["name"]=$this->input->post("series_name");
		$series_info["represented_image_id"]=-1;
		$series_info["represented_image_raw_name"]="";
		
		if($this->db->insert("series", $series_info))
		{
			$mapping_info["series_id"]=$this->db->insert_id();
			$mapping_info["user_id"]=$this->session->userdata("id");
				
			$this->db->insert("series_mapping", $mapping_info);
			
			$user_query=$this->db->query(
				"
				SELECT *
				FROM users
				WHERE id={$this->session->userdata("id")};
				"
			);
		}
	}
	
	function delete_series($series_id)
	{
		$delete_query = $this->db->query(
			"
			DELETE
			FROM series
			WHERE id={$series_id};
			"
		);
		
		$delete_query = $this->db->query(
			"
			DELETE
			FROM series_mapping
			WHERE series_id={$series_id};
			"
		);
		
		$images=$this->get_images($series_id);
		
		$delete_query = $this->db->query(
			"
			DELETE
			FROM image_mapping
			WHERE series_id={$series_id};
			"
		);
		
		$this->load->helper('file');
		
		foreach ($images as $image)
		{
			$delete_query = $this->db->query(
				"
				DELETE
				FROM images
				WHERE id={$image["id"]};
				"
			);
			
			unlink("./images/{$image["file_name"]}");
		}
		
	}
	
	function get_single_series($series_id)
	{
		$series_query = $this->db->query(
			"
			SELECT *
			FROM series
			WHERE id={$series_id};
			"
		);

		return $series_query->row_array();
	}
	
	function get_images_num($series_id)
	{
		$images=[];
		
		$iids_query = $this->db->query(
			"
			SELECT image_id
			FROM image_mapping
			WHERE series_id={$series_id}
			"
		);
		
		return $iids_query->result_array().size();
	}
	
	function save_comments($series_id)
	{
		$descriptions=$this->input->post("descriptions");
		foreach ($descriptions as $id => $description)
		{
			$this->db->query(
				"
				UPDATE images
				SET comment = '{$comment}'
				WHERE id={$image["id"]}
				"
			);
		}
		
		
		/*
		$images=$this->get_images($series_id);
		
		foreach ($images as $image)
		{
			$comment=$this->input->post("comment{$image["id"]}");
			
			$this->db->query(
				"
				UPDATE images
				SET comment = '{$comment}'
				WHERE id={$image["id"]}
				"
			);
		}
		*/
	}
	
	function delete_image($series_id, $image_id)
	{
		$image_query = $this->db->query(
			"
			SELECT *
			FROM images
			WHERE id={$image_id}
			"
		);
		
		$image=$image_query->row_array();
		
		$series_query = $this->db->query(
			"
			SELECT *
			FROM series
			WHERE id={$series_id}
			"
		);
		
		$series=$series_query->row_array();
		
		
		$delete_query = $this->db->query(
			"
			DELETE
			FROM images
			WHERE id={$image_id};
			"
		);
		
		$delete_query = $this->db->query(
			"
			DELETE
			FROM image_mapping
			WHERE image_id={$image_id};
			"
		);
		
		
		if($image_id==$series["represented_image_id"])
		{
			// change represented picture
			$images=$this->get_images($series_id);
				
			$new["id"]=-1;
			$new["raw_name"]='';
			$new["file_name"]='';
			
			foreach ($images as $new_image)
			{
				if($new["id"]==-1 || $new_image["id"]<$new["id"])
				{
					$new["id"]=$new_image["id"];
					$new["raw_name"]=$new_image["raw_name"];
					$new["file_name"]=$new_image["file_name"];
				}
			}
			
			$this->db->query(
				"
				UPDATE series
				SET represented_image_id={$new["id"]},
				represented_image_raw_name='{$new["raw_name"]}',
				represented_image_file_name='{$new["file_name"]}'
				WHERE id={$series["id"]}
				"
			);
		}
		
		unlink("./images/{$image["file_name"]}");
	}
	
	function change_series_name($series_id, $name)
	{
		$this->db->query(
			"
			UPDATE series
			SET name = '{$name}'
			WHERE id={$series_id}
			"
		);
	}
	
	function change_series_representation($series_id, $image_id)
	{	
		$image_info=$this->db->query(
			"
			SELECT *
			FROM images
			WHERE id={$image_id}
			"
		)->row_array();
		
		$this->db->query(
			"
			UPDATE series
			SET represented_image_id={$image_id},
			    represented_image_raw_name='{$image_info["raw_name"]}',
			    represented_image_file_name='{$image_info["file_name"]}'
			WHERE id={$series_id}
			"
		);
	}
}


?>