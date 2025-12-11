<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        checklogin();
        // Load global models, check auth, etc.
    }
    
    public function index(){
        $data=['title'=>'Home'];
        //$this->template->load('pages','home',$data);
    }
    
	public function stakingreward(){
        $data['title']="Staking Reward";
        $data['tabulator']=true;
        $this->template->load('income','stakingreward',$data);      
    }
    
	public function levelincome(){
        $data['title']="Level Income";
        $data['tabulator']=true;
        $this->template->load('income','levelincome',$data);      
    }
    
	public function matchingincome(){
        $data['title']="Matching Income";
        $data['tabulator']=true;
        $this->template->load('income','matchingincome',$data);      
    }
    
	public function smartachievement(){
        $data['title']="Smart Achievement Bonus";
        $data['tabulator']=true;
        $this->template->load('income','smartachievement',$data);      
    }
    
	public function rewardincome(){
        $data['title']="Rank &amp; Reward Income";
        $data['tabulator']=true;
        $this->template->load('income','rewardincome',$data);      
    }
    
	public function getincome(){
        $type=$this->input->get('type');
        $user=getuser();
        $incomes=$this->income->getincome(['t1.regid'=>$user['id'],'t1.type'=>$type],'t1.date desc, t1.id desc');
        $incomes=[];
        echo json_encode($incomes);  
    }
    
}