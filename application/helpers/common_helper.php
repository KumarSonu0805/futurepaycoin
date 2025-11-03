<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('print_pre')) {
  		function print_pre($data,$die=false) {
            echo '<pre>'; print_r($data); echo "</pre>";
            if($die){ die; }
		}  
	}

	if(!function_exists('getuser')) {
  		function getuser() {
    		$CI = get_instance();
            $getuser=$CI->account->getuser(array("md5(id)"=>$CI->session->user));
            if($getuser['status']==true){
                return $getuser['user'];
            }
            else{
                redirect('home/');
            }
		}  
	}

	if(!function_exists('countdirects')) {
  		function countdirects() {
    		$CI = get_instance();
            $user=getuser();
            $members=$CI->db->get_where('members',['refid'=>$user['id']])->num_rows();
            return $members;
		}  
	}

	if(!function_exists('countteam')) {
  		function countteam() {
    		$CI = get_instance();
            $user=getuser();
            $members=$CI->db->get_where('level_members',['regid'=>$user['id']])->num_rows();
            return $members;
		}  
	}

	if(!function_exists('getlegbusiness')) {
  		function getlegbusiness() {
    		$CI = get_instance();
            $user=getuser();
            $legs=$CI->income->get_leg_business($user['id']);
            // Sort legs by business descending
            usort($legs, function($a, $b) {
                return $b['business'] <=> $a['business'];
            });
            
            $top_legs=array();
            if (count($legs) >= 2) {
                $top_legs=array_slice($legs,0,2);
            }
            return $top_legs;
        } 
	}
	if(!function_exists('getavlbalance')){
        function getavlbalance($user){
            $CI = get_instance();
            $regid=$user['id'];
            $incomes=$CI->income->getallincome($user);
            $member=$CI->member->getmemberdetails($user['id']);
            $avl_balance=0;
            if(!empty($incomes)){
                $amounts=array_column($incomes,'amount');
                $avl_balance=array_sum($amounts);
            }
            $withdrawals=$CI->member->getwithdrawalrequest(['t1.regid'=>$user['id'],'t1.status!='=>2]);
            if(!empty($withdrawals)){
                $amounts=array_column($withdrawals,'amount');
                $avl_balance-=array_sum($amounts);
            }
            return $avl_balance;
            
        }
    }

	if(!function_exists('getrank')) {
  		function getrank() {
    		$CI = get_instance();
            $user=getuser();
            $regid=$user['id'];
            $where="t1.regid='$regid'";
            $CI->db->select('t1.id,t1.rank');
            $CI->db->from('member_ranks t1');
            $CI->db->join('ranks t2','t1.rank_id=t2.id');
            $CI->db->where($where);
            $CI->db->order_by('rank_id desc');
            $CI->db->limit(1);
            $query=$CI->db->get();
            $rank='';
            if($query->num_rows()==1){
                $rank=$query->unbuffered_row()->rank;
                $rank=' ('.$rank.')';
            }
            return $rank;
		}  
	}

