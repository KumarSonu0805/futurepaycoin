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
  		function countteam($status=false) {
    		$CI = get_instance();
            $user=getuser();
            if($status===true){
                $where="member_id in (SELECT regid from ".TP."members where status='1')";
                $CI->db->where($where);
            }
            $members=$CI->db->get_where('level_members',['regid'=>$user['id']])->num_rows();
            return $members;
		}  
	}

	if(!function_exists('getlegbusiness')) {
  		function getlegbusiness($weaker=false) {
    		$CI = get_instance();
            $user=getuser();
            $legs=$CI->income->get_leg_business($user['id']);
            // Sort legs by business descending
            usort($legs, function($a, $b) {
                return $b['business'] <=> $a['business'];
            });
            
            $top_legs=array();
            if($weaker){
                $top_legs[]=isset($legs[0])?$legs[0]:array();
                if(count($legs)>1){
                    unset($legs[0]);
                    $businesses=array_column($legs,'business');
                    $top_legs[]=array('regid'=>'','business'=>array_sum($businesses));
                }
            }
            else{
                if (count($legs) >= 2) {
                    $top_legs=array_slice($legs,0,2);
                }
            }
            return $top_legs;
        } 
	}

	if(!function_exists('get_direct_business')) {
        function get_direct_business(){
    		$CI = get_instance();
            $user=getuser();
            $regid=$user['id'];
            
            
            $referrals = $CI->db->where('refid', $regid)->get('members')->result_array();
            $downline_ids=empty($referrals)?array():array_column($referrals,'regid');
            if(!empty($downline_ids)){
                $CI->db->select('sum(amount) as amount');

                $CI->db->group_start();
                $regid_chunks = array_chunk($downline_ids,25);
                foreach($regid_chunks as $regid_chunk){
                    $CI->db->or_where_in('regid', $regid_chunk);
                }
                $CI->db->group_end();
                $CI->db->where(['status'=>1,'auto'=>0]);
                $business = $CI->db->get('investments')->unbuffered_row()->amount;
            }
            return $business??0;
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

