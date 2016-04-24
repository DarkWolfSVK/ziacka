<?php


class userModel extends CI_Model
{
	function login($username, $password)
	{
		$this -> db -> select('id, prihlasovacie_meno, heslo, meno, priezvisko, rola, trieda');
		$this -> db -> from('uzivatel');
		$this -> db -> where('prihlasovacie_meno', $username);
		$this -> db -> where('heslo', SHA1($password));
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
		 return $query->result();
		}
		else
		{
		 return "Error lol";
		}
	}

	function get_ziak_znamky($ziak_id)
	{
		$this -> db -> select('znamka,nazov');
		$this -> db -> from('znamka');
		$this -> db -> join('predmet','znamka.predmet = predmet.id','left');
		$this -> db -> where('ziak',$ziak_id);

		$query = $this -> db -> get();

		return $query->result();
	}

	function get_triedy()
	{	
		$this -> db -> select('*');
		$this -> db -> from('triedy');
		$this -> db -> order_by("trieda","asc");

		$query = $this -> db -> get();

		return $query->result();
	}

	function get_ziaci()
	{	
		$this -> db -> select('*');
		$this -> db -> from('uzivatel');
		$this -> db -> where('rola',"2");
		
		$query = $this -> db -> get();

		return $query->result();
	}

	function get_predmety()
	{	
		$this -> db -> select('*');
		$this -> db -> from('predmet');
		
		$query = $this -> db -> get();

		return $query->result();
	}

	function get_znamky()
	{	
		$this -> db -> select('*');
		$this -> db -> from('znamka');
		
		$query = $this -> db -> get();

		return $query->result();
	}

	function delete_znamka($id)
	{
		return $this->db->delete('znamka', array('id' => $id));
	}

	function add_znamku($data){
		$success = $this->db->insert('znamka', $data);
		return $success ? $this->db->insert_id() : false;
	}
}