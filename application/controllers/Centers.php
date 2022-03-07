<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Centers extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('center_model','centers');
	}

	public function index(){
		// $this->permission_check('places_view');
		$data=$this->data;//My_Controller constructor data accessed here
		$data['page_title']=$this->lang->line('center_list');
		$this->load->view('center_list',$data);
	}
	public function edit($id){

		$data = $this->data;
		$this->load->model('center_model');
		$data = $this->centers->get_details($id);
		$data['page_title']=$this->lang->line('edit_center');
		$this->load->view('centers', $data);
	}
	public function save_or_update(){
		
		//print_r($_POST);exit();
		$data=$this->data;//My_Controller constructor data accessed here
		$this->form_validation->set_rules('name', 'name', 'required|trim');
		$this->form_validation->set_rules('department_id', 'department_id', 'required|trim');
		$id = $this->input->post('q_id');
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('center_model');
			if(empty($id)){
				$result =$this->centers->verify_and_save();
			}
			else{
				$name=$this->input->post('name');
				$department=$this->input->post('department_id');
				$q_id=$this->input->post('q_id');
				$data['q_id']=$q_id;
				$query1="update db_center set name='$name',department_id='$department' where id=$q_id";
				if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Center Updated Successfully!');
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
		$data['page_title']=$this->lang->line('center');
		$this->load->view('centers', $data);
	}
	
	public function delete_center(){
		$this->load->model('center_model');
		$id = $this->input->post('q_id');
		$result = $this->centers->delete_center($id);
		return $result;
	}
}

