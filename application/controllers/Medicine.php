<?php

class Medicine extends CI_Controller
{

    public function index()
    {
        
    }

    public function getMedicine($medicineQuery)
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true)
        {
            $resp = $this->MedicineModel->getMedicineForQuery($medicineQuery);
            json_output($resp['status'],$resp);
        }
    }
    
    public function getAllMedicine()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true)
        {
            $resp = $this->MedicineModel->getAllMedicine();
            json_output($resp['status'],$resp);
        }
    }
    
    public function addNewMedicine()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true)
        {
            $resp = $this->MedicineModel->addNewMedicine();
            json_output($resp['status'],$resp);
        }
    }
}
