	<?php
	class Admin extends CI_Controller{
		public function index(){
			if($this->session->userdata('user')==""){
				$this->session->set_flashdata("message",'session expired');
				redirect('login');
			}
			elseif ($this->session->userdata('user')['userType']==2) {
				$this->session->set_flashdata("message",'Forbidden Access');
				redirect('home');
			}
			$data['title']= 'Admin';
			$this->load->view('templates/header',$data);
			$this->load->view('templates/nav');
			$this->load->view('pages/admin');
			$this->load->view('templates/footer');
		}
		public function users(){
			header('Content-Type: application/json');
			echo json_encode($this->user_model->getUsersByHouseId($this->session->userdata('user')['houseId']));
		}
		public function editUser(){
			$form_data = $this->input->post();
			$form_data['houseId']=$this->session->userdata('user')['houseId'];
			if($form_data['oper']== 'add')
				$this->user_model->add_user($form_data);
			elseif ($form_data['oper']== 'edit') 
				$this->user_model->edit_user($form_data);
			elseif ($form_data['oper']== 'del') {
				$this->user_model->del_user($form_data);
			}
			header('Content-Type: application/json');
			echo json_encode(true);
		}
		public function approvals(){
			header('Content-Type: application/json');
			echo json_encode($this->user_model->getApprovalsByHouseId($this->session->userdata('user')['houseId']));
		}

		public function manageApproval(){
			$result = $this->input->post();
			
			if($result['table'] == 'storage'){
				$this->db->where('storageId',$result['id']);
				$query = $this->db->get('storage');
				foreach ($query->result_array() as $row){
					$refId = $row['ref'];
				}
			}else{
				$this->db->where('itemId',$result['id']);
				$query = $this->db->get('items');
				foreach ($query->result_array() as $row){
					$refId = $row['ref'];
				}
			}

			if($result['action'] == 'approve'){
				if(strpos($result['history'],"edit")){
					if($result['table'] == 'storage'){
						$this->db->where('storageId',$refId);
						$this->db->delete('storage');
						$query = $this->db->query("update storage set status='active' where storageId=".$result['id']);

					}
					else if($result['table']== 'items'){
						$this->db->where('itemId',$refId);
						$this->db->delete('items');
						$query = $this->db->query("update items set status='active' where itemId=".$result['id']);
					}
				}else{
					if(strpos($result['history'],"delete")){
						if($result['table'] == 'storage'){
							$this->db->where('storageId',$result['id']);
							$this->db->delete('storage');
						}
						else if($result['table'] == 'items'){
							$this->db->where('itemId',$result['id']);
							$this->db->delete('items');
						}

					}else{
						if($result['table'] == 'storage'){
							$query = $this->db->query("update storage set status='active' where storageId=".$result['id']);
						}
						else if($result['table'] == 'items'){
							$query = $this->db->query("update items set status='active' where itemId=".$result['id']);
						}
					}
				}
			}else{
				if(strpos($result['history'],"edit")){
					if($result['table'] == 'storage'){
						$data['status'] = "active";
						$this->db->where('storageId',$refId);
						$this->db->update('storage',$data);
						$this->db->where('storageId',$result['id']);
						$this->db->delete('storage');
					}
					else if($result['table']== 'items'){
						$data['status'] = "active";
						$this->db->where('itemId',$refId);
						$this->db->update('items',$data);
						$this->db->where('itemId',$result['id']);
						$this->db->delete('items');
					}
				}else{
					if(strpos($result['history'],"delete")){
						if($result['table'] == 'storage'){
							$data['status'] = "active";
							$this->db->where('storageId',$result['id']);
							$this->db->update('storage',$data);
						}
						else if($result['table']== 'items'){
							$data['status'] = "active";
							$this->db->where('itemId',$result['id']);
							$this->db->update('items',$data);
						}
					}
				}
			}
			
			redirect('admin');
		}

	}