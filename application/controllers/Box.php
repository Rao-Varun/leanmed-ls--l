<?php

class Box extends CI_Controller{

    public function addBox(){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->addBox();
            json_output($resp['status'],$resp);
        }
    }
    
    public function addBoxContent(){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->addBoxContent();
            json_output($resp['status'],$resp);
        }
    }

    public function getAllBoxesByZone($zone){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->getAllBoxesByZone($zone);
            json_output($resp['status'],$resp);
        }
    }
    
    public function getAllActiveBoxesByZone($zone){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->getAllActiveBoxesByZone($zone);
            json_output($resp['status'],$resp);
        }
    }
    
    public function removeBox(){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->removeBox();
            json_output(200,$resp);
        }
    }
    
    public function removeBoxContent(){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->removeBoxContent();
            json_output($resp['status'],$resp);
        }
    }
    
    public function removeBoxContents(){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->removeBoxContents();
            json_output($resp['status'],$resp);
        }
    }
    
    public function editBox(){
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp=$this->BoxModel->editBox();
            json_output(200,$resp);
        }
    }
    
}