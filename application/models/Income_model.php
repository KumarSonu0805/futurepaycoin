<?php
class Income_model extends CI_Model{
    
    private $targetRate=12;
    private $coinRate;
    private $active_ranks=array();
    
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
    
    public function getdailyincome($investment, $targetPercent=12, $earnedSoFar=0.0, $remainingPayouts = 1) {
        $daysInMonth = date('t');
        $totalPayouts = $daysInMonth * 2; // 2 payouts per day
        $minPercent = $targetPercent*0.01; // minimum per payout
        $maxPercent = $targetPercent*0.025; // maximum per payout
        
        $remainingPercent = $targetPercent - $earnedSoFar;

        // If this is the last payout, force it to match exactly
        if ($remainingPayouts == 1) {
            $percent = $remainingPercent;
        } else {
            // Calculate minimum and maximum remaining possible
            $minPossible = $minPercent * ($remainingPayouts - 1);
            $maxPossible = $maxPercent * ($remainingPayouts - 1);

            // Adjust dynamic min and max for current payout
            $dynamicMin = max($minPercent, $remainingPercent - $maxPossible);
            $dynamicMax = min($maxPercent, $remainingPercent - $minPossible);

            // Convert to integer (scaled by 100 to handle decimals)
            $minInt = (int) round($dynamicMin * 100);
            $maxInt = (int) round($dynamicMax * 100);

            // Ensure valid range
            if ($maxInt < $minInt) {
                $maxInt = $minInt;
            }

            // Random percentage for this payout
            $percent = mt_rand($minInt, $maxInt) / 100;
        }

        // Prevent total from exceeding 12%
        if ($earnedSoFar + $percent > $targetPercent) {
            $percent = $targetPercent - $earnedSoFar;
        }

        // Update cumulative earnings
        $earnedSoFar += $percent;

        // Calculate monetary payout
        $amount = ($investment * $percent) / 100;

        $payout = [
            'percent' => round($percent, 4),
            'earned_so_far_percent' => round($earnedSoFar, 4),
            'amount' => round($amount, 4)
        ];

        return $payout;
    }
    
    function getLevelPercentage($level,$directbusiness,$selfbusiness,$booster=false) {
        if ($level == 1) return 0.2;
        if ($level == 2 && $directbusiness>=100){ 
            return $booster?0.20:0.10;
        }
        if ($level >= 3 && $level <= 5 && $directbusiness>=300 && $selfbusiness>=100) return 0.05;
        if ($level >= 6 && $level <= 10 && $directbusiness>=500 && $selfbusiness>=200) return 0.02;
        if ($level >= 11 && $level <= 15 && $directbusiness>=1500 && $selfbusiness>=300) return 0.01;
        if ($level >= 16 && $level <= 20 && $directbusiness>=3000 && $selfbusiness>=500) return 0.005;
        return 0;
    }

    public function get_leg_business($regid){
        $legs = [];

        // Step 1: Get direct referrals
        $referrals = $this->db->where('refid', $regid)->get('members')->result_array();

        foreach ($referrals as $ref) {
            $downline_ids = $this->member->getmembers($ref['regid']);
            $downline_ids=!empty($downline_ids)?array_column($downline_ids,'regid'):array();
            $downline_ids[] = $ref['regid']; // include leg head's business too
            if (!empty($downline_ids)) {
                $this->db->select('sum(amount) as amount');
                
				$this->db->group_start();
				$regid_chunks = array_chunk($downline_ids,25);
				foreach($regid_chunks as $regid_chunk){
					$this->db->or_where_in('regid', $regid_chunk);
				}
				$this->db->group_end();
				$this->db->where(['status'=>1]);
                $investments = $this->db->get('investments')->unbuffered_row('array');
                $legs[] = [
                    'regid' => $ref['regid'],
                    'business' => $investments['amount']
                ];
            }
        }

        return $legs;
    }
    
    public function generateincome($user,$date=NULL){
        $regid=$user['id'];
        
        $date=$date===NULL?date('Y-m-d'):$date;
        $member=$this->member->getmemberdetails($regid);
        //print_pre($member,true);
        
        if($member['status']==1 && $member['activation_date']!='0000-00-00' && $member['activation_date']<=$date){
            $booster=$member['booster']==1?TRUE:FALSE;
            $where=['regid'=>$regid,'date<='=>$date,'status'=>1];
            $investments=$this->db->get_where('investments',$where)->result_array();
            $inv_amounts=!empty($investments)?array_column($investments,'amount'):array();
            $selfbusiness=array_sum($inv_amounts);
            
            if(!empty($investments)){
                foreach($investments as $investment){
                    $inv_id=$investment['id'];
                    $this->db->select_sum('amount');
                    $getearned=$this->db->get_where("income",array('regid'=>$regid,'inv_id'=>$inv_id,
                                                                    'type'=>'roiincome','status'=>1));
                    $earned=$getearned->unbuffered_row()->amount;
                    $total=$investment['amount']*$this->targetRate/100;
                    $earnedPercent=($earned*100)/$total;
                    $hr=date('d')*2;
                    $where=array('regid'=>$regid,'date'=>$date,'inv_id'=>$inv_id,'type'=>'roiincome',
                                     'status'=>1);
                    if($this->db->get_where('income',$where)->num_rows()==0){
                        $hr-=1;
                    }
                    $daily=$this->getdailyincome($investment['amount'], $this->targetRate, $earnedPercent,$hr);
                    if($daily['amount']>0){
                        $where=array('regid'=>$regid,'date'=>$date,'inv_id'=>$inv_id,'hr'=>$hr,'type'=>'roiincome',
                                     'status'=>1);
                        if($this->db->get_where('income',$where)->num_rows()==0){
                            $data=array('regid'=>$regid,'date'=>$date,'inv_id'=>$inv_id,'hr'=>$hr,'type'=>'roiincome',
                                        'rate'=>$daily['percent'],'amount'=>$daily['amount'],'status'=>1,
                                        'added_on'=>date('Y-m-d H:i:s'),'updated_on'=>date('Y-m-d H:i:s'));
                            $this->db->insert('income',$data);
                        }
                    }

                }
            }
            
            $where="date<='$date' and status='1' and regid in (Select regid from ".TP."members where refid='$regid')";
            $direct_investments=$this->db->get_where('investments',$where)->result_array();
            $direct_inv_amounts=!empty($direct_investments)?array_column($direct_investments,'amount'):array();
            $direct_business=array_sum($direct_inv_amounts);
            //Level Income
            //$levelinvestments=$this->member->levelwiseinvestment($regid,$date,1);
            //$level_ids=!empty($levelinvestments)?array_column($levelinvestments,'level'):array();
            $levelmembers=$this->member->levelwisemembers($regid,$date,1);
            //print_pre($levelmembers);
            if(!empty($levelmembers)){
                foreach($levelmembers as $levelmember){
                    $member_id=$levelmember['member_id'];
                    $level=$levelmember['level'];
                    $rate=$this->getLevelPercentage($level,$direct_business,$selfbusiness,$booster);
                    if($rate>0){
                        $this->db->select_sum('amount');
                        $getroiincome=$this->db->get_where('income',['regid'=>$member_id,'date'=>$date,
                                                                     'type'=>'roiincome']);
                        $roiincome=$getroiincome->unbuffered_row()->amount;
                        $roiincome=empty($roiincome)?0:$roiincome;
                        if($roiincome>0){
                            $amount=$roiincome*$rate;
                            $where=array('regid'=>$regid,'date'=>$date,'member_id'=>$member_id,'level'=>$level,
                                         'type'=>'level','status'=>1);
                            $data=array('regid'=>$regid,'date'=>$date,'member_id'=>$member_id,'level'=>$level,
                                        'type'=>'level','rate'=>$rate,'amount'=>$amount,'status'=>1,
                                            'added_on'=>date('Y-m-d H:i:s'),'updated_on'=>date('Y-m-d H:i:s'));
                            if($this->db->get_where('income',$where)->num_rows()==0){
                                $this->db->insert('income',$data);
                            }
                            else{
                                unset($data['added_on']);
                                $this->db->update('income',$data,$where);
                            }
                        }
                    }
                }
            }
            
        }
    }
    
    
    public function generateallincome($date=NULL){
        $this->db->order_by('id desc');
        $users=$this->db->get_where('users',['id>'=>1])->result_array();
        foreach($users as $user){
            $this->generateincome($user,$date);
        }
    }
    
    
    
    public function getallincome($user){
        $regid=$user['id'];
        $where=array("t1.regid"=>$regid,"t1.status"=>1);
        $this->db->select('t1.*,t2.username');
        $this->db->from("income t1");
        $this->db->join("users t2",'t1.member_id=t2.id','left');
        $this->db->where($where);
        $this->db->order_by("t1.date");
        $income=$this->db->get()->result_array();
        return $income;
    }
    
    public function getincome($where){
        $this->db->select("t1.*,t2.username,t2.name as member_name,ifnull(t5.rank,t3.rank) as rank");
        $this->db->from("income t1");
        $this->db->join("users t2",'t1.member_id=t2.id','left');
        $this->db->join("ranks t3",'t1.rank_id=t3.id','left');
        $this->db->join("member_ranks t4",'t1.royalty_id=t4.id','left');
        $this->db->join("ranks t5",'t4.rank_id=t5.id','left');
        $this->db->where($where);
        $this->db->where(['t1.amount>'=>0]);
        $income=$this->db->get()->result_array();
        return $income;
    }
    
    public function getmemberwallet(){
        $columns="t2.*,t3.username as ref,t3.name as refname";
        $this->db->select($columns);
        $this->db->from("members t1");
        $this->db->join("users t2","t1.regid=t2.id");
        $this->db->join("users t3","t1.refid=t3.id");
        $query=$this->db->get();
        $array=$query->result_array();
        if(!empty($array)){
            foreach($array as $key=>$value){
                $income=$withdrawal=0;
                $incomes=$this->income->getallincome($value);
                if(!empty($incomes)){
                    $amounts=array_column($incomes,'amount');
                    $income=array_sum($amounts);
                }
                $array[$key]['income']=$income;
                $withdrawals=$this->member->getwithdrawalrequest(['t1.regid'=>$value['id'],'t1.status!='=>2]);
                if(!empty($withdrawals)){
                    $amounts=array_column($withdrawals,'amount');
                    $withdrawal=array_sum($amounts);
                }
                $array[$key]['withdrawal']=$withdrawal;
                $array[$key]['balance']=getavlbalance($value);
            }
        }
        return $array;
    }
}
