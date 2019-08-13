<?php

class ShipmentModel extends CI_Model
{

    /*

           'box':{

                    "Shipment_Date": "",
                    "Status": "",
                    "Sent_User": "",
                    "Zone_Id": "",
                    "ID_Box": "",
                    "content": {
                                    "Inventory_Id_1":Units,
                                    "Inventory_Id_1":Units
                                }
    }


     */


    public function placeShipmentOrder()
    {
        $shipmentDetails = json_decode(file_get_contents('php://input'), true);
        $boxDetails = $shipmentDetails["box"];
//          return array('status' => 200, 'message' => $shipmentDetails);
        $this->beginTransaction();
        $boxDetails["Box_Id"] = $this->updateBoxTable($boxDetails);
        $this->updateBoxMedicineTable($boxDetails);
        return $this->completeTransaction();


    }

    private function updateBoxTable($shipmentDetails)
    {
        $boxDetails = $this->getBoxTableDetails($shipmentDetails);
        $this->db->insert("box", $boxDetails);
        return $this->getBoxId();

    }

    private function getBoxTableDetails($shipmentDetails)
    {
        return array(
            "Shipment_Date" => $shipmentDetails["Shipment_Date"],
            "Status" => $shipmentDetails["Status"],
            "Sent_User" => $shipmentDetails["Sent_User"],
            "Zone_Id" => $shipmentDetails["Zone_Id"]
        );
    }


    private function getBoxId()
    {
        $this->db->select_max('Box_Id');
        $result = $this->db->get('box')->row();
        return $result->Box_Id;
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

    private function updateBoxMedicineTable($shipmentDetails)
    {
        foreach (array_keys($shipmentDetails["content"]) as $inventoryId) {
            $boxMedicineDetails = $this->getBoxMedicineTableDetails($shipmentDetails, $inventoryId);
            $this->db->insert("box_content", $boxMedicineDetails);
        }

    }

    private function getBoxMedicineTableDetails($shipmentDetails, $inventoryId)
    {
        return array(
            "ID_Box" => $shipmentDetails["ID_Box"],
            "Units" => $shipmentDetails["content"][$inventoryId],
            "Inventory_Id" => intval($inventoryId),
            "Box_Id" => $shipmentDetails["Box_Id"]
        );
    }

    public function getZonesAllShipments()
    {
        /*
            {
                "shipment" : {
                                "Zone_Id":"VAL"
                            }
            }

         */

        $shipmentDetails = json_decode(file_get_contents('php://input'), true);
        $this->beginTransaction();
        $boxDetails = $this->getAllOrderDetails($shipmentDetails);
        $resp = $this->completeTransaction();
        if ($resp["status"] == 200)
            $resp["shipment_details"] = $boxDetails;
        return $resp;
    }

    private function getAllOrderDetails($shipmentDetails)
    {
        $result = $this->db->get_where("box", array("Zone_Id" => $shipmentDetails["shipment"]["Zone_Id"]));
        $boxDetails = $this->getCompleteBoxDetails($result);
        return $boxDetails;
    }

    private function getCompleteBoxDetails($result)
    {
        $boxDetails = array();
        foreach ($result->result() as $row) {
            $box = $row->Box_Id;
            $boxDetails[$box] = array();
            $boxDetails[$box]["Shipment_Date"] = $row->Shipment_Date;
            $boxDetails[$box]["Status"] = $row->Status;
            $boxDetails[$box]["Sent_User"] = $row->Sent_User;
            $boxDetails[$box]["Zone_Id"] = $row->Zone_Id;
            $boxDetails[$box]["Medicine_count"] = $this->getMedicineCount($box);
        }
        return $boxDetails;
    }

    private function getMedicineCount($box)
    {
        $this->db->select("*");
        $this->db->from("box");
        $this->db->where("Box_Id = $box");
        return $this->db->get()->num_rows();
    }


    public function getBoxContentDetails()
    {

        /*
            {
                "shipment" : {
                                "Zone_Id":"VAL"
                            }
            }

         */

        $shipmentDetails = json_decode(file_get_contents('php://input'), true);
        $this->beginTransaction();
        $medicineDetails = $this->getMedicineDetails($shipmentDetails);

        $resp = $this->completeTransaction();
        if ($resp["status"] == 200)
            $resp["medicine_details"] = $medicineDetails;
        return $resp;
    }

    private function getMedicineDetails($shipmentDetails)
    {
        $medicineDetails = array();
        $result = $this->db->get_where("box_content", array("Box_Id" => $shipmentDetails["shipment"]["Box_Id"]));
        foreach ($result->result() as $row) {
            $med = $row->Box_Content_Id;
            $medicineDetails[$med] = array();
            $medicineDetails[$med]["ID_Box"] = $row->ID_Box;
            $medicineDetails[$med]["Units"] = intval($row->Units);
            $medicineDetails[$med]["Inventory_Id"] = intval($row->Inventory_Id);
            $medicineDetails[$med]["Box_Id"] = intval($row->Box_Id);
        }
        return $medicineDetails;
    }


}