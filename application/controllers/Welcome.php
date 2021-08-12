<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('UserModel','UM');
	}
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	function savedata(){
		 $countfiles = count($_FILES['files']['name']);
		 $imagearray = [];
		 for($i=0;$i<$countfiles;$i++){
			if(!empty($_FILES['files']['name'][$i])){
			  // Define new $_FILES array - $_FILES['file']
			  $_FILES['file']['name'] = $_FILES['files']['name'][$i];
			  $_FILES['file']['type'] = $_FILES['files']['type'][$i];
			  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
			  $_FILES['file']['error'] = $_FILES['files']['error'][$i];
			  $_FILES['file']['size'] = $_FILES['files']['size'][$i];
			  // Set preference
			  $config['upload_path'] = './uploads/'; 
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['max_size'] = '5000'; // max_size in kb
			  $config['file_name'] = $_FILES['files']['name'][$i];
			  $config['encrypt_name'] = TRUE;
			  //Load upload library
			  $this->load->library('upload',$config); 
			  $arr = array('msg' => 'something went wrong', 'success' => false);
			  // File upload
			  if($this->upload->do_upload('file')){
			   $data = $this->upload->data(); 
			   $imagearray[$i] = $data['file_name'];
			  }
			}
		  }
			// data send to data base
			$data = array(
			"Password" => $this->input->post('password'),
			"Email" => $this->input->post('email'),
			"Mobile" => $this->input->post('mobilenum'),
			"Name" => $this->input->post('fullname'),
		    "File"=>implode(",",$imagearray),	
		);
			// echo '<pre>';
 			// print_r($data);
		
			echo($this->UM->AddData($data,'user'))?'1':'0';
	}

	function GetData(){
		  $query = $this->UM->ShowData('user','DESC','id');
		  $data =  $query->result_array();
		   for($i=0;$i<$query->num_rows();$i++){
			  $data[$i]['File'] = explode(',', $data[$i]['File']);
		   }
		 echo json_encode($data);
	}

}