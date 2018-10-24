<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'PlayMeController/dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['signup'] = 'PlayMeController/signup';
$route['settings'] = 'PlayMeController/settings';
$route['signin'] = 'PlayMeController/signin';
$route['signout'] = 'PlayMeController/signout';
$route['dashboard'] = 'PlayMeController/dashboard';
$route['register'] = 'PlayMeController/register';
$route['recover'] = 'PlayMeController/recover';
$route['games'] = 'PlayMeController/games';
$route['accounts'] = 'PlayMeController/accounts';
$route['authentication'] = 'PlayMeController/authentication';
$route['update_contact'] = 'PlayMeController/update_contact';
$route['update_password'] = 'PlayMeController/update_password';
$route['cashin'] = 'PlayMeController/cashin';
$route['cashout'] = 'PlayMeController/cashout';
$route['account_number'] = 'PlayMeController/account_number';
$route['accounts_data'] = 'PlayMeController/accounts_data';
$route['accounts_balance'] = 'PlayMeController/accounts_balance';
$route['inplay_matches'] = 'PlayMeController/inplay_matches';
$route['users_bets'] = 'PlayMeController/users_bets';
$route['total_payin'] = 'PlayMeController/total_payin';
$route['total_payout'] = 'PlayMeController/total_payout';
$route['total_played'] = 'PlayMeController/total_played';
$route['total_lost'] = 'PlayMeController/total_lost';
$route['total_won'] = 'PlayMeController/total_won';
$route['total_nr'] = 'PlayMeController/total_nr';
$route['admin'] = 'PlayMeController/admin';
$route['start_bet'] = 'PlayMeController/start_bet';
$route['start_bet_delete'] = 'PlayMeController/start_bet_delete';
$route['start_bet_update'] = 'PlayMeController/start_bet_update';
$route['bets_instore'] = 'PlayMeController/bets_instore';
$route['place_bet'] = 'PlayMeController/place_bet';
$route['total_payin_X'] = 'PlayMeController/total_payin_X';
$route['total_payout_X'] = 'PlayMeController/total_payout_X';
$route['total_users_X'] = 'PlayMeController/total_users_X';
$route['total_matches_X'] = 'PlayMeController/total_matches_X';
$route['total_bets_X'] = 'PlayMeController/total_bets_X';

