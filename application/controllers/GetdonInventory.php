<?php

class GetdonInventory extends CI_Controller
{


    public function addNewItemToInventory()
    {

        if ($this->UserModel->system_auth(false, false) == true) {
            $resp = $this->GetDonInventoryModel->updateGetDonInventory();
            json_output($resp['status'], $resp);
        }
    }
}