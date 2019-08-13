<?php
Class Request extends CI_Controller
{
    public function getAcceptedRequestAcceptedByUser($user)
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp = $this->RequestModel->getAcceptedRequestAcceptedByUser($user);
            return json_output(200,array('status' => 200, 'message' => 'success','requests' => requestsOutput($resp)));
        }
    }
    
    public function getRequestById($id)
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp = $this->RequestModel->getRequestById($id);
            return json_output(200,array('status' => 200, 'message' => 'success','requests' => requestsOutput(array($resp))));
        }
    }
    
    public function rejectRequest()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp = $this->RequestModel->rejectRequest();
            return json_output(200,array('status' => 200, 'message' => 'success','requests' => requestsOutput(array($resp))));
        }
    }

    public function acceptRequest()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp = $this->RequestModel->acceptRequest();
            return json_output(200,array('status' => 200, 'message' => 'success','requests' => requestsOutput(array($resp))));
        }
    }

    public function changeRequestStatus()
    {
        $method=$_SERVER['REQUEST_METHOD'];
        if($method!='POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        }
        else if($this->UserModel->system_auth(true,false)==true){
            $resp = $this->RequestModel->changeRequestStatus();
            return json_output(200,array('status' => 200, 'message' => 'success','requests' => requestsOutput(array($resp))));
        }
    }
}