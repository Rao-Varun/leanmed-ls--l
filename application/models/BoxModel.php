<?php

class BoxModel extends CI_Model{

    public function addBox(){
        $this->beginTransaction();
        $boxJson = json_decode(file_get_contents('php://input'), true);
        $boxDetails = $this->getBoxDetails($boxJson);
        $this->addBoxDetailsToDB($boxDetails);
        $boxJson["boxId"] = $this->getBoxId();
        $boxContentJson = $this->updateBoxId($boxJson);
        $this->addBoxContentList($boxContentJson);
        $boxCompleteDetails = $this->getBoxCompleteDetails($boxJson["boxId"]);
        return $this->completeTransaction(array($boxCompleteDetails));

    }

    private function beginTransaction()
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(true); # See Note 01. If you wish can remove as well
    }

    private function completeTransaction($medicineCompleteDetails)
    {
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return array("status" => 400, "message" => "Fail");
        } else {
            # Everything is Perfect.
            # Committing data to the database.
            $this->db->trans_commit();
            return array("status" => 200, "message" => "success", "box"=>boxsOutput($medicineCompleteDetails));
        }
    }

    private function getBoxDetails($boxJson)
    {
        $boxDetails = array(
            "box_name"=>$boxJson["boxName"],
            "created_user"=>$boxJson["createdUser"]["emailId"],
            "dest_zone_id"=>$boxJson["destinationZone"]["zoneId"],
            "status"=>$boxJson["status"],
            "creation_date"=>$boxJson["creationDate"]
        );
        return $boxDetails;
    }

    private function addBoxDetailsToDB(array $boxDetails)
    {
        $this->db->insert("box", $boxDetails);
    }

    private function getBoxId()
    {
        $result = $this->db->select_max("box_id")->from("box")->get()->result_array();
        return (int)$result[0]["box_id"];
    }

    private function updateBoxId($boxJson)
    {
        $boxContentJson = array();
        foreach ($boxJson["boxContent"] as $boxContent){
            $boxContent["boxId"] = $boxJson["boxId"];
            $boxContentJson[] = $boxContent;
        }
        return $boxContentJson;
    }

    private function addBoxContentList($boxContentList)
    {
        foreach($boxContentList as $boxContent){
            $boxContentDetails = $this->getBoxContentDetails($boxContent);
            $this->insertBoxContentToDb($boxContentDetails);
            $this->updateInventoryRecord($boxContent);
            $this->updateRequestRecord($boxContent);
        }
    }
    
    

    private function getBoxContentDetails($boxContent)
    {
        $details =  array(
            "inventory_id"=>$boxContent["inventory"]["inventoryId"],
            "box_id"=>$boxContent["boxId"],
            "request_id" => null,
            "receiving_user"=>null,
            "units"=>$boxContent["units"]
        );
        if(array_key_exists("request", $boxContent))
            $details["request_id"] = $boxContent["request"]["requestId"];
        if(array_key_exists("receivingUser", $boxContent))
            $details["receiving_user"]=$boxContent["receivingUser"]["emailId"];
        return $details;
    }

    private function insertBoxContentToDb(array $boxContentDetails)
    {
        $this->db->insert("box_content", $boxContentDetails);

    }

   private function getBoxCompleteDetails($boxId)
    {
        $box = $this->db->select("*")->from("box")->where(array("box_id"=>$boxId))->get()->row_array();
        $box = $this->getBoxDetailsFromDb($box);
        $box["boxContent"] = $this->getBoxContentByBoxId($box["box_id"]);
        return $box;
    }

    private function getBoxDetailsFromDb($box)
    {
        $box["created_user"] = $this->UserModel->getUserById($box["created_user"]);
        $box["dest_zone"] = $this->UserModel->getZoneById($box["dest_zone_id"]);
        return $box;
    }

    private function getBoxContentByBoxId($boxId)
    {
        $boxContentResult = $this->db->select("*")->from("box_content")->where(array("box_id"=>$boxId,"active" => 1))->order_by("box_content_id", "desc")->get()->result_array();
        $boxContentArray = array();
        foreach ($boxContentResult as $boxContent)
        {
            $boxContent["inventory"] = $this->InventoryModel->getMedicineById($boxContent["inventory_id"]);
            if(!is_null($boxContent["request_id"]))
                $boxContent["request"] = $this->RequestModel->getRequestById($boxContent["request_id"]);
            if(!is_null($boxContent["receiving_user"]))
                $boxContent["receiving_user"] = $this->UserModel->getUserById($boxContent["receiving_user"]);
            $boxContentArray[] = $boxContent;
        }
        return $boxContentArray;
    }

    public function getAllBoxesByZone($zone)
    {
        $this->beginTransaction();
        $users = $this->UserModel->getUsersByZone($zone);
        $userID = array();
        foreach ($users as $user)
            $userID[] = $user["emailId"];
        $boxDetails = $this->getBoxAllForZoneFromDb($userID);
        $boxDetails = $this->getBoxContentForBox($boxDetails);
        return $this->completeTransaction($boxDetails);
    }

    private function getBoxAllForZoneFromDb($userID)
    {
    
        $box = $this->db->select("*")->from("box")->order_by("box_id", "desc")->where_in("created_user", $userID)->where("status",1)->get()->result_array();
        return $box;
    }

    private function getBoxContentForBox($boxDetails)
    {
        $box = array();
        foreach ($boxDetails as $boxDetail)
        {
            $boxDetail = $this->getBoxDetailsFromDb($boxDetail);
            $boxDetail["boxContent"] = $this->getBoxContentByBoxId($boxDetail["box_id"]);
            $box[] = $boxDetail;
        }
        return $box;
    }

    
    private function updateInventoryRecord($boxContent)
    {
        $inventoryId = array("inventory_id"=>$boxContent["inventory"]["inventoryId"]);
        $inventoryQuantityResult = $this->db->select("Units")->from("inventory")->where($inventoryId)->get()->result_array();
        $inventoryQuantity = $inventoryQuantityResult[0]["Units"];
        $this->db->set("Units", $inventoryQuantity-$boxContent["units"] );
        $this->db->where($inventoryId);
        $this->db->update("inventory");
    }

    private function updateRequestRecord($boxContent)
    {
        if(!array_key_exists("request", $boxContent))
            return;
        $valArray = array(
            "Accepted_User" => $boxContent["request"]["acceptedUser"]["emailId"],
            "Comments" => $boxContent["request"]["comments"],
            "Status"=>2
            );
        $this->db->set($valArray);
        $this->db->where("request_Id", $boxContent["request"]["requestId"]);
        $this->db->update("request");
    }
    
    public function removeBoxContents()
    {
        $this->beginTransaction();
        $boxContentJson = json_decode(file_get_contents('php://input'), true);
        $box_id = $boxContentJson[0]["boxId"];
        foreach($boxContentJson as $boxContent){
            $boxContentDetail = $this->getBoxContentDetails($boxContent);
            $this->removeBoxContentFromDb($boxContentDetail);
        }
        return $this->completeTransaction(array($this->getBoxCompleteDetails($box_id)));


    }
    
    
    public function removeBoxContent()
    {
        $this->beginTransaction();
        $boxContentJson = json_decode(file_get_contents('php://input'), true);
        $boxContentDetail = $this->getBoxContentDetails($boxContentJson);
        $this->removeBoxContentFromDb($boxContentDetail);
        return $this->completeTransaction($this->getBoxCompleteDetails(array($boxContentDetail["box_id"])));


    }
    
    public function removeBox()
    {
        $this->beginTransaction();
        $boxJson = json_decode(file_get_contents('php://input'), true);
        $boxDetail = $this->getBoxDetails($boxJson);
        $boxCompleteDetails = $this->setBoxStatusToRemove($boxJson["boxId"]);
        foreach ($boxCompleteDetails["boxContent"] as $boxContent)
            $this->removeBoxContentFromDb($boxContent);
        $boxCompleteDetails = $this->getBoxCompleteDetails($boxCompleteDetails["box_id"]);
        return $this->completeTransaction(array($boxCompleteDetails));

    }

    private function removeBoxContentFromDb(array $boxContentDetail)
    {
        $this->deactivateBoxContent($boxContentDetail["box_content_id"]);
        $this->RequestModel->undoRequestAcceptance($boxContentDetail["request_id"]);
        $this->InventoryModel->undoInventoryRecord($boxContentDetail["inventory_id"], $boxContentDetail["units"]);
        return;
    }

    private function getBoxContentCompleteDetails($box_content_id)
    {
        $boxContent = $this->db->select("*")->from("box_content")->order_by("box_content_id", "desc")->where(array("box_content_id"=>$box_content_id))->get()->row_array();
        $boxContent["inventory"] = $this->InventoryModel->getMedicineById($boxContent["inventory_id"]);
        if(!is_null($boxContent["request_id"]))
        {
            $boxContent["request"] = $this->RequestModel->getRequestById($boxContent["request_id"]);
            unset($boxContent["request_id"]);
        }
        if(!is_null($boxContent["receiving_user"]))
            $boxContent["receiving_user"] = $this->UserModel->getUserById($boxContent["receiving_user"]);
        return $boxContent;
    }

    private function setBoxStatusToRemove($box_id)
    {
        $this->db->set("status", 6);
        $this->db->where("box_id", $box_id);
        $this->db->update("box");
        return $this->getBoxCompleteDetails($box_id);
    }

    public function addBoxContent()
    {
        $this->beginTransaction();
        $boxContent = json_decode(file_get_contents('php://input'), true);
        $boxContentDetails = $this->getBoxContentDetails($boxContent);
        $this->insertBoxContentToDb($boxContentDetails);
        $this->updateInventoryRecord($boxContent);
        $this->updateRequestRecord($boxContent);
        $boxCompleteDetails = $this->getBoxCompleteDetails($boxContent["boxId"]);
        return $this->completeTransaction(array($boxCompleteDetails));
    }

    private function deactivateBoxContent($box_content_id)
    {
        $this->db->set("active", 0);
        $this->db->where("box_content_id", $box_content_id);
        $this->db->update("box_content");
    }
    
    public function editBox()
    {
        $this->beginTransaction();
        $boxJson = json_decode(file_get_contents('php://input'), true);
        $boxDetail = $this->getBoxDetails($boxJson);
        $boxDetail["box_id"] = $boxJson["boxId"];
        $boxCompleteDetails = $this->setBoxStatus($boxDetail);
        foreach ($boxJson["boxContent"] as $boxContent)
        {   
            $boxContentDet = $this->getBoxContentDetails($boxContent);
            $boxContentDet["box_content_id"] = $boxContent["boxContentId"];
            $this->removeBoxContentFromDb($boxContentDet);
        }
        $boxCompleteDetails = $this->getBoxCompleteDetails($boxCompleteDetails["box_id"]);
        return $this->completeTransaction(array($boxCompleteDetails));
    }

    private function setBoxStatus($boxDetail)
    {
        $this->db->set("status", $boxDetail["status"]);
        $this->db->where("box_id", $boxDetail["box_id"]);
        $this->db->update("box");
        return $this->getBoxCompleteDetails($boxDetail["box_id"]);
    }
    
    public function getAllActiveBoxesByZone($zone)
    {
        $this->beginTransaction();
        $users = $this->UserModel->getUsersByZone($zone);
        $userID = array();
        foreach ($users as $user)
            $userID[] = $user["emailId"];
        $boxDetails = $this->getActiveBoxAllForZoneFromDb($userID);
        $boxDetails = $this->getBoxContentForBox($boxDetails);
        return $this->completeTransaction($boxDetails);
    }
    
    private function getActiveBoxAllForZoneFromDb($userID)
    {
    
        $box = $this->db->select("*")->from("box")->order_by("box_id", "desc")->where_in("created_user", $userID)->where("status !=",6)->get()->result_array();
        return $box;
    }
}



