<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	function __construct(){
		parent::__construct();
        checklogin();
	}

	public function index(){
        if($this->session->role!='admin'){
            redirect('/');
        }
        $data['title']="Settings";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $where=array('status'=>1);
        $this->setting->generatesettings($where);
        $data['settings']=$this->setting->getsettings($where);
		$this->template->load('settings','general',$data);
	}

	public function spinrewards(){
        if($this->session->role!='admin'){
            redirect('/');
        }
        $data['title']="Spin Rewards";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['rewards']=$this->setting->getspinrewards();
		$this->template->load('settings','spinrewards',$data);
	}
    

    public function updatesetting(){
        if($this->input->post('updatesetting')!==NULL){
            $data=$this->input->post();
            unset($data['updatesetting']);
			$result=$this->setting->updatesetting($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        if(!empty($data) && !isset($data['id'])){
            unset($_SESSION["msg"],$_SESSION["err_msg"]);
            echo json_encode($result);
            exit;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getsetting(){
        $id=$this->input->post('id');
        $setting=$data['settings']=$this->setting->getsettings(array("md5(concat('setting-',id))"=>$id),"single");
        echo json_encode($setting);
    }
    
    public function savereward(){
        if($this->input->post('savereward')!==NULL){
            $data=$this->input->post();
            unset($data['savereward']);
			$result=$this->setting->savereward($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        elseif($this->input->post('updatereward')!==NULL){
            $data=$this->input->post();
            unset($data['updatereward']);
			$result=$this->setting->updatereward($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        if(!empty($data) && !isset($data['id'])){
            unset($_SESSION["msg"],$_SESSION["err_msg"]);
            echo json_encode($result);
            exit;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getreward(){
        $id=$this->input->post('id');
        $reward=$data['rewards']=$this->setting->getspinrewards(array("md5(concat('reward-',id))"=>$id),"single");
        echo json_encode($reward);
    }

}
