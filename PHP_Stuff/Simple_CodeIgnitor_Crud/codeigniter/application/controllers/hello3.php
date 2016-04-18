<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Hello3 extends CI_Controller{
	var $name;
	var $color;
	
	function __construct(){
		parent::__construct();
		$this->name="Faisal";
		$this->color="red";
	}

	function you($firstname='', $lastname=''){
		$data['name']=($firstname) ? ($firstname.' '.$lastname) : ($This->name);
		$data['color']=$this->color;
		
		$this->load->view('you_view2',$data);
	}
}
?>