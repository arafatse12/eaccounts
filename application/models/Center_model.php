<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center_model extends CI_Model {

	
	
	var $table = 'db_center';
	var $column_order = array(null, 'name','department_id'); 
	var $column_search = array('name','department_id'); 
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
		$department_id = $this->input->post('department_id');
		$query1="insert into db_center(name,department_id) 
							values('$name','$department_id')";
		if ($this->db->simple_query($query1)){
			$this->session->set_flashdata('success', 'Success!! New Center Added Successfully!');
			return "success";
		}
		else{
			return "failed";
		}
		
	}

	//Get brand_details
	public function get_details($id){
		$data=$this->data;
		$query = $this->db->query("select * from db_center where id=$id");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query = $query->row();
			$data['q_id'] = $query->id;
			$data['name'] = $query->name;
			$data['department_id'] = $query->department_id;
			return $data;
		}
	}
	public function update_department(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));

		//Validate This brand already exist or not
		$query=$this->db->query("select * from db_center where name=$name where department_id=$department_id and id<>$q_id");
		if($query->num_rows()>0){
			return "This Center Name already Exist.";
		}
		else{
			$query1="update db_center set name='$name',department_id='$department_id' where id=$q_id";
			if ($this->db->simple_query($query1)){
				$this->session->set_flashdata('success', 'Success!! Center Updated Successfully!');
				return "success";
			}
			else{
			    return "failed";
			}
		}
	}
	public function delete_center($id){
        $query1="delete from db_center where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
            $this->session->set_flashdata('success', 'Success!! Center Deleted Succssfully!');
        }
        else{
            echo "failed";
        }
	}


}