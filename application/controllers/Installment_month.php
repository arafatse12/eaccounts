<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment_month extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('Installment_month_model','installment_month');
	}

	public function index(){
		$this->permission_check('installment_month_view');
		$data=$this->data;//My_Controller constructor data accessed here
		$data['page_title']=$this->lang->line('installment_month_list');
		$this->load->view('installment_month_list',$data);
	}
	public function edit($id){

		$data = $this->data;
		$this->load->model('installment_month');
		$data = $this->installment_month->get_details($id);
		$data['page_title']=$this->lang->line('edit_installment_month');
		$this->load->view('installment_month', $data);
	}
	public function save_or_update(){
		
		//print_r($_POST);exit();
		$data=$this->data;//My_Controller constructor data accessed here
		$this->form_validation->set_rules('month', 'month', 'required');
		$id = $this->input->post('q_id');
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('installment_month');
			if(empty($id)){
				$result =$this->installment_month->verify_and_save();
			}
			else{
				$month=$this->input->post('month');
				$q_id=$this->input->post('q_id');
				$data['q_id']=$q_id;
				$query1="update db_installment_month set month='$month' where id=$q_id";
				if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Month Updated Successfully!');
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
		$this->permission_check('installment_month_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('installment_month');
		$this->load->view('installment_month', $data);
	}
	
	public function delete_installment_month(){
		$this->permission_check('installment_month_delete');
		$this->load->model('installment_month');
		$id = $this->input->post('q_id');
		$result = $this->installment_month->delete_installment_month($id);
		return $result;
	}
}

