<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MY_Controller {
    
	public function index(){
		$this->load->view('website/index');
	}
	public function about(){
		$this->load->view('website/about');
	}
	public function ecosystem(){
		$this->load->view('website/ecosystem');
	}
	public function tokenomics(){
		$this->load->view('website/tokenomics');
	}
	public function rewards(){
		$this->load->view('website/rewards');
	}
	public function terms(){
		$this->load->view('website/terms_and_condition');
	}
    
}
