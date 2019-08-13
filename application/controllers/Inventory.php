<?php
	class Inventory extends CI_Controller{
		public function index($query){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
				$resp=$this->InventoryModel->getMedicines($query);
				json_output($resp['status'],$resp);
			}
		}

		public function getdonIndex($query)
        {
            $method=$_SERVER['REQUEST_METHOD'];
            if($method!='GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            }
            else if($this->UserModel->system_auth(false,false)==true){
                $resp=$this->InventoryModel->getGetDonMedicine($query);
                json_output($resp['status'],$resp);
            }
        }

        public function addItemToInventory()
        {
            $method=$_SERVER['REQUEST_METHOD'];
            if($method!='POST'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            }
            else if($this->UserModel->system_auth(true,false)==true){
                $resp=$this->InventoryModel->updateGetDonInventory();
                json_output($resp['status'],$resp);
            }

        }

		public function all(){
			$method=$_SERVER['REQUEST_METHOD'];
			if($method!='GET'){
				json_output(400,array('status' => 400,'message' => 'Bad request.'));
			}
			else if($this->UserModel->system_auth(true,false)==true){
			    $resp = $this->InventoryModel->getAllMedicines();
				return json_output($resp["status"],$resp);
			}
		}
	}