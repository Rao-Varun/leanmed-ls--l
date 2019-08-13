<?php
	class About extends CI_Controller{
		public function index(){
			if($this->session->userdata('user')==""){
				$this->session->set_flashdata("message",'session expired');
				redirect('login');
			}
			$data['title']= 'About';
			$this->load->view('templates/header',$data);
			$this->load->view('templates/nav');
			$this->load->view('pages/about');
			$this->load->view('templates/footer');
		}
	}