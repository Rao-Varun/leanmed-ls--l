<?php

class Shipment extends CI_Controller
{


    public function placeShipmentOrder()
    {
        if($this->UserModel->system_auth(false,false)==true){
            $resp=$this->ShipmentModel->placeShipmentOrder();
            json_output($resp['status'],$resp);
        }

    }

    public function getZoneShipments()
    {
        if($this->UserModel->system_auth(false,false)==true){
            $resp=$this->ShipmentModel->getZonesAllShipments();
            json_output($resp['status'],$resp);
        }

    }

    public function getBoxContent()
    {
        if($this->UserModel->system_auth(false,false)==true){
            $resp=$this->ShipmentModel->getBoxContentDetails();
            json_output($resp['status'],$resp);
        }
    }
}