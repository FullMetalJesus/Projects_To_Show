<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct(){//does '__construct' always automatically load?
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
	}
	public function index(){//is this an auto executing function? I can't figure out why its being called... If so, only once? every time? only when called?
		$data['user_list'] = $this->users_model->get_all_users();
		$this->load->view('show_users', $data);//is data a session variable?
	}
	public function add_form(){//why arent the rest of these functions automatically loaded?
		$this->load->view('insert');
	}
	public function insert_user_db(){
		$udata['name'] = $this->input->post('name');
		$udata['email'] = $this->input->post('email');
		$udata['address'] = $this->input->post('address');
		$udata['mobile'] = $this->input->post('mobile');
		$res = $this->users_model->insert_users_to_db($udata);
		if($res){
			header('location:'.base_url()."index.php/users/".$this->index());
		}
	}
	public function update(){
		$mdata['name']=$_POST['name'];
		$mdata['email']=$_POST['email'];
		$mdata['address']=$_POST['address'];
		$mdata['mobile']=$_POST['mobile'];
		$res=$this->users_model->update_info($mdata, $_POST['id']);
		if($res){//res returns back to this page if true... i wonder what happens if it isnt?
			header('location:'.base_url()."index.php/users/".$this->index());
		}
	}
	public function delete($id){
		$this->users_model->delete_a_user($id);
		$this->index();
	}
	public function edit(){//shouldnt gotoid from show_users be passed as a paramter into this?
		$id = $this->uri->segment(3);//what does 'segment()' do? does it pull gotoid from show_users via the edit option (in javascript) on that file?
		$data['user'] = $this->users_model->getById($id);//this will be a returned row arrow from database.aka a user and their subesquent info.
		$this->load->view('edit', $data);//sent to edit.php
	}
}
?>