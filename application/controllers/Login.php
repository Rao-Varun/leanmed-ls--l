<?php
class Login extends CI_Controller {
	public function index(){
		$data['title']= 'Login';
		$this->load->view('templates/header',$data);
		$this->load->view('pages/index');
		$this->load->view('templates/footer');
	}
}
