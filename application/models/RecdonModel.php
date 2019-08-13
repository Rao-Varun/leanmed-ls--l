<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class RecdonModel extends CI_Model{
		public function getAllPatientsDetails(){
			$this->db->select('pt.Patient_FName,pt.Patient_LName,pt.Patient_Id,od.Order_Status,req.Created_User,req.Created_date,req.Quantity');
			$this->db->from('patient AS pt');
			$this->db->join('orders AS od', 'od.Patient_Id = pt.Patient_Id');
			$this->db->join('request AS req', 'req.Order_Id = od.Order_Id');
			$this->db->limit(20);
			return $this->db->get()->result_array();
		}

		public function getPatientDetails($patient_Id){
			$this->db->select('pt.Patient_FName,pt.Patient_LName,pt.Patient_Email,pt.Patient_Contact,pt.Patient_DOB,med.Generic_Name,med.Medicine_Type,med.Dosage');
			$this->db->where('pt.Patient_Id' ,$patient_Id)->from('patient AS pt');
			$this->db->join('orders AS od', 'od.Patient_Id = pt.Patient_Id');
			$this->db->join('request AS req', 'req.Order_Id = od.Order_Id');
			$this->db->join('medicine AS med', 'med.Medicine_id = req.Medicine_id');
			return $this->db->get()->result_array();
		}

		public function getRequestForZone($zoneId){
			$query= $this->db->select('*')->from('request')->join('inventory','request.Inventory_Id = inventory.Inventory_Id')->join('medicine','inventory.Medicine_Id=medicine.Medicine_Id')->where('inventory.Zone_Id =', $zoneId)->get()->result_array();
			 return array('status' => 200, 'message' => 'success','requests' => requestsOutput($query));
		}
	}