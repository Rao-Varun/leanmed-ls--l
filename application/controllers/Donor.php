<?php

Class Donor extends CI_Controller
{

    public function index()
    {
    }

    public function getDonorDetails($donorQuery)
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->DonorModel->getDonorDetails($donorQuery);
            json_output($resp['status'],$resp);
        }
    }

    public function getAllDonorDetails()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->DonorModel->getAllDonorDetails();
            json_output($resp['status'],$resp);
        }
    }
    
    public function addDonorDetails()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->DonorModel->addDonorDetails();
            json_output($resp['status'],$resp);
        }

    }



}
