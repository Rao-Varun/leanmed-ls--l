<?php
	class Register extends CI_Controller{
		public function index(){
			$data['title']= 'Register';
			$this->load->view('templates/header',$data);
			$this->load->view('pages/register');
			$this->load->view('templates/footer');
		}
		public function registerUser(){
			$form_data = $this->input->post();
			$message = $this->user_model->registerUser($form_data);
			$this->session->set_flashdata("message",$message);
			redirect('login');
		}
	}