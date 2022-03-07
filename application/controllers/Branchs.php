<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branchs extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('branch_model','branchs');
	}

	public function index(){
		// $this->permission_check('places_view');
		$data=$this->data;//My_Controller constructor data accessed here
		$data['page_title']=$this->lang->line('branch_list');
		$this->load->view('branch_list',$data);
	}
	public function edit($id){

		$data = $this->data;
		$this->load->model('branch_model');
		$data = $this->branchs->get_details($id);
		$data['page_title']=$this->lang->line('edit_branch');
		$this->load->view('branchs', $data);
	}
	public function save_or_update(){
		
		//print_r($_POST);exit();
		$data=$this->data;//My_Controller constructor data accessed here
		$this->form_validation->set_rules('name', 'name', 'required|trim');
		$id = $this->input->post('q_id');
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('branch_model');
			if(empty($id)){
				$result =$this->branchs->verify_and_save();
			}
			else{
				$name=$this->input->post('name');
				$q_id=$this->input->post('q_id');
				$data['q_id']=$q_id;
				$query1="update db_branch set name='$name' where id=$q_id";
				if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Department Updated Successfully!');
					$result  = "success";
				}
				else{
					$result  = "failed";
				}
			}
			
			echo $result;
		} 
		else {
			echo validation_errors();
			//echo  "Username & Password must have 5 to 15 Characters!";
		}
	
	}

	public function new(){
		// $this->permission_check('places_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('branchs');
		$this->load->view('branchs', $data);
	}
	
	public function delete_branch(){
		$this->load->model('branch_model');
		$id = $this->input->post('q_id');
		$result = $this->branchs->delete_branch($id);
		return $result;
	}
}

