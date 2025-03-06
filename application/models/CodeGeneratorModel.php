<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeGeneratorModel extends CI_Model {

    function get_buscode(){
        $q = $this->db->query("SELECT MAX(RIGHT(bus_id,3)) AS kd_max FROM tbl_bus");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }
        return "B".$kd;
    }

    function get_terminalcode(){
        $q = $this->db->query("SELECT MAX(RIGHT(terminal_id,3)) AS kd_max FROM tbl_terminal");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }
        return "TR".$kd;
    }
    
     function get_schedule(){
        $q = $this->db->query("SELECT MAX(RIGHT(schedule_id,3)) AS kd_max FROM tbl_schedule");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "001";
        }
        return "Sched".$kd;
    }

    function get_ordercode(){
        $q = $this->db->query("SELECT MAX(RIGHT(order_code,3)) AS kd_max FROM tbl_transaction");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "001";
        }
        return "ORD".$kd;
    
    }


    function get_admcode(){
        $q = $this->db->query("SELECT MAX(RIGHT(id_admin,3)) AS kd_max FROM tbl_admin");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "ADM".$kd;
    }



    function get_kodtuj(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_tujuan,3)) AS kd_max FROM tbl_tujuan");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }
        return "TJ".$kd;
    }
    
   
    function get_kodpel(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_pelanggan,3)) AS kd_max FROM tbl_pelanggan");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "CA".$kd;
    }
    function get_kodkon(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_konfirmasi,3)) AS kd_max FROM tbl_konfirmasi");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "KF".$kd;
    } 

    function get_kodadm(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_admin,3)) AS kd_max FROM tbl_admin");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "ADM".$kd;
    }

    function get_kodbank(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_bank,3)) AS kd_max FROM tbl_bank");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "BNK".$kd;
    }
}

/* End of file getkod_model.php */
/* Location: ./application/models/getkod_model.php */