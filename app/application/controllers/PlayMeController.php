<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayMeController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->model('PlayMeModel');
		date_default_timezone_set("Asia/Kolkata");
	}
	public function index()
	{
		if($this->session->userdata('session_id')):
		redirect('dashboard');
		endif;
	}
	public function signup()
	{
		if($this->session->userdata('session_id')):
		redirect('dashboard');
		endif;
		$this->load->view('PlayMeViewSignup');
	}
	public function register()
	{
		if($this->session->userdata('session_id')):
		redirect('dashboard');
		endif;
		   $signup_email = $this->input->post('signup_email');
		   $signup_password = $this->input->post('signup_password');
		   $signup_contact = $this->input->post('signup_contact');
		   if($signup_email != null && $signup_password != null && $signup_contact != null)
		   {
		   		if (!filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {
			      echo "Invalid email format";
			    }
			    elseif (!filter_var($signup_contact, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1111111111, "max_range"=>9999999999)))) {
			      echo "Invalid contact number";
			    }	
			    else {
			    	$check=$this->PlayMeModel->register($signup_email, $signup_password, $signup_contact);
			    	if($check=="already_exist")
			    	{
			    		echo "Email already registered, try again";
			    	}
			    	elseif($check=="success")
			    	{
			    		$this->email->from('admin@er-chaan.xyz', ' Play-me');
						$this->email->to($signup_email);
						$this->email->subject('Welcome to play me');
						$this->email->message('Welcome to Play me ! enjoy free style betting !');
						$this->email->send();
			    		$this->session->set_userdata('session_id',$signup_email);
			    		echo "Wait for 5 seconds.....";
			    	}
			    	else
			    	{	
			    		echo "Technical error, try again";
			    	}
			    }
		   }
		   else{
		   	echo "Invalid entry";
		   }
	}
	public function authentication()
	{
		if($this->session->userdata('session_id')):
		redirect('dashboard');
		endif;
		   $signin_email = $this->input->post('signin_email');
		   $signin_password = $this->input->post('signin_password');
		   if($signin_email != null && $signin_password != null)
		   {
		   		if (!filter_var($signin_email, FILTER_VALIDATE_EMAIL)) {
			      echo "Invalid email format";
			    }
			    else {
			    	$check=$this->PlayMeModel->authentication($signin_email, $signin_password);
			    	if($check=="failed")
			    	{
			    		echo "Authentication failed, try again";
			    	}
			    	elseif($check=="success")
			    	{
			    		$this->session->set_userdata('session_id',$signin_email);
			    		echo "Wait for 5 seconds.....";
			    	}
			    	else
			    	{	
			    		echo "Technical error, try again";
			    	}
			    }
		   }
		   else{
		   	echo "Invalid entry";
		   }
	}
	public function recover()
	{
		if($this->session->userdata('session_id')):
		redirect('dashboard');
		endif;
		   $recover_email = $this->input->post('recover_email');
		   if($recover_email == null)
		   {
		   	echo "invalid entry";
		   }
		   else {
		    if (!filter_var($recover_email, FILTER_VALIDATE_EMAIL)) {
		      echo "Invalid email format";
		    }
		    else
		    {
		    	$data=$this->PlayMeModel->recover($recover_email);
		    	if($data=="failed")
		    	{
		    		echo "Email id not found";
		    	}
		    	else
		    	{
		    		$this->email->from('admin@er-chaan.xyz', ' Play-me');
					$this->email->to($recover_email);
					$this->email->subject('Login credentials');
					$this->email->message('Your password is: "'.$data->password.'"');
					$this->email->send();
		    		echo "Check your email to check password";
		    	}
		    }
	       }
	}
	public function signin()
	{
		if($this->session->userdata('session_id')):
		redirect('dashboard');
		endif;
		$this->load->view('PlayMeViewSignin');
	}
	public function signout()
	{
		$this->session->unset_userdata('session_id');
		redirect('signin');
	}
	public function dashboard()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$this->load->view('PlayMeViewDashboard');
	}
	public function settings()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$this->data=$this->PlayMeModel->user_profile($this->session->userdata('session_id'));
		$this->load->view('PlayMeViewSettings',$this->data);
	}
	public function update_contact()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$settings_contact = $this->input->post('settings_contact');
		if($settings_contact != null)
		{
			if(!filter_var($settings_contact, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1111111111, "max_range"=>9999999999)))) {
			      echo "Invalid contact number";
			    }
			    else
			    {
			    	$this->PlayMeModel->update_contact($this->session->userdata('session_id'),$settings_contact);
			echo "Contact number successfully updated";
			    }	
		}
		else
		{
			echo "Invalid entry";
		}
	}
	public function update_password()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$settings_old_password = $this->input->post('settings_old_password');
		$settings_new_password = $this->input->post('settings_new_password');
		if($settings_old_password != null && $settings_new_password != null)
		{
			$this->data=$this->PlayMeModel->user_profile($this->session->userdata('session_id'));
			if($this->data->password == $settings_old_password)
			{
				$this->PlayMeModel->update_password($this->session->userdata('session_id'),$settings_new_password);
				$this->email->from('admin@er-chaan.xyz', 'Play-me');
				$this->email->to($this->session->userdata('session_id'));
				$this->email->subject('Password reset');
				$this->email->message('Your new password is: "'.$this->data->password.'"');
				$this->email->send();
				echo "Password successfully changed";
			}
			else
			{
				echo "Current password doesnot match";
			}
		}
		else
		{
			echo "Invalid entry";
		}
	}
	public function accounts()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$this->data=$this->PlayMeModel->user_profile($this->session->userdata('session_id'));
		$this->load->view('PlayMeViewAccounts',$this->data);
	}
	public function accounts_data()
	{
		
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$data=$this->PlayMeModel->accounts_data($this->session->userdata('session_id'));
		echo json_encode($data);
	}
	public function cashin()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$cashin_amount = $this->input->post('cashin_amount');
		if($cashin_amount == 100)
		{
			
			$check=$this->PlayMeModel->cashin($this->session->userdata('session_id'),$cashin_amount,'play-me cashin');
			if($check == "ok")
			{
				echo "cashin successfull";
			}
			else
			{
				echo "cashin failed, try again";
			}
			//echo "currently banking server is down !, try later";
		}
		else
		{
			echo "invalid cashin amount";
		}
	}
	public function cashout()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$cashout_amount = $this->input->post('cashout_amount');
		if($cashout_amount != null)
		{
			$check=$this->PlayMeModel->cashout($this->session->userdata('session_id'),$cashout_amount,'play-me cashout');
			if($check == "ok")
			{
				echo "cashout successfull";
			}
			elseif ($check == "invalid_amount") {
				echo "cashout balance exided, enter valid cashout amount";
			}
			else
			{
				echo "cashout failed, try again";
			}
		}
		else
		{
			echo "invalid cashout amount";
		}
	}
	public function accounts_balance()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$balance=$this->PlayMeModel->accounts_balance($this->session->userdata('session_id'));
			if($balance != null)
			{
				echo $balance;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function games()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;	
		$this->load->view('PlayMeViewGames');
	}
	public function place_bet()
	{
		$date=date('Y-m-d');
		$email=$this->session->userdata('session_id');
		$mid=$this->input->post('bet_mid');
		$team=$this->input->post('bet_team');
		$team_rate=$this->PlayMeModel->get_rate($mid,$team);
		$bet_units=$this->input->post('bet_units');
		$balance=$this->PlayMeModel->accounts_balance($this->session->userdata('session_id'));
		if($bet_units != null && $bet_units > 9 && $bet_units < 101 && $bet_units <= $balance)
		{
			$check=$this->PlayMeModel->place_bet($date,$email,$mid,$team,$team_rate,$bet_units);
			if($check=='OK')
			{
				$this->PlayMeModel->cashout($this->session->userdata('session_id'),$bet_units,'bet for mid:'.$mid.'-team:'.$team.'-team_rate:'.$team_rate.'');
				echo 'Bet placed successfully';
			}
			else
			{
				echo 'Bet fails, try again';
			}
		}
		else
		{
			echo 'Bet fails, try again';
		}
	}

	public function inplay_matches()
	{	
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$data=$this->PlayMeModel->inplay_matches();
		echo json_encode($data);
	}
	public function bets_instore()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$data=$this->PlayMeModel->bets_instore();
		echo json_encode($data);
	}
	public function users_bets()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		$data=$this->PlayMeModel->users_bets($this->session->userdata('session_id'));
		echo json_encode($data);
	}
	public function total_payin()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_payin=$this->PlayMeModel->total_payin($this->session->userdata('session_id'));
			if($total_payin != null)
			{
				echo $total_payin;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_payout()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_payout=$this->PlayMeModel->total_payout($this->session->userdata('session_id'));
			if($total_payout != null)
			{
				echo $total_payout;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_played()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_played=$this->PlayMeModel->total_played($this->session->userdata('session_id'));
			if($total_played != null)
			{
				echo $total_played;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_won()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_won=$this->PlayMeModel->total_won($this->session->userdata('session_id'));
			if($total_won != null)
			{
				echo $total_won;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_lost()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_lost=$this->PlayMeModel->total_lost($this->session->userdata('session_id'));
			if($total_lost != null)
			{
				echo $total_lost;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_nr()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_nr=$this->PlayMeModel->total_nr($this->session->userdata('session_id'));
			if($total_nr != null)
			{
				echo $total_nr;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function admin()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		if($this->session->userdata('session_id') != "er.chandreshbhai@gmail.com"):
		redirect('signin');
		endif;

		$this->load->view('PlayMeViewAdmin');
	}
	public function start_bet()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		if($this->session->userdata('session_id') != "er.chandreshbhai@gmail.com"):
		redirect('signin');
		endif;
		$match_date=$this->input->post('match_date');
		$team_A=$this->input->post('team_A');
		$team_A_rate=$this->input->post('team_A_rate');
		$team_B=$this->input->post('team_B');
		$team_B_rate=$this->input->post('team_B_rate');
		if($match_date != null && $team_A != null && $team_A_rate != null && $team_B != null && $team_B_rate != null)
		{
			if($team_A_rate < 5.1 && $team_B_rate < 5.1 )
			{
				$check=$this->PlayMeModel->start_bet($match_date,$team_A,$team_A_rate,$team_B,$team_B_rate);
				if($check=="OK")
				{
					echo "bet started successfully";
				}
				else
				{
					echo "technial error, try again";
				}
			}
			else
			{
				echo "team rates should not exeed 5.0";
			}
		}
		else
		{
			echo "Invalid inputs";
		}
	}
	public function start_bet_delete()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		if($this->session->userdata('session_id') != "er.chandreshbhai@gmail.com"):
		redirect('signin');
		endif;
		$mid=$this->input->post('mid');
		if($mid != null)
		{
			$check=$this->PlayMeModel->start_bet_delete($mid);
			if($check==1)
			{
				echo "Delete operation successfull";
			}
			else
			{
				echo "Delete operation failed, try again";
			}
		}
		else
		{
			echo "Delete operation failed, try again";
		}
	}
	public function start_bet_update()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
		if($this->session->userdata('session_id') != "er.chandreshbhai@gmail.com"):
		redirect('signin');
		endif;
		$mid=$this->input->post('mid');
		$result=$this->input->post('result');
		$status=$this->input->post('status');
		if($mid != null && $result != null && $status != null)
		{
			$check=$this->PlayMeModel->start_bet_update($mid,$result,$status);
			if($check==1)
			{
				if($result != "NR")
				{
					$this->PlayMeModel->update_bets_results($mid,$result);
					
					$data=$this->PlayMeModel->fetch_bets_winners($mid);
					foreach ($data as $key => $value) {
					$this->PlayMeModel->update_bets_win_amount($value->bid,($value->team_rate)*($value->bet_units));
					$this->PlayMeModel->cashin($value->email,($value->team_rate)*($value->bet_units),'cashin for - MID : '.$mid.'');
					}

					echo "Update operation successfull";
				}
				else
				{
					$data=$this->PlayMeModel->fetch_bets_winners_nr($mid);
					foreach ($data as $key => $value) {
					$this->PlayMeModel->update_bets_win_amount_nr($value->bid,$value->bet_units,'NR');
					$this->PlayMeModel->cashin($value->email,$value->bet_units,'cashin for - MID : '.$mid.'');
					}
					echo "Update operation successfull";
				}
			}
			else
			{
				echo "Update operation failed, try again";
			}
		}
		else
		{
			echo "Delete update failed, try again";
		}
	}
	public function total_users_X()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_users=$this->PlayMeModel->total_users_X();
			if($total_users != null)
			{
				echo $total_users;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_matches_X()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_matches=$this->PlayMeModel->total_matches_X();
			if($total_matches != null)
			{
				echo $total_matches;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_bets_X()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_bets=$this->PlayMeModel->total_bets_X();
			if($total_bets != null)
			{
				echo $total_bets;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_payin_X()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_payin=$this->PlayMeModel->total_payin_X();
			if($total_payin != null)
			{
				echo $total_payin;
			}
			else
			{
				echo "technical error, try again";
			}
	}
	public function total_payout_X()
	{
		if(!$this->session->userdata('session_id')):
		redirect('signin');
		endif;
			$total_payout=$this->PlayMeModel->total_payout_X();
			if($total_payout != null)
			{
				echo $total_payout;
			}
			else
			{
				echo "technical error, try again";
			}
	}
}
