<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

	
	
	var $table = 'db_branch';
	var $column_order = array(null, 'name'); 
	var $column_search = array('name'); 
	var $order = array('id' => 'desc'); 

	function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function verify_and_save(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		$name = $this->input->post('name');
		$query1="insert into db_branch(name) 
							values('$name')";
		if ($this->db->simple_query($query1)){
			$this->session->set_flashdata('success', 'Success!! New Branch Added Successfully!');
			return "success";
		}
		else{
			return "failed";
		}
		
	}

	//Get brand_details
	public function get_details($id){
		$data=$this->data;
		$query = $this->db->query("select * from db_branch where id=$id");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query = $query->row();
			$data['q_id'] = $query->id;
			$data['name'] = $query->name;
			return $data;
		}
	}
	public function update_branch(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		//Validate This brand already exist or not
		$query=$this->db->query("select * from db_branch where name=$name where id<>$q_id");
		if($query->num_rows()>0){
			return "This Branch Name already Exist.";
		}
		else{
			$name = $this->input->post('name');
			$query1="update db_branch set name='$name' where id=$q_id";
			if ($this->db->simple_query($query1)){
				$this->session->set_flashdata('success', 'Success!! Branch Updated Successfully!');
				return "success";
			}
			else{
			    return "failed";
			}
		}
	}
	public function delete_branch($id){
        $query1="delete from db_branch where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
            $this->session->set_flashdata('success', 'Success!! Branch Deleted Succssfully!');
        }
        else{
            echo "failed";
        }
	}


}