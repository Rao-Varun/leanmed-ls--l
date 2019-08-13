<?php
	class Activity extends CI_Controller{
		public function index(){
			if($this->session->userdata('user')==""){
				$this->session->set_flashdata("message",'session expired');
				redirect('login');
			}
			$data['title']= 'Activity';
			$this->load->view('templates/header',$data);
			$this->load->view('templates/nav');
			$logs=$this->user_model->get_logs();
			$data['logs']=$logs;
			$this->load->view('pages/activity',$data);
			$this->load->view('templates/footer');		
	}
}