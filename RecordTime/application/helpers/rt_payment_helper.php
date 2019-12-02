<?php

defined('BASEPATH') or exit('No direct script access allowed');

function getUserCredits($user_id){
    $ci=& get_instance();
    $ci->load->database();
    
    $credits = 0;
    $debits = 0;
    
    $ci->db->select("type, amount");
    $ci->db->from('tbl_payments');
    $ci->db->where("tbl_payments.user_id", $user_id);
    $query = $ci->db->get();
    foreach($query->result() as $row){
        if($row->type == 'credit'){
            $credits += $row->amount;
        }
        
        if($row->type == 'debit'){
            $debits += $row->amount;
        }
    }
    
    $creditsTotal = $credits - $debits;
    return $creditsTotal;
}