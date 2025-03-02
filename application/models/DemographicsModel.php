<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class DemographicsModel extends CI_Model
{
	private $database;

	public function __construct()
	{
		parent::__construct();

		/* $this->load->config('database');

		$this->database = $this->config->item('db_connection'); */
	}

	public function RegionLists()
	{
		$this->datatables->select('
			hregion.regcode,
			hregion.regname,
			hregion.regabbrev,
			hregion.regstat');
		$this->datatables->from('hregion');
		$this->datatables->add_column(
			'action',
			'<div class="btn-group">
			<a class="btn btn-primary btn-sm  btn-flat" href="Read/$1">&nbsp<i class="glyphicon glyphicon-eye-open"></i></a>
			<button type="button" class="btn btn-primary btn-sm  btn-flat dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">&nbsp<span class="sr-only">Toggle Dropdown</span>
			<span class="caret"></span>
			</button>
			<div class="dropdown-menu">
			<li><a class="dropdown-item btn-sm " href="Update/$1"><i class="fa fa-edit"></i> Update</a></li>
			<li><a class="dropdown-item btn-sm  btn-flat" href="Delete/$1"><i class="fa fa-remove"></i> Delete</a></li>
			</div>
				<a  class="dropdown-item" href=' . site_url('Demographics/ViewProv/$1') . '><i class="fa fa-arrow-right"></i>&nbsp Edit</a>
			</div>',
			'hregion.regcode'
		);

		$this->datatables->add_column('action', '
        
		  <a  href=' . site_url('Demographics/ViewProv/$1') . '  class="btn btn-outline-success btn-block btn-sm" ><i class="fa fa-arrow-right fa-sm"></i> Next Level
		  
		  </a>
        </div>', 'hregion.regcode');

		return $this->datatables->generate();
	}

	public function ProvinceLists($regcode)
	{
		$this->datatables->select('
			hprov.provcode,
			hprov.provname,
			hprov.provabbrev,
			hprov.provstat');
		$this->datatables->from('hprov');
		$this->datatables->join('hregion', 'hregion.regcode=hprov.provreg', 'inner');
		$this->datatables->where('hprov.provreg', $regcode);
		$this->datatables->add_column('action', ' <a  href=' . site_url('Demographics/ViewCity/$1') . '  class="btn btn-outline-success btn-block btn-sm" ><i class="fa fa-arrow-right fa-sm"></i> Next Level</a>
        </div>', 'hprov.provcode');
		return $this->datatables->generate();
	}

	public function CityLists($provcode)
	{
		if ($this->database == 'mssql') {
			$query = "hcity.ctycode,
			(hcity.ctyname + ' ' + hprov.provname + ' ' + hregion.regname) AS ctyname,
			hcity.ctyabbrev,
			hcity.ctydist,
			hcity.ctytype,
			hcity.ctyzipcode,
			hcity.ctystat";
		}

		if ($this->database == 'mysql') {
			$query = "hcity.ctycode,
			CONCAT(hcity.ctyname, ' ', hprov.provname, ' ', hregion.regname) as ctyname,
			hcity.ctyabbrev,
			hcity.ctydist,
			hcity.ctytype,
			hcity.ctyzipcode,
			hcity.ctystat";
		}

		$this->datatables->select($query);
		$this->datatables->from('hcity');
		$this->datatables->join('hregion', 'hregion.regcode=hcity.ctyreg', 'inner');
		$this->datatables->join('hprov', 'hprov.provcode=hcity.ctyprovcod', 'inner');
		$this->datatables->where('hcity.ctyprovcod', $provcode);
		$this->datatables->add_column('action', ' <a  href=' . site_url('Demographics/ViewBrgy/$1') . '  class="btn btn-outline-success btn-block btn-sm" ><i class="fa fa-arrow-right fa-sm"></i> Next Level</a>
        </div>', 'hcity.ctycode');
		return $this->datatables->generate();
	}

	public function BrgyLists($ctycode)
	{
		$this->datatables->select('
	    	hregion.regname,
			hprov.provname,
			hcity.ctycode,
			hcity.ctyname,
			hbrgy.bgynsobc,
			hbrgy.bgyname,
			hbrgy.bgystat');
		$this->datatables->from('hbrgy');
		$this->datatables->join('hregion', 'hregion.regcode=hbrgy.bgyreg', 'inner');
		$this->datatables->join('hprov', 'hprov.provcode=hbrgy.bgyprcode', 'inner');
		$this->datatables->join('hcity', 'hcity.ctycode=hbrgy.bgymuncod', 'inner');
		$this->datatables->where('hbrgy.bgymuncod', $ctycode);

		return $this->datatables->generate();
	}
	//Region	
	public function insert($data)
	{
		$this->db->insert('hregion', $data);
	}

	public function update($data, $id)
	{
		$this->db->where('regcode', $id);
		$this->db->update('hregion', $data);
	}

	public function delete($id)
	{
		$this->db->where('regcode', $id);
		$this->db->delete('hregion');
	}

	public function get_by_id($id)
	{
		$this->db->from('hregion');
		$this->db->where('regcode', $id);
		return $this->db->get()->row();
	}

	//Province
	public function insertprov($data)
	{
		$this->db->insert('hprov', $data);
	}

	public function updateprov($data, $provcode)
	{
		$this->db->where('provcode', $provcode);
		$this->db->update('hprov', $data);
	}

	public function deleteprov($provcode)
	{
		$this->db->where('provcode', $provcode);
		$this->db->delete('hprov');
	}

	public function get_by_idprov($provcode)
	{
		$this->db->from('hprov');
		$this->db->where('provcode', $provcode);
		return $this->db->get()->row();
	}

	//City
	public function insertcty($data)
	{
		$this->db->insert('hcity', $data);
	}

	public function updatecty($data, $id)
	{
		$this->db->where('ctycode', $id);
		$this->db->update('hcity', $data);
	}

	public function deletecty($id)
	{
		$this->db->where('ctycode', $id);
		$this->db->delete('hregion');
	}

	public function get_by_idcty($id)
	{
		$this->db->from('hcity');
		$this->db->where('ctycode', $id);
		return $this->db->get()->row();
	}

	//Barangay
	public function insertbrgy($data)
	{
		$this->db->insert('hbrgy', $data);
	}

	public function updatebrgy($data, $id)
	{
		$this->db->where('bgycode', $id);
		$this->db->update('hbrgy', $data);
	}

	public function deletebrgy($id)
	{
		$this->db->where('bgycode', $id);
		$this->db->delete('hbrgy');
	}

	public function get_by_idbrgy($id)
	{
		$this->db->from('hbrgy');
		$this->db->where('bgycode', $id);
		return $this->db->get()->row();
	}
	//alvin
	function CityList()
	{
	

		$query = "ctycode, CONCAT(hcity.ctyname, ' (', hprov.provname, ')') as ctyname";

		$this->db->select($query)
			->join('hprov', 'hprov.provcode=hcity.ctyprovcod', 'inner')
			->where('ctystat', 'A');

		return $this->db->get('hcity')->result_array();
	}

	function CityListFilter($search)
	{
		$this->db->select("ctycode,CONCAT(hcity.ctyname, ' (', hprov.provname, ')') as ctyname");
		$this->db->join('hprov', 'hprov.provcode=hcity.ctyprovcod', 'inner');
		$this->db->or_like('ctyname', $search);
		$this->db->where('ctystat', 'A');

		return $this->db->get('hcity')->result_array();
	}

	function RegionList($search, $regcode)
	{
		$this->db->select('regcode,regname')
			->where('regcode', $regcode);
		return $this->db->get('hregion')->result_array();
	}

	function RegionGetbyId($regcode)
	{
		$this->db->select('regcode,regname');
		$this->db->where('regcode', $regcode);
		return $this->db->get('hregion')->row();
	}

	function ProvGetbyId($provcode)
	{
		$this->db->select('provcode,provname');
		$this->db->where('provcode', $provcode);
		return $this->db->get('hprov')->row();
	}

	function BrgyListAll($ctyCode)
	{
		$this->db->select('bgycode,bgyname');
		$this->db->where('bgymuncod', $ctyCode);
		return $this->db->get('hbrgy')->result_array();
	}

	function zipcode($ctycode)
	{
		$this->db->select('ctyzipcode');
		$this->db->where('ctycode', $ctycode);
		return $this->db->get('hcity')->result_array();
	}

	function DistListAll($ctycode)
	{
		$this->db->select('zipcode,distname');
		$this->db->where('ctycode', $ctycode);
		return $this->db->get('hdistrictzip')->result_array();
	}

	function DistGetbyId($zipCode)
	{
		$this->db->select('zipcode,distname');
		$this->db->where('ctycode', $zipCode);
		//$this->db->where('zipstat', 'A');
		return $this->db->get('hdistrictzip')->row();
	}

	function DistGetbyCity($zipCode)
	{
		$this->db->select('*');
		$this->db->where('ctycode', $zipCode);
		//$this->db->where('zipstat', 'A');
		return $this->db->get('hdistrictzip')->row();
	}



	function BrgyListFilter($ctyCode, $search)
	{
		$this->db->select('bgycode,bgyname');
		$this->db->or_like('bgyname', $search);
		$this->db->where('bgymuncod', $ctyCode);
		$this->db->limit(20);
		return $this->db->get('hbrgy')->result_array();
	}

	function CityGetbyId($citycode)
	{
		$this->db->select('ctycode,ctyname');
		$this->db->where('ctycode', $citycode);
		//$this->db->where('ctystat', 'A');
		return $this->db->get('hcity')->row();
	}


	function  BrgyGetbyId($brgyCode)
	{
		$this->db->select('bgycode,bgyname');
		$this->db->where('bgycode', $brgyCode);
		//$this->db->where('bgystat', 'A');
		return $this->db->get('hbrgy')->row();
	}

	function DistListAll2($ctycode, $search = "")
	{
		$searchDist = "";
		if ($search != "") {
			$searchDist = "and distname like '" . $search . "%' ";
		}
		$query = $this->db->query("select zipcode, distname from hdistrictzip where ctycode = '" . $ctycode . "' " . $searchDist);

		return $query->result_array();
	}

	function BrgyListFilter2($distzip, $search = "")
	{
		$this->db->select('bgycode,bgyname');
		$this->db->distinct();
		$this->db->from('hcity');
		$this->db->join('hdistrictzip', 'hdistrictzip.zipcode =  hcity.ctyzipcode', 'inner');
		$this->db->join('hbrgy', 'hbrgy.bgymuncod = hcity.ctycode', 'inner');
		if ($search != "") {
			$this->db->or_like('bgyname', $search);
		}
		$this->db->where('hcity.ctyzipcode', $distzip);
		$this->db->limit(20);
		return $this->db->get()->result_array();
	}

	public function getProvinceByName($provname)
	{
		$this->db->select('provcode,provname');
		$this->db->where('provname', $provname);
		return $this->db->get('hprov')->row();
	}


	public function getCityByName($ctyname)
	{
		$this->db->select('ctycode,ctyname');
		$this->db->where('ctyname', $ctyname);
		return $this->db->get('hcity')->row();
	}

	public function getBrgyByName($bgyname)
	{
		$this->db->select('bgycode,bgyname');
		$this->db->where('bgyname', $bgyname);
		return $this->db->get('hbrgy')->row();
	}


	/* function RegionListFilter($search) 
	{	
		$this->db->select('regcode,regname');
		$this->db->or_like('regname',$search);
		return $this->db->get('hregion')->result_array();
    }
	
	
	
	
	function ProvListAll($regcode) 
	{	
		$this->db->select('provcode,provname');
		$this->db->where('provreg',$regcode);
		return $this->db->get('hprov')->result_array();
    }

	function ProvListFilter($regcode,$search) 
	{	
		$this->db->select('provcode,provname');
		$this->db->or_like('provname',$search);
		$this->db->where('provreg',$regcode);
		return $this->db->get('hprov')->result_array();
    }
	
	function ProvGetbyId($provcode) 
	{	
		$this->db->select('provcode,provname');
		$this->db->where('provcode',$provcode);
		return $this->db->get('hprov')->row();
    }
	
	function CityListAll($provcode) 
	{	
		$this->db->select('ctycode,ctyname');
		$this->db->where('ctyprovcod',$provcode);
		$this->db->where('ctystat','A');
		return $this->db->get('hcity')->result_array();
    }
	
	function CityListFilter($provcode,$search) 
	{	
		$this->db->select('ctycode,ctyname');
		$this->db->or_like('ctyname',$search);
		$this->db->where('ctyprovcod',$provcode);
		$this->db->where('ctystat','A');
		return $this->db->get('hcity')->result_array();
    }
	
	function CityGetbyId($citycode) 
	{	
		$this->db->select('ctycode,ctyname');
		$this->db->where('ctycode',$citycode);
		$this->db->where('ctystat','A');
		return $this->db->get('hcity')->row();
    }
	
	function DistListAll($ctycode) 
	{	
		$this->db->select('zipcode,distname');
		$this->db->where('ctycode',$ctycode);
		return $this->db->get('hdistrictzip')->result_array();
    }
	
	function DistListFilter($ctycode,$search) 
	{	
		$this->db->select('zipcode,distname');
		$this->db->or_like('ctyname',$search);
		$this->db->where('ctycode',$ctycode);
		$this->db->where('zipstat','A');
		return $this->db->get('hdistrictzip')->result_array();
    }
	

	function BrgyListAll($ctyCode) 
	{	
		$this->db->select('bgycode,bgyname');
		$this->db->where('bgymuncod',$ctyCode);
		return $this->db->get('hbrgy')->result_array();
    }
		
	function BrgyListFilter($ctyCode,$search) 
	{	
		$this->db->select('bgycode,bgyname');
		$this->db->or_like('bgyname',$search);
		$this->db->where('bgymuncod',$ctyCode);
	    $this->db->limit(20);
		return $this->db->get('hbrgy')->result_array();
    }
	
	function  BrgyGetbyId($brgyCode) 
	{	
		$this->db->select('bgycode,bgyname');
		$this->db->where('bgycode',$brgyCode);
		$this->db->where('bgystat','A');
		return $this->db->get('hbrgy')->row();
    } */

	public function __destruct()
	{
		if ($this->db) {
			$this->db->close();
		}
	}
}
