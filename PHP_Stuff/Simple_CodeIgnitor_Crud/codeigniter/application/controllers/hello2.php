<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Hello2 extends CI_Controller{
	var $name;
	var $color;
	
	function __construct(){
		parent::__construct();
		$this->name="Abir";
		$this->color="red";
	}

	function you(){
		$data['name']=$this->name;
		$data['color']=$this->color;
		
		$this->load->view('you_view2',$data);
	}
}
?>