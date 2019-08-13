<?php
	class User extends CI_Controller{
		public function index(){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,true)==true){
				$resp=$this->UserModel->getAllUsers();
				json_output(200,allUsersOutput($resp));
			}
		}

		public function detail($id){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
				$resp=$this->UserModel->getUserById($id);
				json_output(200,userOutput($resp));
			}
		}
		public function userByStatus($id){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,true)==true){
				$resp=$this->UserModel->getUsersByStatus($id);
				json_output(200,$resp);
			}
		}

		public function userByStatusByName($query){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,true)==true){
				$resp=$this->UserModel->userByStatusByName($query);
				json_output(200,$resp);
			}
		}
		
		public function zones(){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(false,false)==true){
				$resp=$this->UserModel->getZones();
				json_output(200,allZoneOutput($resp));
			}
		}

		public function zoneDetail($id){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
				$resp=$this->UserModel->getZoneById($id);
				json_output(200,zoneOutput($resp));
			}
		}

		public function zoneByCountry($country){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(false,false)==true){
				$resp=$this->UserModel->getZonesByCountry($country);
				json_output(200,allZoneOutput($resp));
			}
		}
		
		public function getAllRecdonZones(){
            $method=$_SERVER['REQUEST_METHOD'];
            if($method!='GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            }
            else if($this->UserModel->system_auth(true,false)==true){
                $resp=$this->UserModel->getCompleteZoneDetailsOfCountry("VENEZUELA");
                json_output(200,allZoneOutput($resp));
            }
        }

        public function getAllGetdonZones(){
            $method=$_SERVER['REQUEST_METHOD'];
            if($method!='GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            }
            else if($this->UserModel->system_auth(true,false)==true){
                $resp=$this->UserModel->getCompleteZoneDetailsOfCountry("SPAIN");
                json_output(200,allZoneOutput($resp));
            }
        }

        public function getRecdonZones($query){
            $method=$_SERVER['REQUEST_METHOD'];
            if($method!='GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            }
            else if($this->UserModel->system_auth(true,false)==true){
                $resp=$this->UserModel->getRecdonZonesByQuery($query);
                json_output(200,allZoneOutput($resp));

            }
        }

        public function getGetdonZones($query){
            $method=$_SERVER['REQUEST_METHOD'];
            if($method!='GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            }
            else if($this->UserModel->system_auth(true,false)==true){
                $resp=$this->UserModel->getGetdonZonesByQuery($query);
                json_output(200,allZoneOutput($resp));

            }
        }

		public function login(){
			$method=$_SERVER['REQUEST_METHOD'];
			if ($method!='POST') {
				json_output(400,array('status' => 400, 'message' => 'Bad Request'));
			}
			else if($this->UserModel->system_auth(false,false)==true){
				$jsonArray = json_decode(file_get_contents('php://input'),true);
				$response=$this->UserModel->login($jsonArray);
				json_output(200,$response);
			}
		}

		public function register(){
			$method=$_SERVER['REQUEST_METHOD'];
			if ($method!='POST') {
				json_output(400,array('status' => 400, 'message' => 'Bad Request'));
			}
			else if($this->UserModel->system_auth(false,false)==true){
				$jsonArray = json_decode(file_get_contents('php://input'),true);
				$response=$this->UserModel->registerUser($jsonArray);
				json_output(200,$response);
			}
		}

		public function updateuserstatus(){
			$method=$_SERVER['REQUEST_METHOD'];
			if ($method!='POST') {
				json_output(400,array('status' => 400, 'message' => 'Bad Request'));
			}
			else if($this->UserModel->system_auth(true,true)==true){
				$jsonArray = json_decode(file_get_contents('php://input'),true);
				$response=$this->UserModel->updateuserstatus($jsonArray);
				json_output(200,$response);
			}
		}
		
		public function forgotpass($emailId){
            $method=$_SERVER['REQUEST_METHOD'];
            if ($method!='GET') {
                json_output(400,array('status' => 400, 'message' => 'Bad Request'));
            }
            else if($this->UserModel->system_auth(false,false)==true) {
                $response = $this->UserModel->forgot_pass($emailId);
                json_output(200,$response);
            }
            }
            
        public function verifyOtp()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'POST') {
                json_output(400, array('status' => 400, 'message' => 'Bad Request'));
            } else if ($this->UserModel->system_auth(false, false) == true) {
                $response = $this->UserModel->verifyOtp();
                json_output(200, $response);
            }
        }

        public function setPassword()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'POST') {
                json_output(400, array('status' => 400, 'message' => 'Bad Request'));
            } else if ($this->UserModel->system_auth(false, false) == true) {
                $response = $this->UserModel->setPassword();
                json_output(200, $response);
            }
        }
        
        public function getUsersByZone($zone){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method != 'GET') {
                json_output(400, array('status' => 400, 'message' => 'Bad Request'));
            } else if ($this->UserModel->system_auth(true, false) == true) {
                $response = $this->UserModel->getUsersByZone($zone);
                json_output(200, $response);
            }
        }

	}