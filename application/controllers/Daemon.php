<?php
class Daemon extends CI_Controller {
	public function index(){
		$data['title']= 'Daemon';
		$this->load->view('templates/header',$data);
		$this->load->view('pages/index');
		$this->load->view('templates/footer');
	}

	public function add_log(){
		$form_data = $this->input->post();
		$log=$form_data['log'];
		$userId=$form_data['userId'];
		$users=$form_data['users'];
			$data = array(
					 	'log'=>$log,
					 	'userId'=>$userId
					 );
			$this->db->insert('logs',$data);
			$logId = $this->db->insert_id();
			if (!is_array($users)) {
				print_r($users);
				/*$data = array(
					 	'logId'=>$logId,
					 	'emailId'=>$users,
					 	'status'=>'pending'
					 );
				$this->db->insert('logusers',$data);*/
				$this->sendEmail($users,$log,$log);	
			}
			else{
				/*for($i=0;$i<count($users);$i++){
				$data = array(
					 	'logId'=>$logId,
					 	'emailId'=>$users[$i],
					 	'status'=>'pending'
					 );
				$this->db->insert('logusers',$data);
				}*/
				$this->sendEmail($users,$log,$log);	
			}
		}
		public function sendEmail($to_email,$subject,$message){
			$this->email->from('prakhar.sapre2610@gmail.com', 'Item Finder Support'); 
        	$this->email->to($to_email);
        	$this->email->subject($subject); 
        	$this->email->message($message);
        	$this->email->set_mailtype("html"); 	
        	$this->email->send();
		}
		public function send(){
			$form_data = $this->input->post();
			$this->sendEmail($form_data['userId'],$form_data['subject'],$form_data['message']);	
		}
}
