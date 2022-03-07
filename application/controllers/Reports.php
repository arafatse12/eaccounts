<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('reports_model','reports');
	}
	
		
	//Sales Report 
	public function sales(){
		$this->permission_check('sales_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_report');
		$this->load->view('report-sales', $data);
	}
	public function all_sales(){
		$this->permission_check('sales_report');
		$userType  = $this->session->userdata('inv_user_type');
		$departmentId  = $this->session->userdata('inv_user_department_id');
		$centerId  = $this->session->userdata('inv_user_center_id');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_report');
		$data['dailyInvoices'] =$this->db->query("SELECT * FROM db_sales WHERE DATE(created_date) = CURDATE()")->num_rows();
		$data['monthlyInvoices'] =$this->db->query("SELECT * FROM db_sales WHERE MONTH(created_date) = MONTH(CURRENT_DATE())
		AND YEAR(created_date) = YEAR(CURRENT_DATE()) ")->num_rows();
		$data['yearlyInvoices'] =$this->db->query("SELECT * FROM db_sales WHERE YEAR(created_date) = YEAR(CURRENT_DATE())")->num_rows();
		$data['allTypesSalesToday'] =$this->db->query("SELECT SUM(paid_amount) as paid_amount FROM db_sales WHERE sales_type != 3 and user_type='$userType' and department_id='$departmentId' and center_id='$centerId' and DATE(created_date) = CURDATE()")->row()->paid_amount;

		$data['allTypesSalesToday1'] =$this->db->query("SELECT SUM(paid_amount) as paid_amount FROM db_sales WHERE sales_type != 3 and user_type='$userType' and department_id='$departmentId' and center_id='$centerId' and MONTH(created_date) = MONTH(CURRENT_DATE())
		AND YEAR(created_date) = YEAR(CURRENT_DATE()");

$data['payments'] = $this->db->query("SELECT payment_type,SUM(
	CASE WHEN created_date = CURRENT_DATE()
	THEN payment
	ELSE 0
	END
) as daily_sales,
SUM(IF(MONTH(created_date) = MONTH(CURRENT_DATE())
	AND YEAR(created_date) = YEAR(CURRENT_DATE()),payment, 0)) as monthly_sales,SUM(IF(
	YEAR(created_date) = YEAR(CURRENT_DATE()),payment, 0)) as yearly_sales FROM db_salespayments 
where sales_id in (select id from db_sales  where sales_type=1 and  user_type='$userType' and department_id='$departmentId' and center_id='$centerId') GROUP BY payment_type");

	$data['paymentsHaierSale'] = $this->db->query("SELECT DISTINCT db_salespayments.sales_id,db_salespayments.payment_type,SUM(
		CASE WHEN db_sales.created_date = CURRENT_DATE()
		THEN subtotal
		ELSE 0
		END
	) as daily_sales,
	SUM(IF(MONTH(db_sales.created_date) = MONTH(CURRENT_DATE())
		AND YEAR(db_sales.created_date) = YEAR(CURRENT_DATE()),subtotal, 0)) as monthly_sales,SUM(IF(
		YEAR(db_sales.created_date) = YEAR(CURRENT_DATE()),subtotal, 0)) as yearly_sales FROM db_sales
	JOIN db_salespayments ON db_salespayments.sales_id = db_sales.id   where sales_type=3 and user_type='$userType' and department_id='$departmentId' and center_id='$centerId' GROUP BY payment_type ORDER BY sales_id");
	$data['paymentsDownPayment'] = $this->db->query("SELECT SUM(
			CASE WHEN paid_date = CURRENT_DATE()
			THEN down_payment
			ELSE 0
			END
		) as daily_down_payment,
		SUM(IF(MONTH(paid_date) = MONTH(CURRENT_DATE())
			AND YEAR(paid_date) = YEAR(CURRENT_DATE()),down_payment, 0)) as monthly_down_payment,SUM(IF(
			YEAR(paid_date) = YEAR(CURRENT_DATE()),down_payment, 0)) as yearly_down_payment FROM db_installment_payments 
		 where sale_id in (select id from db_sales where sales_type=3 and user_type='$userType' and department_id='$departmentId' and center_id='$centerId' )  and schedule_number=0");

		 $data['installmentPayment'] = $this->db->query("SELECT SUM(
			CASE WHEN paid_date = CURRENT_DATE()
			THEN paid_amount
			ELSE 0
			END
		) as daily_installment,
		SUM(IF(MONTH(paid_date) = MONTH(CURRENT_DATE())
			AND YEAR(paid_date) = YEAR(CURRENT_DATE()),paid_amount, 0)) as monthly_installment,SUM(IF(
			YEAR(paid_date) = YEAR(CURRENT_DATE()),paid_amount, 0)) as yearly_installment FROM db_installment_payments 
		 where sale_id in (select id from db_sales where sales_type=3 and user_type='$userType' and department_id='$departmentId' and center_id='$centerId')  and schedule_number!=0");

		$data['accountReceivable'] = $this->db->query("SELECT SUM(
			CASE WHEN created_date = CURRENT_DATE()
			THEN paid_amount
			ELSE 0
			END
		) as daily_receivable,
		SUM(IF(MONTH(created_date) = MONTH(CURRENT_DATE())
			AND YEAR(created_date) = YEAR(CURRENT_DATE()),paid_amount, 0)) as monthly_receivable,SUM(IF(
			YEAR(created_date) = YEAR(CURRENT_DATE()),paid_amount, 0)) as yearly_receivable FROM db_sales 
		where sales_type=2 and user_type='$userType' and department_id='$departmentId' and center_id='$centerId' ");

		$data['totalCash'] = $this->db->query("SELECT payment_type,SUM(
			CASE WHEN created_date = CURRENT_DATE()
			THEN payment
			ELSE 0
			END
		) as daily,
		SUM(IF(MONTH(created_date) = MONTH(CURRENT_DATE())
			AND YEAR(created_date) = YEAR(CURRENT_DATE()),payment, 0)) as monthly,SUM(IF(
			YEAR(created_date) = YEAR(CURRENT_DATE()),payment, 0)) as yearly FROM db_salespayments 
		where sales_id in (select id from db_sales where user_type='$userType' and department_id='$departmentId' and center_id='$centerId') GROUP BY payment_type");


		$this->load->view('report-sales-all', $data);
	}
	
	public function show_sales_report(){
		echo $this->reports->show_sales_report();
	}

	//Sales Return Report 
	public function sales_return(){
		$this->permission_check('sales_return_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_return_report');
		$this->load->view('report-sales-return', $data);
	}
	public function show_sales_return_report(){
		echo $this->reports->show_sales_return_report();
	}

	//Purchase report
	public function purchase(){
		$this->permission_check('purchase_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_report');
		$this->load->view('report-purchase', $data);
	}
	public function show_purchase_report(){
		echo $this->reports->show_purchase_report();
	}

	//Purchase Return report
	public function purchase_return(){
		$this->permission_check('purchase_return_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_return_report');
		$this->load->view('report-purchase-return', $data);
	}
	public function show_purchase_return_report(){
		echo $this->reports->show_purchase_return_report();
	}

	//Expense report
	public function expense(){
		$this->permission_check('expense_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expense_report');
		$this->load->view('report-expense', $data);
	}
	public function show_expense_report(){
		echo $this->reports->show_expense_report();
	}
	//Profit report
	public function profit_loss(){
		$this->permission_check('profit_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('profit_and_loss_report');
		$this->load->view('report-profit-loss', $data);
	}
	public function get_profit_loss_report(){
		echo json_encode($this->reports->get_profit_loss_report());
	}
	public function get_profit_by_item(){
		echo $this->reports->get_profit_by_item();
	}
	public function get_profit_by_invoice(){
		echo $this->reports->get_profit_by_invoice();
	}

	//Summary report
	public function stock(){
		$this->permission_check('stock_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('stock_report');
		$this->load->view('report-stock', $data);
	}
	/*Stock Report*/
	public function show_stock_report(){
		echo $this->reports->show_stock_report();
	}
	public function brand_wise_stock(){
		echo $this->reports->brand_wise_stock();
	}
	//Item Sales Report 
	public function item_sales(){
		$this->permission_check('item_sales_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('item_sales_report');
		$this->load->view('report-sales-item', $data);
	}
	public function show_item_sales_report(){
		echo $this->reports->show_item_sales_report();
	}
	//Item purchase Report 
	public function item_purchase(){
		$this->permission_check('item_purchase_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('item_purchase_report');
		$this->load->view('report-purchase-item', $data);
	}
	public function show_item_purchase_report(){
		echo $this->reports->show_item_purchase_report();
	}
	//Purchase Payments report
	public function purchase_payments(){
		$this->permission_check('purchase_payments_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_payments_report');
		$this->load->view('report-purchase-payments', $data);
	}
	public function show_purchase_payments_report(){
		echo $this->reports->show_purchase_payments_report();
	}
	public function supplier_payments_report(){
		echo $this->reports->supplier_payments_report();
	}

	//Sales Payments report
	public function sales_payments(){
		$this->permission_check('sales_payments_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_payments_report');
		$this->load->view('report-sales-payments', $data);
	}
	public function show_sales_payments_report(){
		echo $this->reports->show_sales_payments_report();
	}
	public function customer_payments_report(){
		echo $this->reports->customer_payments_report();
	}
	//Expired Items Report 
	public function expired_items(){
		$this->permission_check('expired_items_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expired_items_report');
		$this->load->view('report-expired-items', $data);
	}
	public function show_expired_items_report(){
		echo $this->reports->show_expired_items_report();
	}

	
}

