<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        checklogin();
        $data=['title'=>'Home'];
        if($this->session->role=='admin' && $this->session->user==md5(1)){
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
        }
        else{
            $data['user']=getuser();
            $data['member']=$this->member->getmemberdetails($data['user']['id']);
        }  
        $this->template->load('pages','home',$data);
    }
     public function index2(){
        checklogin();
        $data=['title'=>'Home'];
        if($this->session->role=='admin' && $this->session->user==md5(1)){
        }
        else{
            $data['user']=getuser();
            $data['member']=$this->member->getmemberdetails($data['user']['id']);
        }  
        $data['datatable'] = true;
        $this->template->load('pages','home2',$data);
    }
	public function spin(){
        $data['title']="Spin";
        //$this->load->view('pages/spin',$data);
        $rewards=$this->setting->getspinrewards();
        foreach($rewards as $key=>$single){
            $reward=$single['value'];
            if($single['type']=='Amount'){
                $reward='$'.$reward;
            }
            $rewards[$key]=array('label'=>$reward,'weight'=>0);
        }
        $data['rewards']=$rewards;
        $this->template->load('pages','spin',$data);
    }
	public function changepassword(){
        checklogin();
        $getuser=$this->account->getuser(array("md5(id)"=>$this->session->user));
        if($getuser['status']===true){
            $data['user']=$getuser['user'];
        }
        else{
            redirect('home/');
        }
        $data['title']="Change Password";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['alertify']=true;
		$this->template->load('pages','changepassword',$data);
	}
    public function updatepassword(){
        if($this->input->post('updatepassword')!==NULL){
            $old_password=$this->input->post('old_password');
            $password=$this->input->post('password');
            $repassword=$this->input->post('repassword');
            $user=getuser();
            if(password_verify($old_password.SITE_SALT.$user['salt'],$user['password'])){
                $user=$this->session->user;
                if($password==$repassword){
                    $result=$this->account->updatepassword(array("password"=>$password),array("md5(id)"=>$user));
                    if($result['status']===true){
                        $this->session->set_flashdata('msg',$result['message']);
                    }
                    else{
                        $error=$result['message'];
                        $this->session->set_flashdata('err_msg',$error);
                    }
                }
                else{
                    $error=$result['message'];
                    $this->session->set_flashdata('err_msg',"Password Do not Match!");
                }
            }
            else{
                $this->session->set_flashdata('err_msg',"Old Password Does not Match!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function checkroi(){
        function generatePayoutSchedule($investment, $year, $month) {
            // Get total days in month dynamically
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $totalPayouts = $daysInMonth * 2; // 2 payouts per day
            $targetPercent = 12.0; // Total monthly return in %
            $minPercent = $targetPercent*0.01; // minimum per payout
            $maxPercent = $targetPercent*0.025; // maximum per payout

            $payouts = [];
            $earnedSoFar = 0.0;

            for ($i = 1; $i <= $totalPayouts; $i++) {
                // Remaining payouts after the current one
                $remainingPayouts = $totalPayouts - $i + 1;
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

                $payouts[] = [
                    'payout_no' => $i,
                    'percent' => round($percent, 4),
                    'earned_so_far_percent' => round($earnedSoFar, 4),
                    'amount' => round($amount, 4)
                ];

                // Stop if we have reached exactly 12%
                if (round($earnedSoFar, 4) >= $targetPercent) {
                    break;
                }
            }

            return $payouts;
        }

        // Example Usage:
        $investment = 50; // $1000 investment
        $year = 2025;
        $month = 2; // January (change dynamically)
        $schedule = generatePayoutSchedule($investment, $year, $month);

        // Display Result
        $total=0;
        foreach ($schedule as $p) {
            echo "Payout #{$p['payout_no']}: {$p['percent']}% | Earned So Far: {$p['earned_so_far_percent']}% | Amount: {$p['amount']}<br>";
            $total+=$p['amount'];
        }
        echo "Total: ".$total;
    }
    
    public function chart(){
        $this->load->view('pages/chart');
    }
    
    public function error(){
        $data=['title'=>'Error'];
        $this->template->load('pages','error',$data);
    }
    
    public function testswap(){
        $data=['title'=>'Swap'];
        //$this->template->load('pages','testswap',$data);
        $this->load->view('pages/testswap2',$data);
    }
    
    public function teststake(){
        $data=['title'=>'Stake'];
        $this->template->load('pages','teststake',$data);
    }
    
    public function staked(){
        $data=['title'=>'Staked'];
        $this->template->load('pages','staked',$data);
    }
    
    public function liverate(){
        $data=['title'=>'Live Rate'];
        $this->template->load('pages','liverate',$data);
    }
    
    public function liquidity(){
        $data=['title'=>'Liquidity'];
        $this->template->load('pages','liquidity',$data);
    }
    
    public function generateincome($date=NULL){
        $this->income->generateallincome($date);
        echo "Executed at ".date('d-m-Y H:i:s');
    }
    
    public function testincome($id){
        $user=$this->db->get_where('users',['id'=>$id])->unbuffered_row('array');
        print_pre($user);
        $this->income->generateincome($user);
        echo "Executed at ".date('d-m-Y H:i:s');
    }
    
    public function updateinvestment(){
        $tokenrate=getTokenRate();
        $members=$this->db->get_where('members',"old='1' and regid not in (SELECT regid from ".TP."investments)")->result_array();
        $datetime=date('Y-m-d H:i:s');
        if(!empty($members)){
            foreach($members as $member){
                $amount=$member['package']/2;
                if($tokenrate>0){
                    $amount/=$tokenrate;
                }
                else{
                    $amount=0;
                }
                $data=array('regid'=>$member['regid'],'date'=>date('Y-m-d'),'amount'=>$amount,'old'=>1,'status'=>1,
                            'added_on'=>$datetime,'updated_on'=>$datetime);
                $this->db->insert('investments',$data);
            }
        }
    }
    
    public function updateunstake(){
        $this->db->order_by('updated_on');
        $this->db->group_by('regid,updated_on');
        $this->db->select('*,sum(amount) as t_amount,sum(reward) as t_reward,total as t_total,sum(amount+reward) as tt');
        $investments=$this->db->get_where('investments',['status'=>0,'old'=>0,'unstaked'=>1])->result_array();
        //print_pre($investments,true);
        //echo count($investments);
        $tokenrate=getTokenRate();
        //`regid`, `inv_id`, `date`, `amount`, `rate`, `reward`, `total`, `approve_date`, `response`, `remarks`, `approved_by`, `status`, `added_on`, `updated_on`
        $alldata=array();
        if(!empty($investments)){
            //foreach($investments as $single){
            $regid=0;$s=0;$regids=array();$not=array();
            for($i=0;$i<count($investments);$i++){
                $single=$investments[$i];
                if(bccomp($single['t_total'], $single['tt'], 8) !== 0 && 
                   bccomp($single['t_total'], $single['tt'], 4) !== 0){
                    print_pre($single);
                    $s++;
                    $not[]=$single['id'];
                    continue;
                }
                $regid=$single['regid'];
                $amount=$single['t_amount'];
                $reward=$single['t_reward'];
                $next=isset($investments[$i+1])?$investments[$i+1]:array();
                $added_on=$single['added_on'];
                $updated_on=$single['updated_on'];
                $total=$reward+$amount;
                $date=date('Y-m-d',strtotime($single['updated_on']));
                $data=array('regid'=>$regid,'date'=>$date,'amount'=>$amount,'rate'=>0,
                            'reward'=>$reward,'total'=>$total,'approve_date'=>$date,'approved_by'=>$regid,
                            'status'=>1,'added_on'=>$added_on,'updated_on'=>$updated_on);
                //print_pre($data);
                $alldata[]=$data;
                $regids[]=$regid;
                //echo '<br>--------------------------------<br>';
            }
        }
        echo $s;
        if(!empty($alldata)){
            $this->db->trans_start();
            $this->db->insert_batch('unstake',$alldata);
            if(!empty($regids)){
                $this->db->where_in('regid',$regids);
            }
            if(!empty($not)){
                $this->db->where_not_in('id',$not);
            }
            $this->db->update('investments',['unstake'=>0],['status'=>0,'old'=>0,'unstaked'=>1]);
            print_pre($this->db->last_query());
        }
        //print_pre($alldata);
    }
    
    public function runquery(){
        $query=array(
                    "CREATE TABLE `fp_spin_rewards` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `type` varchar(10) NOT NULL,
 `value` varchar(50) NOT NULL,
 `status` tinyint(1) NOT NULL DEFAULT 1,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4"
        );
        foreach($query as $sql){
            if(!$this->db->query($sql)){
                print_r($this->db->error());
            }
        }
    }
    
    public function importdata(){
        $json=file_get_contents(file_url('assets/data.json'));
        return false;
        $array=json_decode($json,true);
        if(!empty($array)){
            foreach($array as $row){
                if(empty($row['Member ID'])){
                    continue;
                }
                
                $username=$row['Member ID'];
                $name=$row['Name'];
                $susername=$row['Sponsor ID'];
                $sname=$row['Sponsor Name'];
                $date=date('Y-m-d',strtotime($row['Joining Date']));
                $mobile=$row['MobileNo'];
                $email=$row['Email'];
                $amount=$row['Amount'];
                $wallet_address=$row['Wallet Address'];
                $getreferrer=$this->account->getuser("username='$susername'");
                
                $userdata=$memberdata=array();
                if($getreferrer['status']===true){
                    $referrer=$getreferrer['user'];
                    $userdata['username']=$username;
                    $userdata['name']=$name;
                    $userdata['mobile']=$mobile;
                    $userdata['email']=$email;
                    $userdata['role']="member";
                    $userdata['status']="1";

                    $memberdata['name']=$name;
                    $memberdata['wallet_address']=!empty($wallet_address)?$wallet_address:NULL;
                    $memberdata['refid']=$referrer['id'];
                    $memberdata['date']=$date;
                    $memberdata['time']=date('H:i:s');
                    $memberdata['activation_date']=$date;
                    $memberdata['activation_time']=date('H:i:s');
                    $memberdata['old']=1;
                    $status=1;
                    if(empty($amount) && empty($wallet_address)){
                        $amount=0;
                        $status=0;
                    }
                    $memberdata['package']=$amount;
                    $memberdata['status']=$status;


                    $data=array("userdata"=>$userdata,"memberdata"=>$memberdata);
                    print_pre($data);//continue;
                    //print_pre($data,true);
                    $result=$this->member->addmember($data);
                    print_pre($result);
                    echo '------------------------------------------------';
                }
                else{
                    
                    print_pre($susername);
                    print_pre($getreferrer);
                }
            }
        }
    }
    
}
