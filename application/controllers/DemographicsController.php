<?php defined('BASEPATH') OR exit('No direct script access allowed');


class DemographicsController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('demographics');
	}

	public function region_list() {
		$this->load->model('DemographicsModel');
		header('Content-Type: application/json');
		echo $this->DemographicsModel->RegionLists();	
	}
	
	public function province_list($regcode)	{
		$this->load->model('DemographicsModel');
		header('Content-Type: application/json');
		echo $this->DemographicsModel->ProvinceLists($regcode);
	}

	public function city_list($provcode) {
		$this->load->model('DemographicsModel');
		header('Content-Type: application/json');
		echo $this->DemographicsModel->CityLists($provcode);
	}

	public function brgy_list($ctycode)	{
		$this->load->model('DemographicsModel');
		header('Content-Type: application/json');
		echo $this->DemographicsModel->BrgyLists($ctycode);
	}
	
	public function setRegion($regId)
	{
		setRegion($regId);
	}
	public function setProvince($provId)
	{
		setProv($provId);
	}
	public function setCity($cityId)
	{
		setCity($cityId);
	}
	public function setDist($zipCode)
	{
		setDist($zipCode);
	}
	
	public function setZip($ctyCode)
	{
		$row=$this->DemographicsModel->zipcode($ctyCode);
		echo json_encode($row);
	}
	
	public function setBrgy($brgyCode)
	{
		setBrgy($brgyCode);
	}
	
	
	public function searchCity()
	{
		searchCity();
	}
	
	
	public function searchRegion()
	{
		searchRegion();
	}
	
	
	public function searchProvince($regcode)
	{
		searchProvince($regcode);
	}
	
	public function searchDistrict($citycode)
	{
		searchDistrict($citycode);
	}

	public function searchBarangay($citycode)
	{
		searchBarangay($citycode);
	}

	public function searchDistrict2($citycode)
	{
		searchDistrict2($citycode);
	}

	public function searchBarangay2($citycode,$distzip)
	{
		searchBarangay2($distzip);
	}
	
}