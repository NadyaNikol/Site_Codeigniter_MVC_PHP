<?php
#defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}


	public function index()
	{
		$data['title']='Page1';
		$data['text']='The books of Clifford Donald
		Simak';
		$data['countries']=array('Ring Around the Sun', 'Time is the Simplest Thing','Way Station','All
		Flesh Is Grass', 'The Goblin Reservation',"The Fellowship of the Talisman");
		$this->load->view('page1', $data);
	}

	public function goodsList()
	{
		$data['title']='List Of Goods';
		$data['goods']=$this->home_model->getGoods();
		$this->load->view('goods',$data);
	}

	public function getGoodInfo()
	{
		$send=$this->input->post('send');

		if(!$send)
			{$this->load->view('form_good_id');}
		else
		{
			$id=$this->input->post('goodid');
			$good=$this->home_model->getGoodById($id);
			$data['good']=$good;
			$data['title']='Description Of Goods '.$id;
			$this->load->view('good_info', $data);
		}
	}

	function getGoodInfo2()
	{ 
		if (!$this->input->post('send'))
		{ 
			$data['list']=$this->home_model->getGoods();
			$this->load->view('form_good_id2',$data);
		}
		else
		{
			$id=$this->input->post('goodid');
			$good=$this->home_model->getGoodById($id);
			$data['good']=$good;
			$data['title']='Description Of Goods '.$id;
			$this->load->view('good_info',$data);
		}
	}


	public function selectImages()
	{
		$send=$this->input->post('send');

		if(!$send)
			{$this->load->view('form_upload');}
		else
		{
			$config['upload_path'] = './assets/images/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 2048;
			$config['max_width'] = 1024;
			$config['max_height'] = 768;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('image'))
			{
				$info = array('upload_data'=> $this->upload->data());
				//path to the uploaded images folder
				$path='assets/images/';
				//create array $data for model method
				$data=array('goodid'=>14, 'imagepath'=>$path.$info['upload_data']['file_name']);
				$goodid=$this->home_model->addImages($data); 

				if($goodid != false)
				{
					$info = array('result'=>'Successfuly Inserted New Image With Id='.$goodid);
					$this->load->view('form_upload', $info);
				}
			}
		}
	}


	public function selectMultipleImages()
	{
		$send=$this->input->post('send');

		if(!$send)
			{$this->load->view('form_upload_multiple');}

		else
		{
			$config['upload_path'] = './assets/images/';//. ??????????????
			$config['allowed_types'] ='gif|jpg|png|jpeg';
			$config['max_size'] = 2048;
			$config['max_width'] = 1024;
			$config['max_height'] = 768;
			//now we initialize the upload library
			$this->load->library('upload', $config);
			//we retrieve the number of files that were uploaded
			$number_of_files = sizeof($_FILES['upfile']['tmp_name']);
			//we create array $files out of uploaded files
			$files = $_FILES['upfile'];
			$error = array();
			$success = array();
			//now, taking into account that there can be more than one file,
			//we use loop to process all the files
			for ($i = 0; $i < $number_of_files; $i++)
			{
				$_FILES['upfile']['name'] =$files['name'][$i];
				$_FILES['upfile']['type'] =$files['type'][$i];
				$_FILES['upfile']['tmp_name'] =$files['tmp_name'][$i];
				$_FILES['upfile']['error'] = $files['error'][$i];
				$_FILES['upfile']['size'] =$files['size'][$i];

				if($_FILES['upfile']['error'][$i] != 0)
				{
					$error['msg'.$i]='Not uploaded file '.$_FILES['upfile']['name'][$i];
					continue;
				}

				if ( ! $this->upload->do_upload('upfile'))
				{
					$error['msg'.$i]= 'Not uploaded file'.$_FILES['upfile']['name'][$i];
				}

				else
				{
					$final_files_data[] = $this->upload->data();
					//Continue processing the uploaded data receive data about upload
					$info = array('upload_data' =>$this->upload->data());
					//path to the uploaded images folder
					$path='assets/images/';
					//create array for model method 
					$data=array('goodid'=>15,'imagepath'=>$path.$info['upload_data']['file_name']);
					$goodid=$this->home_model->addImages($data);
					//create array for upload form with success message
					$success['msg'.$i]= 'Successfuly Inserted New Image With Id='.$goodid;
				}
			}

			var_dump($success);
			echo '<br/>';
			var_dump($error);
			$result['error']=$error;
			$result['success']=$success;
			$this->load->view('form_upload_multiple',$result);
		}
	}


	public function registration()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'User name', 
		'trim|required|min_length[5]|max_length[12]|is_unique[customers.login]',
		array('required' => 'You have not filled %s.', 'is_unique' => 'Value %s already exists.')
		);
		$this->form_validation->set_rules('pass1', 'Password', 
			'trim|required|min_length[5]|max_length[12]'); 
		$this->form_validation->set_rules('pass2', 'Password Confirmation',
		'required|matches[pass1]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('form_validation');
		}
		else
		{
			$data['success']='Form data passed the validation';
			$this->load->view('form_validation', $data);

			$log = $this->input->post('login');
			$pass = $this->input->post('pass1');
			$email = $this->input->post('email');

			$data2=array('login'=>$log, 'pass'=>$pass, 'email'=>$email, 'roleid'=>2);
			$this->home_model->registration($data2); 

		}

	}


	public function showMap()
	{
		$this->load->library('googlemaps');
		$config['center'] = '47.907842, 33.387417';
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['position'] = '47.907842, 33.387417';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		$this->load->view('view_map', $data);
	}

}








