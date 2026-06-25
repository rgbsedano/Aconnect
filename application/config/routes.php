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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['jobs'] = 'Jobs/index';
$route['jobs/archived'] = 'Jobs/archived';
$route['jobs/get_jobs_by_ids'] = 'Jobs/get_jobs_by_ids';
$route['tracer'] = 'Tracer/index';
$route['tracer/submit'] = 'Tracer/submit';

// Employer Profile Routes
$route['employer_profile'] = 'EmployerProfile/index';
$route['employer_profile/(:any)'] = 'EmployerProfile/$1';
$route['employerprofile'] = 'EmployerProfile/index';
$route['employerprofile/(:any)'] = 'EmployerProfile/$1';

$route['adminlogin']            = 'AdminLogin/index';
$route['adminlogin/(:any)']     = 'AdminLogin/$1';

// Admin Page Visibility — URLs use all-lowercase
$route['adminpagevisibility']           = 'AdminPageVisibility/index';
$route['adminpagevisibility/(:any)']    = 'AdminPageVisibility/$1';

// These are used in views with lowercase
$route['adminalumni']           = 'AdminAlumni/index';
$route['adminalumni/(:any)']    = 'AdminAlumni/$1';

$route['postcontroller']        = 'PostController/index';
$route['postcontroller/(:any)'] = 'PostController/$1';

// AdminPageVisibility also redirects to 'admin/page_visibility' — fix:
$route['admin/page_visibility'] = 'AdminPageVisibility/index';