<?php


class MedicineModel extends CI_Model
{

    public function getMedicineForQuery($medicineQuery)
    {
        $query_record = $this->db->select('*')->from('medicine')->or_like(array('Generic_Name' => $medicineQuery, 'Trade_Name' => $medicineQuery))->get()->result_array();
        return array('status' => 200, 'message' => 'success','medicine' => medicinesOutput($query_record));
    }
    
    public function getAllMedicine()
    {
        $query_record = $this->db->select('*')->from('medicine')->order_by("Trade_Name", "ASC")->get()->result_array();
        return array('status' => 200, 'message' => 'success', 'medicine' => medicinesOutput($query_record));
    }
    
    public function addNewMedicine()
    {
        $this->beginTransaction();
        $medicineJson = json_decode(file_get_contents('php://input'), true);
        $medicineDetails = $this->getMedicineDetails($medicineJson);
        if($this->_isMedicineExistAlready($medicineDetails))
            return array("status"=>200, "message"=>"Medicine exist in DB already");
        $this->db->insert("medicine", $medicineDetails);
        $medicineCompleteDetails = $this->getCompleteMedicineDetailsFromDb($medicineDetails);
        return $this->completeTransaction($medicineCompleteDetails);

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
            return array("status"=>400, "message" => "Medicine not added to DB");
        } else {
            # Everything is Perfect.
            # Committing data to the database.
            $this->db->trans_commit();
            return array("status"=>200, "message" =>"Medicine added successfully", "medicine"=>medicinesOutput($medicineCompleteDetails));
        }
    }

    private function getMedicineDetails($medicineJson)
    {
        return array(
            "Generic_Name" => $medicineJson["genName"],
            "Trade_Name" => $medicineJson["tradeName"],
            "Medicine_Type" => $medicineJson["medicineType"],
            "Dosage" => $medicineJson["dosage"],
            "Weight" => $medicineJson["weight"]
        );
    }

    private function _isMedicineExistAlready($medicineDetails)
    {
        $result_count = $this->db->get_where('medicine', $medicineDetails)->num_rows();
        if($result_count != 0)
            return true;
        return false;
    }
    
    private function getCompleteMedicineDetailsFromDb($medicineDetails)
    {
        $medicineCompleteDetails = $this->db->get_where('medicine', $medicineDetails)->result_array();
        return $medicineCompleteDetails;
    }
}