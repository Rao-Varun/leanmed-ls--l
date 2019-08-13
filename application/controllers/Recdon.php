<?php
	class Recdon extends CI_Controller{
		public function allPatients(){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
				$resp=$this->RecdonModel->getAllPatientsDetails();
				json_output(200,$resp);
			}
		}

		public function patientDetails($patient_Id){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
				$resp=$this->RecdonModel->getPatientDetails($patient_Id);
				json_output(200,$resp);
			}
		}

		public function getRequestsfromZone($zoneId){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
				$resp=$this->RequestModel->getRequestForZone($zoneId);
				json_output(200,array('status' => 200, 'message' => 'success','requests' =>requestsOutput($resp)));
			}
		}
	}