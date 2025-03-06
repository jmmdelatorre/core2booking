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


}

