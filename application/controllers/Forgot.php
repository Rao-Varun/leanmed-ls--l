<?php
	class Forgot extends CI_Controller{
		public function index(){
			$data['title']= 'Forgot Password';
			$this->load->view('templates/header',$data);
			$this->load->view('pages/forgot');
			$this->load->view('templates/footer');
		}
		public function forgotpass(){
			$data['title']= 'Home';
			$form_data = $this->input->post();
			$data['user'] = $this->user_model->getUserById($form_data['emailId']);
			if($data['user']!=""){
				$message='<html><body><h4>Please click on the <a href="'.$this->config->base_url().'forgot/change/'.$data['user']['password'].'">link</a> to recover your password</h4></body></html>';
				$this->user_model->sendEmail($form_data['emailId'],'Password Recovery',$message);
				$this->session->set_flashdata("message","Recovery email sent to your mail id");
				redirect('forgot');
			}
			else{
				$this->session->set_flashdata("message","EmailId not found");
				redirect('forgot');
			}
		}
		public function update(){
			$form_data = $this->input->post();
			print_r($form_data);
			$this->user_model->forgot_pass($form_data['emailId'],$form_data['password']);
			$this->session->set_flashdata("message","Password reset");
			redirect('login');	
		}
		public function change($id=""){
				$data['user'] = $this->user_model->getUserByPassword($id);
				if($data['user']!=""){
					$data['title']= 'Change Password';
					$this->load->view('templates/header',$data);
					$this->load->view('pages/change',$data);
					$this->load->view('templates/footer');
				}
				else{
					$this->session->set_flashdata("message","EmailId not found");
					redirect('forgot');
				}
		}
	}