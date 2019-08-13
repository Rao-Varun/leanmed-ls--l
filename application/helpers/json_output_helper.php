<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	function json_output($statusHeader,$response){
		$ci =& get_instance();
		$ci->output->set_content_type('application/json');
		$ci->output->set_status_header($statusHeader);
		$ci->output->set_output(json_encode($response));
	}

	function allUsersOutput($users){
		$usersArr=array();
		foreach ($users as $user) {
		    $usersArr[]=userOutput($user);
		}
		return $usersArr;
	}

	function userOutput($user){
		$userArr=array();
		if (array_key_exists("User_Name",$user))
			$userArr['userName']=$user['User_Name'];
		if (array_key_exists("User_Email",$user))
			$userArr['emailId']=$user['User_Email'];
		if (array_key_exists("LeanId_F",$user))
			$userArr['leanIDF']=$user['LeanId_F'];
		if (array_key_exists("IDLeanF_Address",$user))
			$userArr['leanIDAddress']=$user['IDLeanF_Address'];
		if (array_key_exists("Identity_Card",$user))
			$userArr['identity']=$user['Identity_Card'];
		if (array_key_exists("User_Address",$user))
			$userArr['userAddress']=$user['User_Address'];
		if (array_key_exists("User_City",$user))
			$userArr['city']=$user['User_City'];
		if (array_key_exists("User_State",$user))
			$userArr['state']=$user['User_State'];
		if (array_key_exists("User_Country",$user))
			$userArr['country']=$user['User_Country'];
		if (array_key_exists("User_Type",$user))
			$userArr['type']=$user['User_Type'];
		if (array_key_exists("User_Status",$user))
			$userArr['userStatus']=$user['User_Status'];
		if (array_key_exists("Language_Pref",$user))
			$userArr['languagePref']=$user['Language_Pref'];
		if (array_key_exists("Zone_Id",$user))
			$userArr['zone']=zoneOutput($user);
		if (array_key_exists("Phone",$user))
			$userArr['contacts']=$user['Phone'];
		return $userArr;
	}
	function allZoneOutput($zones){
		$zonesArr=array();
		foreach ($zones as $zone) {
		    $zonesArr[]=zoneOutput($zone);
		}
		return $zonesArr;
	}

	function zoneOutput($zoneArr){
		$zone=array();
		if (array_key_exists("Zone_Id",$zoneArr))
			$zone['zoneId']=$zoneArr['Zone_Id'];
		if (array_key_exists("Zone",$zoneArr))
			$zone['zone']=$zoneArr['Zone'];
		if (array_key_exists("Zone_Name",$zoneArr))
			$zone['zoneName']=$zoneArr['Zone_Name'];
		if (array_key_exists("Zone_Email",$zoneArr))
			$zone['zoneEmail']=$zoneArr['Zone_Email'];
		if (array_key_exists("Zone_Country",$zoneArr))
			$zone['zoneCountry']=$zoneArr['Zone_Country'];
		return $zone;
	}
	
	function medicinesOutput($medicinesObjs){
        $medicineArr=array();
        foreach ($medicinesObjs as $medicine) {
            $medicineArr[]=medicineOutput($medicine);
        }
        return $medicineArr;
    }
	
	function medicineOutput($medicineArr){
		$medicine=array();
		if (array_key_exists("Medicine_Id",$medicineArr))
			$medicine['medicineId']=$medicineArr['Medicine_Id'];
		if (array_key_exists("Generic_Name",$medicineArr))
			$medicine['genName']=$medicineArr['Generic_Name'];
		if (array_key_exists("Trade_Name",$medicineArr))
			$medicine['tradeName']=$medicineArr['Trade_Name'];
		if (array_key_exists("Medicine_Type",$medicineArr))
			$medicine['medicineType']=$medicineArr['Medicine_Type'];
		if (array_key_exists("Dosage",$medicineArr))
			$medicine['dosage']=$medicineArr['Dosage'];
		if (array_key_exists("Weight",$medicineArr))
			$medicine['weight']=$medicineArr['Weight'];
		return $medicine;
	}
	function inventoriesOutput($inventoryObjs){
		$inventoryArr=array();
		foreach ($inventoryObjs as $inventory) {
		    $inventoryArr[]=inventoryOutput($inventory);
		}
		return $inventoryArr;
	}
	function inventoryOutput($inventory){
		$inventoryArr=array();
		if (array_key_exists("Inventory_Id",$inventory))
			$inventoryArr['inventoryId']=$inventory['Inventory_Id'];
		if (array_key_exists("Units",$inventory))
			$inventoryArr['units']=$inventory['Units'];
		if (array_key_exists("ID_Box",$inventory))
			$inventoryArr['idBox']=$inventory['ID_Box'];
		if (array_key_exists("Exp_Date",$inventory))
			$inventoryArr['expiryDate']=$inventory['Exp_Date'];
		if (array_key_exists("Zone_Id",$inventory)){
			$zone=zoneOutput($inventory);
			$inventoryArr['zone']=$zone;
		}
		if (array_key_exists("Medicine_Id",$inventory)){
			$medicine=medicineOutput($inventory);
			$inventoryArr['medicine']=$medicine;
		}
		return $inventoryArr;
	}

	function requestsOutput($requestsObjs){
		$requests=array();
		foreach ($requestsObjs as $request) {
		    $requests[]=requestOutput($request);
		}
		return $requests;
	}
	function requestOutput($request){
		$requestArr=array();
		if (array_key_exists("request_Id",$request))
			$requestArr['requestId']=$request['request_Id'];
		if (array_key_exists("inventory",$request))
			$requestArr['inventory']=inventoryOutput($request["inventory"]);
		if (array_key_exists("Quantity",$request))
			$requestArr['quantity']=$request['Quantity'];
		if (array_key_exists("Zone_Id",$request))
			$requestArr['zone']=zoneOutput($request);
		if (array_key_exists("Quantity",$request))
			$requestArr['status']=$request['Status'];
		if (array_key_exists("Comments",$request))
			$requestArr['comments']=$request['Comments'];
		if (array_key_exists("Order_Id",$request))
			$requestArr['orderId']=$request['Order_Id'];
		if (array_key_exists("Created_date",$request))
			$requestArr['createdDate']=$request['Created_date'];
		if (array_key_exists("Modified_Date",$request))
			$requestArr['modifiedDate']=$request['Modified_Date'];
		if (array_key_exists("Created_User",$request) and is_array($request["Created_User"]))
			    $requestArr['createdUser']=userOutput($request["Created_User"]);
	    else
	        $requestArr['createdUser']=null;
		if (array_key_exists("Accepted_User",$request) and is_array($request["Accepted_User"]))
			    $requestArr['acceptedUser']=userOutput($request["Accepted_User"]);
		else
		    $requestArr['acceptedUser']=null;
		return $requestArr;
	}
	
	function donorsOutput($donorObjs)
    {
        $donorArr = array();
        foreach($donorObjs as $donorObj)
        {
            $donorArr[] = donorOutput($donorObj);
        }
        return $donorArr;
    }

    function donorOutput($donorobj)
    {
        $donor = array();
        if(array_key_exists("Donor_ID",$donorobj))
            $donor["donorId"]=$donorobj["Donor_ID"];
        if(array_key_exists("Donor_Name",$donorobj))
            $donor["donorName"]=$donorobj["Donor_Name"];
        if(array_key_exists("Donor_Phone",$donorobj))
            $donor["donorPhone"]=$donorobj["Donor_Phone"];
        return $donor;
    }
    
    
    
    
    function boxsOutput($boxs){
	    $boxsOutputArray = array();
	    foreach ($boxs as $box)
        {
            $boxsOutputArray[] = boxOutput($box);
        }
	    return $boxsOutputArray;
    }

    function boxOutput($box)
    {
        $boxArray = array();
        if(array_key_exists("box_id", $box))
            $boxArray["boxId"] = $box["box_id"];
        if(array_key_exists("box_name", $box))
            $boxArray["boxName"] = $box["box_name"];
        if(array_key_exists("creation_date", $box))
            $boxArray["creationDate"] = $box["creation_date"];
        if(array_key_exists("status", $box))
            $boxArray["status"] = $box["status"];
        if(array_key_exists("delivered_date", $box))
            $boxArray["deliveredDate"] = $box["delivered_date"];
        if(array_key_exists("created_user", $box))
            $boxArray["createdUser"] = userOutput($box["created_user"]);
        if(array_key_exists("dest_zone", $box))
            $boxArray["destinationZone"] = zoneOutput($box["dest_zone"]);
        if(array_key_exists("boxContent", $box))
            $boxArray["boxContent"] = boxContentsOutput($box["boxContent"]);
        return $boxArray;
    }

    function boxContentsOutput($boxContents)
    {
        $boxContentsArray = array();
        foreach($boxContents as $boxContent)
        {
            $boxContentsArray[] = boxContentOutput($boxContent);
        }
        return $boxContentsArray;
    }

    function boxContentOutput($boxContent)
    {
        $boxContentArray = array();
        if(array_key_exists("box_content_id", $boxContent))
            $boxContentArray["boxContentId"] = $boxContent["box_content_id"];
        if(array_key_exists("box_id", $boxContent))
            $boxContentArray["boxId"] = $boxContent["box_id"];
        if(array_key_exists("units", $boxContent))
            $boxContentArray["units"] = $boxContent["units"];
        if(array_key_exists("inventory", $boxContent))
            $boxContentArray["inventory"] = inventoryOutput($boxContent["inventory"]);
        if(array_key_exists("receiving_user", $boxContent) and is_array($boxContent["receiving_user"]))
            $boxContentArray["receivingUser"] = userOutput($boxContent["receiving_user"]);
        if(array_key_exists("request", $boxContent) and is_array($boxContent["request"]))
            $boxContentArray["request"] = requestOutput($boxContent["request"]);
        return $boxContentArray;
    }