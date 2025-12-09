<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('countdownline')) {
  		function countdownline() {
    		$CI = get_instance();
            $user=getuser();
            $members=$CI->member->getmembers($user['id'],true);
            return $members;
		}  
	}

	if(!function_exists('countdirect')) {
  		function countdirect() {
    		$CI = get_instance();
            $user=getuser();
            $members=$CI->member->getdirectmembers($user['id']);
            return !empty($members)?count($members):0;
		}  
	}

	if(!function_exists('getdeposits')) {
  		function getdeposits() {
    		$CI = get_instance();
            $user=getuser();
            $history=$CI->member->getdeposits(['t1.regid'=>$user['id']]);
            $amounts=!empty($history)?array_column($history,'amount'):array();
            return !empty($amounts)?array_sum($amounts):0;
		}  
	}

	if(!function_exists('getincome')) {
  		function getincome() {
    		$CI = get_instance();
            $user=getuser();
            $incomes=array('roiincome'=>0,'matching'=>0,'monthly'=>0,'level'=>0,'reward'=>0,'wheel'=>0,'achievement'=>0);
            $CI->db->select('type,sum(amount) as amount');
            $CI->db->group_by('type');
            $query=$CI->db->get_where('income',['regid'=>$user['id']]);
            $array=$query->result_array();
            $types=!empty($array)?array_column($array,'type'):array();
            
            $index=array_search('roiincome',$types);
            $incomes['roiincome']=$index!==false?$array[$index]['amount']:0;
            
            $index=array_search('matching',$types);
            $incomes['matching']=$index!==false?$array[$index]['amount']:0;
            
            $index=array_search('level',$types);
            $incomes['level']=$index!==false?$array[$index]['amount']:0;
            
            $index=array_search('reward',$types);
            $incomes['reward']=$index!==false?$array[$index]['amount']:0;
            
            $index=array_search('royalty',$types);
            $incomes['royalty']=$index!==false?$array[$index]['amount']:0;
            
            $index=array_search('ultraclub',$types);
            $incomes['ultraclub']=$index!==false?$array[$index]['amount']:0;
            
            $total=array_sum($incomes);
            $incomes['total']=$total;
            
            $CI->db->select('sum(amount) as amount');
            $withdrawal=$CI->db->get_where('withdrawals',['regid'=>$user['id'],'status!='=>2])->unbuffered_row()->amount;
            $incomes['withdrawal']=$withdrawal??0;
            
            $incomes['wallet_balance']=getavlbalance($user);
            return $incomes;
		}  
	}

	if(!function_exists('getadmindata')) {
  		function getadmindata() {
    		$CI = get_instance();
            /*
            Total Deposit 
            Total Withdrawal 
            Top up Activation ID
            Rank Achiever Mannual
            Rank Reward Mannual 
            Spin bonus Select Mannual and Reward 
            Monthly Loyalty income Mannual 
            Maintenance Mode on/off
            Google Authentication (only Admin)
            */
            
            $result=array('deposits'=>0,'withdrawals'=>0,'topup'=>0,'rank_achiever'=>0,'rank_reward'=>0,'spin'=>0,
                          'monthly'=>0);
            
            $CI->db->select_sum('amount');
            $deposits=$CI->db->get_where('investments',['auto'=>0])->unbuffered_row()->amount;
            $result['deposits']=$deposits??0;
            
            $CI->db->select_sum('amount');
            $withdrawals=$CI->db->get_where('withdrawals',['status'=>1])->unbuffered_row()->amount;
            $result['withdrawals']=$withdrawals??0;
            
            //$CI->db->select_sum('amount');
            $topup=$CI->db->get_where('investments',['auto'=>1])->num_rows();//unbuffered_row()->amount;
            $result['topup']=$topup??0;
            
            $rank_achiever=$CI->db->get_where('member_ranks',[])->num_rows();//unbuffered_row()->amount;
            $result['rank_achiever']=$rank_achiever??0;
            
            $CI->db->select_sum('amount');
            $rank_reward=$CI->db->get_where('income',['type'=>'reward','status'=>1])->unbuffered_row()->amount;
            $result['rank_reward']=$rank_reward??0;
            
            return $result;
		}  
	}


