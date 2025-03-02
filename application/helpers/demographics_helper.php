<?php
if(!function_exists('setRegion'))
{	
	function setRegion($regId)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		$row=$CI->DemographicsModel->RegionGetbyId($regId);
		echo json_encode($row);
	}	 
}
if(!function_exists('setProv'))
{	
	function setProv($provId)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		$row=$CI->DemographicsModel->ProvGetbyId($provId);
		echo json_encode($row);
	}	 
}

if(!function_exists('setCity'))
{	
	function setCity($cityId)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		$row=$CI->DemographicsModel->CityGetbyId($cityId);
		echo json_encode($row);
	}	 
}

if(!function_exists('setDist'))
{	
	function setDist($zipCode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		$row=$CI->DemographicsModel->DistGetbyId($zipCode);
		echo json_encode($row);
	}	 
}

if(!function_exists('setBrgy'))
{	
	function setBrgy($brgyCode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		$row=$CI->DemographicsModel->BrgyGetbyId($brgyCode);
		echo json_encode($row);
	}	 
}

if(!function_exists('searchCity'))
{	
	function searchCity()
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchCity']))
		{
			$row=$CI->DemographicsModel->CityList();
			echo json_encode($row);
		}else
		{
		$search = $_POST['searchCity'];
		$row=$CI->DemographicsModel->CityListFilter($search) ;
		echo json_encode($row);		
		}
	}	 
} 

if(!function_exists('searchRegion'))
{	
	function searchRegion()
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchRegion']))
		{
			$row=$CI->DemographicsModel->RegionListAll();
			echo json_encode($row);	
		}else 
		{
			$search = $_POST['searchRegion'];
			$row=$CI->DemographicsModel->RegionListFilter($search);
			echo json_encode($row);
		}
	}	 
}

if(!function_exists('searchProvince'))
{	
	function searchProvince($regcode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchProvince']))
		{
			$row=$CI->DemographicsModel->ProvListAll($regcode);
			echo json_encode($row);
		}
		else
		{
		$search = $_POST['searchProvince'];
		$row=$CI->DemographicsModel->ProvListFilter($regcode,$search) ;
		echo json_encode($row);		
		}
	}	 
}


if(!function_exists('searchDistrict'))
{	
	function searchDistrict($citycode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchDistrict']))
		{
			$row=$CI->DemographicsModel->DistListAll($citycode);
			echo json_encode($row);
		}else
		{
			$search = $_POST['searchDistrict'];
			$row=$CI->DemographicsModel->DistListFilter($citycode,$search) ;
			echo json_encode($row);		
		}
	}	 
}

if(!function_exists('searchDistrict2'))
{	
	function searchDistrict2($citycode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchDist']))
		{
			$row=$CI->DemographicsModel->DistListAll2($citycode);
			echo json_encode($row);
		}else
		{
			$search = $_POST['searchDist'];
			$row=$CI->DemographicsModel->DistListAll2($citycode,$search) ;
			echo json_encode($row);		
		}
	}	 
}

if(!function_exists('searchBarangay'))
{	
	function searchBarangay($citycode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchBarangay']))
		{
			$row=$CI->DemographicsModel->BrgyListAll($citycode);
			echo json_encode($row);
		}
		else
		{
			$search = $_POST['searchBarangay'];
			$row=$CI->DemographicsModel->BrgyListFilter($citycode,$search) ;
			echo json_encode($row);		
		}
	}	 
}

if(!function_exists('searchPlaceofConsultation'))
{	
	function searchPlaceofConsultation($hfhudcode)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchPlaceofConsultation']))
		{
			$row=$CI->DemographicsModel->PconsulListAll($hfhudcode);
			echo json_encode($row);
		}
		else
		{
			$search = $_POST['searchPlaceofConsultation'];
			$row=$CI->DemographicsModel->PconsulListFilter($hfhudcode,$search) ;
			echo json_encode($row);		
		}
	}	 
}

if(!function_exists('searchBarangay2'))
{	
	function searchBarangay2($distzip)
	{
		$CI = &get_instance();
		$CI->load->model('DemographicsModel');
		if(!isset($_POST['searchBarangay']))
		{
			$row=$CI->DemographicsModel->BrgyListFilter2($distzip);
			echo json_encode($row);
		}
		else
		{
			$search = $_POST['searchBarangay'];
			$row=$CI->DemographicsModel->BrgyListFilter2($distzip,$search) ;
			echo json_encode($row);		
		}
	}	 
}
?>