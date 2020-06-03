<?php
class Home_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getGoods()
	{
		$res = $this->db->get('goods');
		return $res->result_array();
	}

	public function getGoodById($id)
	{
		$query = $this->db->get_where('goods', array('id' => $id));
		return $query->result_array();
	}

	public function addImages($data)
	{
		$insert = $this->db->insert("images", $data);
		if($insert)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	public function registration($data)
	{		
       $insert=$this->db->insert('customers',$data);
       if($insert)
       {
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}

	}

}


?>