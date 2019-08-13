<?php

 /*
        JsonFormat sent from the app to add new item to inventory.
                {
                        "donationDate" : "2018-08-03",
                        "idBox" : "2.15",
                        "units" : 30,
                        "expiryDate" : ""
                        "zone":{
                                "zoneId":"",
                                "zone":"",
                                "zoneName": "",
                                "zoneEmail": "",
                                "zoneCountry": ""
                               },
                        "user":{
                                    "userName": "",
                                    "emailId": "",
                                    "contacts": "",
                                    "leanIDF": "",
                                    "leanIDAddress": "",
                                    "identity": "",
                                    "userAddress": "",
                                    "city": "",
                                    "state": "",
                                    "country": "",
                                    "password":"",
                                    "type": 1,
                                    "zone": ,
                                    "userStatus": 1,
                                    "languagePref": 1,
                                    "token": "",
                                    "zone": {
                                                "zoneId":"",
                                                "zone":"",
                                                "zoneName": "",
                                                "zoneEmail": "",
                                                "zoneCountry": ""
                                            }
                                 },
                        "medicine" : {
                                        "medicineId": 1,
                                        "genName" : "new_medicine",
                                        "tradeName" : "NEWMED",
                                        "medicineType" : "capsule",
                                        "dosage" : 50,
                                        "weight": ""
                                     },
                        "donor" : {
                                    "donorId": 1,
                                    "Donor_Name" : "Rajesh Koothrapalli",
                                    "Donor_Phone" : "9791234567"

                                   },
                        },

                    }



 */


class InventoryModel extends CI_Model{
	public function getMedicines($query){
		$query_record = $this->db->select('*')->from('inventory')->join('zone', 'inventory.Zone_Id = zone.Zone_Id')->join('medicine', 'inventory.Medicine_Id = medicine.Medicine_Id')->or_like(array('Generic_Name'=>$query,'Trade_Name'=>$query))->get()->result_array();
		return array('status' => 200, 'message' => 'success','inventory' => inventoriesOutput($query_record));			
	}
	
	public function getAllMedicines(){
	    $result = $this->db->select("*")->from('inventory')->join('zone', 'inventory.Zone_Id = zone.Zone_Id')->join('medicine', 'inventory.Medicine_Id = medicine.Medicine_Id')->get()->result_array();
        return array('status' => 200, 'message' => 'success','inventory' => inventoriesOutput($result));

    }
    
    public function getMedicineById($id){
        $query_record = $this->db->select('*')->from('inventory')->where(array("Inventory_Id"=>$id))->join('zone', 'inventory.Zone_Id = zone.Zone_Id')->join('medicine', 'inventory.Medicine_Id = medicine.Medicine_Id')->get()->row_array();
//        return array('status' => 200, 'message' => 'success','inventory' => inventoriesOutput($query_record));
        return $query_record;
    }

    public function getGetDonMedicine($query)
    {
        $zone = $this->input->get("Zone_Id");
        $query_record = $this->db->select('*')->from('inventory')->join('zone', "inventory.Zone_Id = zone.Zone_Id and zone.Zone_Id =  '$zone'")->join('medicine', 'inventory.Medicine_Id = medicine.Medicine_Id')->or_like(array('Generic_Name'=>$query,'Trade_Name'=>$query))->get()->result_array();
        return array('status' => 200, 'message' => 'success','inventory' => inventoriesOutput($query_record));
    }

    public function updateGetDonInventory()
    {
        $inventoryDetails = json_decode(file_get_contents('php://input'), true);
        $this->beginTransaction();
        $this->AddNewInventory($inventoryDetails);
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
            return array('status' => 200, 'message' => 'New item added successfully');
        }
    }

    private function AddNewInventory($inventory)
    {
        $inventoryDetails = $this->getInventoryDetails($inventory);
        $this->db->insert("inventory", $inventoryDetails);
    }

    private function getInventoryDetails($inventory)
    {
        return array(
            "Zone_Id"=>$inventory["zone"]["zoneId"],
            "User_email"=>$inventory["user"]["emailId"],
            "Medicine_Id"=>$inventory["medicine"]["medicineId"],
            "Donor_ID"=>$inventory["donor"]["donorId"],
            "Donation_Date"=>$inventory["donationDate"],
            "ID_Box"=>$inventory["idBox"],
            "Units"=>$inventory["units"],
            "Exp_Date"=>$inventory["expiryDate"]
        );
    }
    
    public function undoInventoryRecord($inventoryId, $units)
    {

        $inventory = $this->getMedicineById($inventoryId);
        $this->db->set("Units", $inventory["Units"] + $units);
        $this->db->where("Inventory_Id", $inventory["Inventory_Id"]);
        $this->db->update("inventory");


    }


}
