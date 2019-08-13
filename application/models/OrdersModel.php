<?php

class OrdersModel extends CI_Model
{
    public function placeUserOrders()
    {
        $orderDetails = json_decode(file_get_contents('php://input'), true);
        $this->beginTransaction();
        $patientID = $this->addPatientDetailsToPatients($orderDetails["patient"]);
        $orderDetails["patientId"] = $patientID;
        $orderDetails["orderId"]=$this->addOrderDetailToOrder($orderDetails);
        $this->updateRequestTables($orderDetails);
        return $this->completeTransaction($orderDetails["orderId"]);


    }

    private function addPatientDetailsToPatients($patientDetails)
    {
        if ($this->isPatientDetailExistInDB($patientDetails)) {
            return $patientDetails["patientId"];
        } else {
            $newPatientDetails = $this->getInsertDetails($patientDetails);
            $this->db->insert("patient", $newPatientDetails);
            return $this->getPatientID();
        }
    }

    private function addOrderDetailToOrder($orderDetails)
    {
        $newOrderDetails = $this->getOrderDetails($orderDetails);
        $this->db->insert("orders", $newOrderDetails);
        return $this->getOrderId();
        //$orderDetails["prescriptionImage"] = $this->addImageToServer($orderDetails);
        //$this->updateImageLocation($orderDetails);

    }

    private function isPatientDetailExistInDB($patientDetails)
    {
        if ($patientDetails["patientId"] != null) {
            $patId = $patientDetails['patientId'];
            $this->db->select("*");
            $this->db->from("patient");
            $this->db->where("Patient_Id = $patId");
            if ($this->db->get()->num_rows() == 1)
                return true;
            else
                return false;

        } else {
            return false;
        }
    }

    private function getInsertDetails($array)
    {
        $newArray = array("Patient_FName"=>$array["firstName"],
                       "Patient_LName"=>$array["lastName"],
                       "Patient_DOB"=>$array["dob"],
                       "Patient_Contact"=>$array["contact"],
                       "Patient_Email"=>$array["email"],
                       "Patient_Address"=>$array["address"],
                       "Patient_State"=>$array["state"],
                       "Patient_City"=>$array["city"],
                       "Patient_Country"=>$array["country"]);
        return $newArray;
    }

    private function getOrderDetails($orderDetails)
    {
        $array = array(
            "Receiving_Date" => null,
            "Prescription_Image" => "/",
            "Order_Status" => 1,
            "Confirmation_Image" => null,
            "Zone_Id" => $orderDetails["createdUser"]["zone"]["zoneId"],
            "User_Email" => $orderDetails["createdUser"]["emailId"],
            "Patient_Id" => $orderDetails["patientId"]
        );
        return $array;
    }

    private function updateRequestTables($orderDetails)
    {
        foreach ($orderDetails["requests"] as $request) {
            $insertDetails = $this->getRequestDetails($orderDetails, $request);
            $this->db->insert("request", $insertDetails);
//            $this->updateInventoryTable($orderDetails["orderDetails"][$inventoryID], $inventoryID);
        }

    }

    private function updateInventoryTable($orderDetails, $inventoryID)
    {
        $recordQuantity = $this->getCurrentQuantityFromInventory($inventoryID);
        $requiredQuantity = $orderDetails[$inventoryID]["Quantity"];
        $newQuantityVal = array("Quantity" => $recordQuantity - $requiredQuantity);
        $this->db->where('Inventory_Id', $inventoryID);
        $this->db->update("inventory", $newQuantityVal);

    }

    private function getRequestDetails($orderDetails, $request)
    {
        $array = array(
            "Order_Id" => $orderDetails["orderId"],
            "Inventory_Id" =>$request["inventory"]["inventoryId"],
            "Comments" => null,
            "Zone_Id" => $orderDetails["createdUser"]["zone"]["zoneId"],
            "Status" => 1,
            "Created_User" => $orderDetails["createdUser"]["emailId"],
            "Accepted_User" => null,
            "Quantity" => $request["quantity"]
        );
        return $array;
    }

    private function getCurrentQuantityFromInventory($inventoryID)
    {
        $this->db->select('Quantity');
        $this->db->from('inventory');
        $this->db->where('Inventory_Id', $inventoryID);
        return $this->db->get()->row()->Quantity;
    }

    private function getPatientID()
    {
        $this->db->select_max('Patient_Id');
        $result = $this->db->get('patient')->row();
        return $result->Patient_Id;
    }

    private function getOrderId()
    {
        $this->db->select_max('Order_Id');
        $result = $this->db->get('orders')->row();
        return $result->Order_Id;
    }

    private function addImageToServer($orderDetails)
    {
        $orderID = $orderDetails["Order_Id"];
//        $patientID = $orderDetails["Patient_Id"];
        $fileName = "~/LeanMed/prescription_img/".$orderID;
        file_put_contents($fileName, base64_decode($orderDetails["Prescription_Image"]));
        return $fileName;
    }

    private function updateImageLocation($orderDetails)
    {
        $new_data = array("Prescription_Image"=> $orderDetails["Prescription_Image"]);
        $this->db->where('Order_Id', $orderDetails["Order_Id"]);
        $this->db->update("orders", $new_data);
        return;
    }

    private function beginTransaction()
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(true); # See Note 01. If you wish can remove as well
    }

    private function completeTransaction($orderId)
    {
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return array('status' => 400, 'message' => 'transaction error');
        }
        else {
            # Everything is Perfect.
            # Committing data to the database.
            $this->db->trans_commit();
            return array('status' => 200, 'message' => 'success', "orderId"=>$orderId);
        }
    }


}