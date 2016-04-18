<?php
class Users_model extends CI_Model {
	function __construct(){
		parent::__construct();//is this a auto executing function that runs only when requested, once, or always?
		$this->load->database('default');
	}
	public function get_all_users(){
		$query = $this->db->get('users');
		return $query->result();
	}
	public function insert_users_to_db($data){
		return $this->db->insert('users', $data);
	}
	public function getById($id){//called from controllers/users via show_users views 'edit' option (and java script). $id is passed from users.php
		$query = $this->db->get_where('users',array('id'=>$id/*shouldnt this be 'id'==$id ?*/));
		return $query->row_array();
	}
	public function delete_a_user($id){
		$this->db->where('users.id',$id);//does where() translate the parameters into a query?
		return $this->db->delete('users');
	}
	public function update_info($data,$id){
		$this->db->where('users.id',$id);//is where() a built in function?
		return $this->db->update('users', $data);//is this returning a query result?... nevermind, yes.
	}
}
?>