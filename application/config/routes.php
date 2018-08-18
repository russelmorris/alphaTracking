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
$route['default_controller']   = 'c_dashboard/dashboard';
$route['404_override']         = '';
$route['translate_uri_dashes'] = false;

$route['login']  = 'c_login/login';
$route['logout'] = 'c_login/logout';

$route['dashboard']       = 'c_dashboard/dashboard';
$route['admin-dashboard'] = 'c_admin/dashboard';
$route['committee-completion-summary'] = 'c_admin/dashboard';


$route['update-factor'] = 'c_dashboard/updateFactor';
$route['update-veto'] = 'c_dashboard/updateVeto';
$route['update-finalise'] = 'c_dashboard/updateFinalise';
$route['update-finalise-all'] = 'c_dashboard/updateFinaliseAll';

$route['dashboard-ajax']  = 'c_dashboard/dashboard_ajax';
$route['finalised-value']  = 'c_dashboard/finalised_value';

$route['import-prospect']      = 'c_admin/import_prospect';
$route['import-returns']       = 'c_admin/import_returns';


$route['voting/(:any)/(:any)'] = 'c_voting/voting/$1/$2';
$route['submit-voting']        = 'c_voting/submit_voting';


$route['factor-weights']        = 'c_factors/factorWeights';
$route['submit-factors-weight']        = 'c_factors/submitFactorsWeight';



$route['build-portfolio']       = 'c_calculation/buildPortfolio';
$route['create-human-score'] = 'c_calculation/create_human_score';



$route['create-csv-googletrends'] = 'c_create_csv/createGoogletrends';
$route['create-csv-alexa'] = 'c_create_csv/createAlexa';

