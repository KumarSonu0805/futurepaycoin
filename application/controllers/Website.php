<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load global models, check auth, etc.
    }
    
    public function index(){
        checklogin();
        $data=['title'=>'Home'];
        if($this->session->role=='admin' && $this->session->user==md5(1)){
        }
        else{
            $data['user']=getuser();
            $data['member']=$this->member->getmemberdetails($data['user']['id']);
        }  
        $this->template->load('pages','home',$data);
    }
    
}