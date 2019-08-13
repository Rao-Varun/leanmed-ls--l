<?php
class RequestModel extends CI_Model
{
    public function getRequestById($requestId)
    {
        $requestResult = $this->db->select("*")->from("request")->where("request_Id", $requestId)->join("zone", "request.Zone_Id = zone.Zone_Id")->get()->row_array();
        $requestResult["inventory"] = $this->InventoryModel->getMedicineById($requestResult["Inventory_Id"]);
        unset($requestResult["Inventory_Id"]);
        foreach (array("Created_User","Accepted_User") as $user)
            if (!is_null($requestResult[$user]))
                $requestResult[$user] = $this->UserModel->getUserById($requestResult[$user]);
        return $requestResult;
    }

    public function getRequestForZone($zoneId)
    {
        $request = array();
        $result= $this->db->select('*')->from('request')->join('inventory','request.Inventory_Id = inventory.Inventory_Id')->join("zone", "request.Zone_Id = zone.Zone_Id")->where('inventory.Zone_Id =', $zoneId)->get()->result_array();

        foreach($result as $requestResult)
        {
            $requestResult["inventory"] = $this->InventoryModel->getMedicineById($requestResult["Inventory_Id"]);
            unset($requestResult["Inventory_Id"]);
            foreach (array("Created_User", "Accepted_User") as $user)
                if (!is_null($requestResult[$user]))
                    $requestResult[$user] = $this->UserModel->getUserById($requestResult[$user]);
            $request[] = $requestResult;
        }
        return $request;
    }


    public function getAcceptedRequestAcceptedByUser($user)
    {
        $request = array();
        $result= $this->db->select('*')->from('request')->where('Accepted_User =', $user)->join("zone", "request.Zone_Id = zone.Zone_Id")->get()->result_array();
        foreach($result as $requestResult)
        {
            $requestResult["inventory"] = $this->InventoryModel->getMedicineById($requestResult["Inventory_Id"]);
            unset($requestResult["inventory_id"]);
            foreach (array("Created_User", "Accepted_User") as $user)
                if (!is_null($requestResult[$user]))
                    $requestResult[$user] = $this->UserModel->getUserById($requestResult[$user]);
            $request[] = $requestResult;
        }
        return $request;
    }
    
    public function rejectRequest()
    {

        $this->beginTransaction();
        $requestJson = json_decode(file_get_contents('php://input'), true);
        $requestDetail = $this->getRequestDetailsFromJson($requestJson);
        $this->updateRequestRejectionInDb($requestDetail);
        $requestCompleteDetails = $this->getRequestCompleteDetails($requestDetail["request_Id"]);
        return $this->completeTransaction($requestCompleteDetails);

    }

    private function beginTransaction()
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(true); # See Note 01. If you wish can remove as well
    }

    private function completeTransaction($requestCompleteDetails)
    {
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return array("status" => 400, "message" => "fail");
        } else {
            # Everything is Perfect.
            # Committing data to the database.
            $this->db->trans_commit();
            return $requestCompleteDetails;
        }
    }

    private function getRequestDetailsFromJson($requestJson)
    {
        $requestDetails = array(
            "request_Id" => $requestJson["requestId"],
            "Inventory_Id" => $requestJson["inventory"]["inventoryId"],
            "Order_Id" => $requestJson["orderId"],
            "Comments" => null,
            "Zone_Id" => $requestJson["zone"]["zoneId"],
            "Status" => $requestJson["status"],
            "Created_Date" => $requestJson["createdDate"],
            "Created_User" => $requestJson["createdUser"]["emailId"],
            "Accepted_User" => $requestJson["acceptedUser"]["emailId"],
            "Quantity" => $requestJson["quantity"],
        );
        if(array_key_exists("comments", $requestJson))
            $requestDetails["Comments"] = $requestJson["comments"];
        return $requestDetails;
    }

    private function updateRequestRejectionInDb(array $requestDetail)
    {
        $update_val = array();
        if(!is_null($requestDetail["Comments"]))
            $update_val["comments"] = $requestDetail["Comments"];
        $update_val["Accepted_User"] = $requestDetail["Accepted_User"];
        $update_val["Status"] = 6;
        $this->db->set($update_val);
        $this->db->where("request_Id", $requestDetail["request_Id"]);
        $this->db->update("request");

    }

    private function getRequestCompleteDetails($requestId)
    {
        return $this->getRequestById($requestId);
    }


    public function acceptRequest()
    {
        $this->beginTransaction();
        $requestJson = json_decode(file_get_contents('php://input'), true);
        $requestDetails = $this->getRequestDetailsFromJson($requestJson);
        $this->updateRequestRecord($requestDetails);
        $requestCompleteDetails = $this->getRequestCompleteDetails($requestJson["requestId"]);
        return $this->completeTransaction($requestCompleteDetails);

    }

    private function updateRequestRecord($requestDetails)
    {
        
        $updateVal = array("Status" => 2,
                "Accepted_User" => $requestDetails["Accepted_User"]);
        $this->db->set($updateVal);
        $this->db->where("request_Id", $requestDetails["request_Id"]);
        $this->db->update("request");
    }
    
    public function undoRequestAcceptance($request_id)
    {
        $updateVal = array(
            "Accepted_User"=>null,
            "Comments"=>null,
            "status"=>1
        );
        $this->db->set($updateVal);
        $this->db->where("request_Id", $request_id);
        $this->db->update("request");
    }
    
    public function changeRequestStatus(){
        $this->beginTransaction();
        $requestJson = json_decode(file_get_contents('php://input'), true);
        $requestDetails = $this->getRequestDetailsFromJson($requestJson);
        $updateVal = array(
            "status"=> $requestDetails["status"]
        );
        $this->db->set($updateVal);
        $this->db->where("request_Id", $requestDetails["request_Id"]);
        $this->db->update("request");
        $requestCompletreDetails = $this->getRequestCompleteDetails($requestDetails["request_Id"]);
        return $this->completeTransaction($requestCompletreDetails);
    }


}