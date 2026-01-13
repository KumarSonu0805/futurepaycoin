<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load global models, check auth, etc.
        $this->load->library('template');
        $admin_address=$this->setting->getsettings(array("name"=>'admin_address'),"single");;
        if(empty($admin_address['value'])){
            $address='0x7C09243fc50E4389646671Dd2CF0C274f51d3638';
        }
        else{
            $address=$admin_address['value'];
        }
        defined('ADMIN_ADDRESS')           OR define('ADMIN_ADDRESS',$address);
        defined('TOKEN_ADDRESS')           OR define('TOKEN_ADDRESS',"0xb690Ddcaccc7FBD89c596cE9c78975195dfb70a0");
    }
}