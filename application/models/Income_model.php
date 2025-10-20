<?php
class Income_model extends CI_Model{
    
    private $dailyRate=0.009;
    private $coinRate;
    private $active_ranks=array();
    
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
    
    public function calculateDailyCompound($principal, $dailyRate, $days) {
        return $principal * pow(1 + $dailyRate, $days);
    }
    
    function compoundedAmountFromDates($amount, $depositDate, $targetDate, $dailyRate = 0.009, $inclusive = true) {
        $start = new DateTime($depositDate);
        $end   = new DateTime($targetDate);

        // Days between deposit and target date
        $interval = $start->diff($end);
        $days = $interval->days;

        if ($start > $end) {
            return 0; // Deposit is in the future, no compounding yet
        }

        if ($inclusive) {
            $days += 1;
        }

        return $amount * pow(1 + $dailyRate, $days);
    }

    function compoundedTotal($deposits, $targetDate, $rate = 0.009, $inclusive = false) {
        $total = 0.0;

        foreach ($deposits as $d) {
            $total += $this->compoundedAmountFromDates($d['amount'], $d['date'], $targetDate, $rate, $inclusive);
        }

        return $total;
    }
    
	public function isLevelUnlocked($level, $selfInvestment, $rank) {
        $rankLevel = [
            'V1' => 1, 'V2' => 2, 'V3' => 3,
            'V4' => 4, 'V5' => 5, 'V6' => 6,
            'V7' => 7, 'V8' => 8, 'V9' => 9,
            'V10' => 10, 'V11' => 11,
        ];

        $userRank = $rankLevel[$rank] ?? 0;
        $status=false;
        if ($level == 1) return true;
        if ($level == 2) $status = true;
        if ($level == 3) $status = true;
        if ($level >= 4 && $level <= 10 && $selfInvestment >= 400 && $userRank >= 1) $status = true; //400
        if ($level >= 11 && $level <= 15 && $selfInvestment >= 700 && $userRank >= 2) $status = true;   //300
        if ($level >= 16 && $level <= 20 && $selfInvestment >= 900 && $userRank >= 3) $status = true;   //200
        if ($level >= 21 && $level <= 30 && $selfInvestment >= 1000 && $userRank >= 3) $status = true;   //100
        
        
        return $status;
    }

    function getLevelPercentage($level) {
        if ($level == 1) return 0.50;
        if ($level == 2) return 0.10; // Simplified assumption: 50–10% range means avg 10%
        if ($level == 3) return 0.05;
        if ($level >= 4 && $level <= 10) return 0.04;
        if ($level >= 11 && $level <= 15) return 0.03;
        if ($level >= 16 && $level <= 20) return 0.02;
        if ($level >= 21 && $level <= 30) return 0.01;
        return 0;
    }

    // 1. Self Investment Return (0.9% daily)
    public function selfInvestment($amount, $days = 365) {
        $dailyRate = 0.009; // 0.9%
        return calculateDailyCompound($amount, $dailyRate, $days);
    }

    // 2. Direct Sponsor Income (5%)
    public function directSponsorIncome($referredInvestment) {
        return $referredInvestment * 0.05;
    }

    // 3. Level Income (array of referrals by level with investments)
    function levelIncome($selfInvestment, $rank, $levelInvestments) {
        $total = 0;

        foreach ($levelInvestments as $level => $amount) {
            if (isLevelUnlocked($level, $selfInvestment, $rank)) {
                $percent = getLevelPercentage($level);
                $total += $amount * $percent;
            }
        }

        return $total;
    }

    function levelIncomeBreakdown($selfInvestment, $rank, $memberData) {
        $output = [];
        $total = 0;

        foreach ($memberData as $level => $data) {
            $members = $data['members'];
            $perMemberInvestment = $data['investment'];
            $levelTotalInvestment = $members * $perMemberInvestment;

            if (isLevelUnlocked($level, $selfInvestment, $rank)) {
                $percent = getLevelPercentage($level);
                $income = $levelTotalInvestment * $percent;

                $output[] = [
                    'level' => $level,
                    'members' => $members,
                    'per_member_investment' => $perMemberInvestment,
                    'percent' => $percent * 100,
                    'total_investment' => $levelTotalInvestment,
                    'income' => $income,
                ];

                $total += $income;
            }
        }

        return ['breakdown' => $output, 'total' => $total];
    }

    // 5. Royalty Income
    public function royaltyIncome($rank) {
        $royalties = [
            'V1' => 0.25,
            'V2' => 1.25,
            'V3' => 2.5,
            'V4' => 5,
            'V5' => 12.5,
            'V6' => 25,
            'V7' => 50,
            'V8' => 500,
            'V9' => 1250,
            'V10' => 2500,
            'V11' => 5000,
        ];
        return $royalties[$rank] ?? 0;
    }

    // 6. Ultra Club Income
    public function ultraClubIncome($gto, $percent = 0.02, $days = 500) {
        return ($gto * $percent) / $days;
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
                $this->db->select('sum(amount) as amount,sum(amount*rate) as total_amount');
                
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
                    'business' => $investments['amount'],
                    'business_usdt' => $investments['total_amount']
                ];
            }
        }

        return $legs;
    }
    
    public function check_ranks($regid){
        $legs = $this->get_leg_business($regid); // each leg has 'business' key
        
        // Sort legs by business descending
        usort($legs, function($a, $b) {
            return $b['business_usdt'] <=> $a['business_usdt'];
        });

        // Get top 2 legs
        $top_legs = array_slice($legs, 0, 2);

        if (count($top_legs) < 2) {
            return false; // Not enough legs
        }
        $where=array();
        $ranks=$this->db->get_where('ranks',$where)->result_array();
        $leg_1=$top_legs[0]['business_usdt']??0;
        $leg_2=$top_legs[1]['business_usdt']??0;
        if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost'){
            //$leg_1+=5000;
            //$leg_2+=5000;
        }
        foreach($ranks as $rank){
            if ($leg_1 >= $rank['leg_1'] && $leg_2 >= $rank['leg_2']) {
                if($this->db->get_where('member_ranks',['regid'=>$regid,'rank_id'=>$rank['id']])->num_rows()==0){
                    $data=array('date'=>date('Y-m-d'),'regid'=>$regid,'rank_id'=>$rank['id'],'rank'=>$rank['rank']);
                    $this->db->insert('member_ranks',$data);
                }
                $leg_1-=$rank['leg_1'];
                $leg_2-=$rank['leg_2'];
                $this->active_ranks[]=$rank['id'];
            }
            else{
                break;
            }
        }

        return false;
    }
    
    public function generateincome($user,$date=NULL){
        $regid=$user['id'];
        if(WORK_ENV=='development'){
            if($regid==3 || $regid==6){
                
            }
            else{
                //return true;
            }
        }
        if(empty($this->coinRate)){
            $this->coinRate=getTokenRate();
        }
        $date=$date===NULL?date('Y-m-d'):$date;
        $member=$this->member->getmemberdetails($regid);
        //print_pre($member);
        
        if($member['status']==1 && $member['activation_date']!='0000-00-00' && $member['activation_date']<=$date){
            $investment=$mininginvestment=0;
            $getinvestments=$this->db->get_where('investments',['regid'=>$regid,'date<='=>$date,'status'=>1]);
            $investmentcount=$getinvestments->num_rows();
            $selfinvestment=0;
            if($investmentcount>0){
                $inv=$getinvestments->unbuffered_row('array');
                $selfinvestment=$inv['amount'];
            }
            
            
            $this->db->select('sum(amount) as amount,sum(rate*amount) as amount_usdt');
            $this->db->order_by('id desc');
            $selfinvestments=$this->db->get_where('investments',['regid'=>$regid,'date<='=>$date,
                                                                 'status'=>1])->unbuffered_row('array');
            
            
            //Direct Income
            $subquery="SELECT member_id from ".TP."income where regid='$regid' and type='direct' and status='1'";
            $where="t1.refid='$regid' and t1.status='1' and t1.activation_date<='$date' and t1.regid not in ($subquery)";
            $this->db->select("t1.*,t2.id as inv_id,t2.amount,t2.old as inv_old");
            $this->db->from("members t1");
            $this->db->join("investments t2","t1.regid=t2.regid");
            $this->db->order_by("t2.added_on");
            $this->db->where($where);
            $getdirects=$this->db->get();
            $directs=$getdirects->result_array();
            $done=array();
            if(!empty($directs)){
                foreach($directs as $direct){
                    $member_id=$direct['regid'];
                    if(in_array($member_id,$done)){ continue; }
                    $ref_investment=$direct['amount'];
                    $inv_id=$direct['inv_id'];
                    $inv_old=$direct['inv_old'];
                    if($inv_old==1 && $ref_investment>0){
                        $done[]=$member_id;
                        $where=array('regid'=>$regid,'member_id'=>$member_id,'type'=>'direct','status'=>1);
                        if($this->db->get_where('income',$where)->num_rows()==0){
                            $data=array('regid'=>$regid,'date'=>$date,'type'=>'direct','member_id'=>$member_id,
                                            'inv_id'=>$inv_id,'rate'=>0.05,
                                            'amount'=>0,'status'=>1,'added_on'=>date('Y-m-d H:i:s'),
                                            'updated_on'=>date('Y-m-d H:i:s'));
                            $this->db->insert('income',$data);
                        }
                        continue;
                    }
                    $where=array('regid'=>$regid,'member_id'=>$member_id,'type'=>'direct','status'=>1);
                    if($this->db->get_where('income',$where)->num_rows()==0){
                        if($ref_investment>0){
                            $done[]=$member_id;
                            $direct_income=$this->directSponsorIncome($ref_investment);
                            if($direct_income>0){
                                $data=array('regid'=>$regid,'date'=>$date,'type'=>'direct','member_id'=>$member_id,
                                            'inv_id'=>$inv_id,'rate'=>0.05,
                                            'amount'=>$direct_income,'status'=>1,'added_on'=>date('Y-m-d H:i:s'),
                                            'updated_on'=>date('Y-m-d H:i:s'));
                                //$this->db->insert('income',$data);
                            }
                        }
                    }
                    
                }
            }
            
            //Level Income
            //$levelinvestments=$this->member->levelwiseinvestment($regid,$date,1);
            //$level_ids=!empty($levelinvestments)?array_column($levelinvestments,'level'):array();
            $levelmembers=$this->member->levelwisemembers($regid,$date,1);
            //print_pre($levelinvestments);
            //print_pre($levelmembers,true);
            $where="t1.regid='$regid'";
            $this->db->select('t1.id,t1.rank');
            $this->db->from('member_ranks t1');
            $this->db->join('ranks t2','t1.rank_id=t2.id');
            $this->db->where($where);
            $this->db->order_by('rank_id desc');
            $this->db->limit(1);
            $query=$this->db->get();
            $rank='';
            if($query->num_rows()==1){
                $rank=$query->unbuffered_row()->rank;
            }
            
            if(!empty($levelmembers)){
                foreach($levelmembers as $levelmember){
                    $member_id=$levelmember['member_id'];
                    $level=$levelmember['level'];
                    $investments=$this->member->getinvestments(['id'=>$member_id],true);
                    //print_pre($investments,true);
                    //$invest_array=!empty($investments)?array_column($investments,'total_amount'):array();
                    //$investment=array_sum($invest_array);
                    
                    if ($this->isLevelUnlocked($level, $selfinvestments['amount_usdt'], $rank)) {
                    }
                    else{
                        continue;
                    }
                    foreach($investments as $investment){
                        if($investment['old']==1){ continue; }
                        $inv_id=$investment['id'];
                        $where=array('regid'=>$regid,'date'=>$date,'type'=>'level','member_id'=>$member_id,
                                            'inv_id'=>$inv_id,'level'=>$level,'status'=>1);
                        if($this->db->get_where('income',$where)->num_rows()==0){
                            $percent = $this->getLevelPercentage($level);
                            $compound = $this->calculateDailyCompound($investment['amount'], $this->dailyRate, 1);
                            $roi = $compound-$investment['amount'];
                            $income = $roi * $percent;
                            if($income>0){
                                $data=array('regid'=>$regid,'date'=>$date,'type'=>'level','member_id'=>$member_id,
                                            'inv_id'=>$inv_id,'level'=>$level,'rate'=>$percent,
                                            'amount'=>$income,'status'=>1,
                                            'added_on'=>date('Y-m-d H:i:s'),'updated_on'=>date('Y-m-d H:i:s'));
                                $this->db->insert('income',$data);
                            }
                        }
                    }
                }
            }
            $this->active_ranks=array();
            $this->check_ranks($regid);
            //print_pre($this->active_ranks);
            $rate=$this->coinRate;
            if($rate>0){
                //Reward Income
                $where="t1.regid='$regid' and t1.rank_id not in (SELECT rank_id from ".TP."income where regid='$regid' and type='reward' and t1.date<'2025-07-25')";
                $this->db->select('t1.rank_id,t1.rank,t2.reward');
                $this->db->from('member_ranks t1');
                $this->db->join('ranks t2','t1.rank_id=t2.id');
                $this->db->where($where);
                $query=$this->db->get();
                $pending=$query->result_array();
                if(!empty($pending)){
                    foreach($pending as $single){
                        if(!in_array($single['rank_id'],$this->active_ranks)){
                            continue;
                        }
                        $totalreward=$reward=$single['reward'];
                        $reward/=100;
                        $amount=$reward/$rate;
                        if($amount>0){
                            $insert=false;
                            $where=$data=array('regid'=>$regid,'date'=>$date,'type'=>'reward',
                                               'rank_id'=>$single['rank_id']);
                            if($this->db->get_where('income',$where)->num_rows()==0){
                                $this->db->select('sum(amount*rate) as amount');
                                $getsaved=$this->db->get_where('income',array('regid'=>$regid,'type'=>'reward',
                                                                                 'rank_id'=>$single['rank_id']));
                                $savedreward=$getsaved->unbuffered_row()->amount;
                                $savedreward=empty($savedreward)?0:round($savedreward);
                                if($savedreward<$totalreward){
                                    $insert=true;
                                }
                            }
                            if($insert){
                                $data=array('regid'=>$regid,'date'=>$date,'type'=>'reward','rank_id'=>$single['rank_id'],
                                            'rate'=>$rate,'amount'=>$amount,'status'=>1,
                                            'added_on'=>date('Y-m-d H:i:s'),'updated_on'=>date('Y-m-d H:i:s'));
                                $this->db->insert('income',$data);
                            }
                        }
                    }
                }
                
                //Royalty Income
                $where="t1.regid='$regid' and t1.id not in (SELECT royalty_id from ".TP."income where regid='$regid' and type='royalty')";
                $this->db->select('t1.id,t1.rank');
                $this->db->from('member_ranks t1');
                $this->db->join('ranks t2','t1.rank_id=t2.id');
                $this->db->where($where);
                $query=$this->db->get();
                $pending=$query->result_array();
                if(!empty($pending)){
                    foreach($pending as $single){
                        $where=$data=array('regid'=>$regid,'type'=>'royalty','royalty_id'=>$single['id']);
                        if($this->db->get_where('income',$where)->num_rows()==0){
                            $royalty=$this->royaltyIncome($single['rank']);
                            $amount=$royalty/$rate;
                            if($amount>0){
                                $data=array('regid'=>$regid,'date'=>$date,'type'=>'royalty','royalty_id'=>$single['id'],
                                            'rate'=>$rate,'amount'=>$amount,'status'=>1,
                                            'added_on'=>date('Y-m-d H:i:s'),'updated_on'=>date('Y-m-d H:i:s'));
                                $this->db->insert('income',$data);
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
