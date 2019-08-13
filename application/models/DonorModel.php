<?php

Class DonorModel extends CI_Model
{
    /**

    This is the input to add donor details to donor table.

    {
    "donorId": 1,
    "Donor_Name" : "Rajesh Koothrapalli",
    "Donor_Phone" : "9791234567"

    }

     */
    public function index()
    {
    }



    public function getDonorDetails($donorQuery)
    {
        $query_record = $this->db->select('*')->from('donor')->like("Donor_Name", $donorQuery)->get()->result_array();
        return array('status' => 200, 'message' => 'success', "donor" => donorsOutput($query_record));    }

    public function getAllDonorDetails()
    {
        $query_record = $this->db->select('*')->from('donor')->order_by("Donor_Name", "ASC")->get()->result_array();
        return array('status' => 200, 'message' => 'success', "donor" => donorsOutput($query_record));
    }

    public function addDonorDetails()
    {
        $donorJson = json_decode(file_get_contents('php://input'), true);
//        return array('status' => 200, 'message' => $inventoryDetails);
        $this->beginTransaction();
        $donorDetails = $this->getDonorDetailsFromJson($donorJson);
        if($this->_isDonorExistingInDb($donorDetails))
        {
            return array('status' => 200, 'message' => 'Donor exists in DB already');
        }
        $this->AddNewDonor($donorDetails);
        $donorCompleteDetails = $this->getCompleteDonorDetails($donorDetails);
        return $this->completeTransaction($donorCompleteDetails);


    }

    private function beginTransaction()
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(true); # See Note 01. If you wish can remove as well
    }

    private function completeTransaction($donorCompleteDetails)
    {
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return array('status' => 400, 'message' => 'transaction error');
        } else {
            # Everything is Perfect.
            # Committing data to the database.
            $this->db->trans_commit();
            return array('status' => 200, 'message' => 'New Donor added successfully', "donor"=>donorsOutput($donorCompleteDetails));
        }
    }

    private function getDonorDetailsFromJson($donorJson)
    {
        return array(
            "Donor_Name"=> $donorJson["donorName"],
            "Donor_Phone"=> $donorJson["donorPhone"]
        );
    }

    private function _isDonorExistingInDb(array $donorDetails)
    {
        $result_count = $this->db->get_where('donor', $donorDetails)->num_rows();
        if($result_count != 0)
            return true;
        return false;
    }

    private function AddNewDonor(array $donorDetails)
    {
        $this->db->insert("donor", $donorDetails);
    }

    private function getCompleteDonorDetails(array $donorDetails)
    {

        return $result_count = $this->db->get_where('donor', $donorDetails)->result_array();
    }
}