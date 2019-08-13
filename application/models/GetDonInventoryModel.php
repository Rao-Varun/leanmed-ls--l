<?php

class GetDonInventoryModel extends CI_Model
{
    /*
            "inventory": {
                           "Zone_Id":"LC5",
                            "User_email" : "lean.caracas.eb@gmail.com",
                            "Medicine_Id" : 1,
                            "Donor_ID" : "11",
                            "Donation_Date" : "2018-08-03",
                            "ID_Box" : "2.15",
                            "Units" : 30,
                            "Exp_Date" : ""
                            },

             "medicine" : {
                            "Generic_Name" : "new_medicine",
                            "Trade_Name" : "NEWMED",
                            "Medicine_Type" : "capsule",
                            "Dosage" : 50
                            },
                "donor" : {
                            "Donor_Name" : "Rajesh Koothrapalli",
                            "Donor_Phone" : "9791234567"

                            }



    }



     */



    public function updateGetDonInventory()
    {
        $inventoryDetails = json_decode(file_get_contents('php://input'), true);
//        return array('status' => 200, 'message' => $inventoryDetails);
        $this->beginTransaction();
        if (array_key_exists("medicine", $inventoryDetails))
            $inventoryDetails["inventory"]["Medicine_Id"] = $this->addNewMedicineToMedicineTable($inventoryDetails["medicine"]);
        if (array_key_exists("donor", $inventoryDetails))
            $inventoryDetails["inventory"]["Donor_ID"] = $this->addNewDonorToDonorTable($inventoryDetails["donor"]);
        $this->AddNewInventory($inventoryDetails["inventory"]);
        return $this->completeTransaction();

    }

    private function beginTransaction()
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(true); # See Note 01. If you wish can remove as well
    }

    private function completeTransaction()
    {
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return array('status' => 400, 'message' => 'transaction error');
        } else {
            # Everything is Perfect.
            # Committing data to the database.
            $this->db->trans_commit();
            return array('status' => 200, 'message' => 'success');
        }
    }


    private function addNewMedicineToMedicineTable($medicine)
    {
        $medicineDetails = $this->getMedicineDetails($medicine);
        $this->db->insert("medicine", $medicineDetails);
        return $this->getMedicineId($medicine);

    }


    private function getMedicineDetails($medicine)
    {
        return array(
            "Generic_Name" => $medicine["Generic_Name"],
            "Trade_Name" => $medicine["Trade_Name"],
            "Medicine_Type" => $medicine["Medicine_Type"],
            "Dosage" => $medicine["Dosage"],
        );
    }


    private function getMedicineId()
    {
        $this->db->select_max('Medicine_Id');
        $result = $this->db->get('medicine')->row();
        return $result->Medicine_Id;
    }

    private function addNewDonorToDonorTable($donor)
    {
        $donorDetails = $this->getDonorDetails($donor);
        $this->db->insert("donor", $donorDetails);
        return $this->getDonorId();

    }

    private function getDonorDetails($donor)
    {
        return array(
            "Donor_Name" => $donor["Donor_Name"],
            "Donor_Phone" => $donor["Donor_Phone"]
        );
    }

    private function getDonorId()
    {
        $this->db->select_max('Donor_Id');
        $result = $this->db->get('donor')->row();
        return $result->Donor_Id;
    }

    private function AddNewInventory($inventory)
    {
        $inventoryDetails = $this->getInventoryDetails($inventory);
        $this->db->insert("inventory", $inventoryDetails);
    }

    private function getInventoryDetails($inventory)
    {
        return array(
            "Zone_Id"=>$inventory["Zone_Id"],
            "User_email"=>$inventory["User_email"],
            "Medicine_Id"=>$inventory["Medicine_Id"],
            "Donor_ID"=>$inventory["Donor_ID"],
            "Donation_Date"=>$inventory["Donation_Date"],
            "ID_Box"=>$inventory["ID_Box"],
            "Units"=>$inventory["Units"],
            "Exp_Date"=>$inventory["Exp_Date"]
        );
    }


}
