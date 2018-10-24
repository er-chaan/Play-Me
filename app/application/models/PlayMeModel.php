<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayMeModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		date_default_timezone_set("Asia/Kolkata");
	}

	function register($email, $password, $contact)
	{
		$query = $this->db->query('SELECT * FROM pm_users where email="'.$email.'"');
		if($query->num_rows()){
			return "already_exist";
		}
		else
		{
			$data = array(
			        'email' => $email,
			        'password' => $password,
			        'contact' => $contact,
			        'status' => 'active'
			);

			$this->db->insert('pm_users', $data);
			return "success";
		}
	}
	function authentication($email, $password)
	{
		$query = $this->db->query('SELECT * FROM pm_users where email="'.$email.'" AND password="'.$password.'"');
		if($query->num_rows()){
			return "success";
		}
		else
		{
			return "failed";
		}
	}
	function recover($email)
	{
		$query = $this->db->query('SELECT * FROM pm_users where email="'.$email.'"');
		if($query->num_rows()){
			$this->data=$query->row();
			return $this->data;
		}
		else
		{
			return "failed";
		}
	}
	function user_profile($email)
	{
		$query = $this->db->query('SELECT * FROM pm_users where email="'.$email.'"');
		if($query->num_rows()){
			$this->data=$query->row();
			return $this->data;
		}
		else
		{
			return "failed";
		}
	}
	function update_contact($email,$contact)
	{
		$this->db->query('UPDATE pm_users SET contact="'.$contact.'" where email="'.$email.'"');
	}
	function update_password($email,$password)
	{
		$this->db->query('UPDATE pm_users SET password="'.$password.'" where email="'.$email.'"');
	}
	function cashin($email,$cashin_amount,$particulars)
	{
		$balance=0;
		$query = $this->db->query('SELECT * FROM pm_accounts where email="'.$email.'" ORDER BY tid DESC LIMIT 1');
		if($query->num_rows()){
			$data=$query->row();
			$balance=$data->balance;
		}
		$balance = $balance + $cashin_amount;

		$data = array(
			        'email' => $email,
			        'date' => date('Y-m-d'),
			        'particulars' => $particulars,
			        'debit' => 0,
			        'credit' => $cashin_amount,
			        'balance' => $balance,
			        'status' => 'cashin'
			);

		if($this->db->insert('pm_accounts', $data))
		{
			return "ok";
		}
		else
		{
			return "failed";
		}
	}
	function cashout($email,$cashout_amount,$particulars)
	{
		$balance=0;
		$query = $this->db->query('SELECT * FROM pm_accounts where email="'.$email.'" ORDER BY tid DESC LIMIT 1');
		if($query->num_rows()){
			$data=$query->row();
			$balance=$data->balance;
		}
		if($balance > $cashout_amount || $balance == $cashout_amount)
		{
			$balance = $balance - $cashout_amount;
			$data = array(
			        'email' => $email,
			        'date' => date('Y-m-d'),
			        'particulars' => $particulars,
			        'debit' => $cashout_amount,
			        'credit' => 0,
			        'balance' => $balance,
			        'status' => 'cashin'
			);
			if($this->db->insert('pm_accounts', $data))
			{
				return "ok";
			}
			else
			{
				return "failed";
			}
		}
		else
		{
			return "invalid_amount";
		}
		
	}
	function accounts_balance($email)
	{
		$balance=0;
		$query = $this->db->query('SELECT * FROM pm_accounts where email="'.$email.'" ORDER BY tid DESC LIMIT 1');
		if($query->num_rows()){
			$data=$query->row();
			$balance=$data->balance;
		}
		return $balance;
	}
	function total_payin($email)
	{
		$this->db->select_sum('credit');
	    $this->db->from('pm_accounts');
	    $this->db->where('(email = "'.$email.'") ');
	    $query = $this->db->get();
	    return $query->row()->credit;
	}
	function total_payout($email)
	{
		$this->db->select_sum('debit');
	    $this->db->from('pm_accounts');
	    $this->db->where('(email = "'.$email.'") ');
	    $query = $this->db->get();
	    return $query->row()->debit;
	}
	function accounts_data($email)
	{
		$query = $this->db->query('SELECT * FROM pm_accounts where email="'.$email.'" ORDER BY tid DESC');
		if($query->num_rows()){
			$data=$query->result();
			return $data;
		}	
	}
	function inplay_matches()
	{
		$date=date('Y-m-d');
		$query = $this->db->query('SELECT * FROM pm_matches where status="OPEN" and `date` > "'.$date.'" ORDER BY mid DESC');
		if($query->num_rows()){
			$data=$query->result();
			return $data;
		}	
	}
	function bets_instore()
	{
		$query = $this->db->query('SELECT * FROM pm_matches ORDER BY mid DESC');
		if($query->num_rows()){
			$data=$query->result();
			return $data;
		}	
	}
	function users_bets($email)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where email="'.$email.'" ORDER BY bid DESC');
		if($query->num_rows()){
			$data=$query->result();
			return $data;
		}	
	}
	function get_rate($mid,$team)
	{
		$query1 = $this->db->query('SELECT team_A_rate FROM pm_matches where mid='.$mid.' AND team_A="'.$team.'" AND status="OPEN"');
		$query2 = $this->db->query('SELECT team_B_rate FROM pm_matches where mid='.$mid.' AND team_B="'.$team.'" AND status="OPEN"');
		if($query1->num_rows()){
			$data1=$query1->row();
		}
		if($query2->num_rows()){
			$data2=$query2->row();
		}

		if(!empty($data2))
		{
			return $data2->team_B_rate;
		}

		if(!empty($data1))
		{
			return $data1->team_A_rate;
		}
	}
	function place_bet($date,$email,$mid,$team,$team_rate,$bet_units)
	{
		$data = array(
			        'date' => $date,
			        'email' => $email,
			        'mid' => $mid,
			        'team' => $team,
			        'team_rate' => $team_rate,
			        'bet_units' => $bet_units,
			        'result' => 'TBA',
			        'status' => 'OPEN'
			);
			
		if($this->db->insert('pm_bets', $data))
		{
			return "OK";
		}	
		else
		{
			return "fail";
		}
	}
	function total_played($email)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where email="'.$email.'"');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function total_won($email)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where email="'.$email.'" AND result="WON"');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function total_lost($email)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where email="'.$email.'" AND result="LOST"');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function total_nr($email)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where email="'.$email.'" AND result != "WON" AND result != "LOST"');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function start_bet($match_date,$team_A,$team_A_rate,$team_B,$team_B_rate)
	{
		$data = array(
			        'date' => $match_date,
			        'team_A' => $team_A,
			        'team_A_rate' => $team_A_rate,
			        'team_B' => $team_B,
			        'team_B_rate' => $team_B_rate,
			        'result' => 'TBA',
			        'status' => 'OPEN'
			);
			
		if($this->db->insert('pm_matches', $data))
		{
			return "OK";
		}	
		else
		{
			return "fail";
		}
	}
	function start_bet_delete($mid)
	{
		$check=$this->db->query('DELETE from pm_matches where mid='.$mid.'');
		if($check)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	function start_bet_update($mid,$result,$status)
	{
		$check=$this->db->query('UPDATE pm_matches set result="'.$result.'", status="'.$status.'" where mid='.$mid.'');
		if($check)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	function update_bets_results($mid,$result)
	{
		$this->db->query('UPDATE pm_bets set result="WON" where mid='.$mid.' AND team ="'.$result.'"');
		$this->db->query('UPDATE pm_bets set result="LOST" where mid='.$mid.' AND team !="'.$result.'"');
	}
	function fetch_bets_winners($mid)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where mid='.$mid.' AND result="WON" AND status!="CLOSED"');
		return $query->result();
	}
	function update_bets_win_amount($bid,$win_amount)
	{
		$this->db->query('UPDATE pm_bets set win_amount='.$win_amount.', result="WON", status="CLOSED" where bid='.$bid.'');
	}
	function fetch_bets_winners_nr($mid)
	{
		$query = $this->db->query('SELECT * FROM pm_bets where mid='.$mid.' AND status!="CLOSED"');
		return $query->result();
	}
	function update_bets_win_amount_nr($bid,$win_amount,$nr)
	{
		$this->db->query('UPDATE pm_bets set win_amount='.$win_amount.', result="'.$nr.'", status="CLOSED" where bid='.$bid.'');
	}
	function total_users_X()
	{
		$query = $this->db->query('SELECT * FROM pm_users');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function total_matches_X()
	{
		$query = $this->db->query('SELECT * FROM pm_matches');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function total_bets_X()
	{
		$query = $this->db->query('SELECT * FROM pm_bets');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	function total_payin_X()
	{
		$this->db->select_sum('credit');
	    $this->db->from('pm_accounts');
	    $query = $this->db->get();
	    return $query->row()->credit;
	}
	function total_payout_X()
	{
		$this->db->select_sum('debit');
	    $this->db->from('pm_accounts');
	    $query = $this->db->get();
	    return $query->row()->debit;
	}
}