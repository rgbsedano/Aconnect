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
// Case-insensitive routes for controllers with CamelCase filenames
$route['postcontroller'] = 'PostController/index';
$route['postcontroller/(:any)'] = 'PostController/$1';
$route['adminactivitylog'] = 'AdminActivityLog/index';
$route['adminactivitylog/(:any)'] = 'AdminActivityLog/$1';
$route['adminalumni'] = 'AdminAlumni/index';
$route['adminalumni/(:any)'] = 'AdminAlumni/$1';
$route['admindashboard'] = 'AdminDashboard/index';
$route['admindashboard/(:any)'] = 'AdminDashboard/$1';
$route['adminevents'] = 'AdminEvents/index';
$route['adminevents/(:any)'] = 'AdminEvents/$1';
$route['adminjobposting'] = 'AdminJobPosting/index';
$route['adminjobposting/(:any)'] = 'AdminJobPosting/$1';
$route['adminlogin'] = 'AdminLogin/index';
$route['adminlogin/(:any)'] = 'AdminLogin/$1';
$route['adminmanageaccounts'] = 'AdminManageAccounts/index';
$route['adminmanageaccounts/(:any)'] = 'AdminManageAccounts/$1';
$route['adminofficers'] = 'AdminOfficers/index';
$route['adminofficers/(:any)'] = 'AdminOfficers/$1';
$route['adminpagevisibility'] = 'AdminPageVisibility/index';
$route['adminpagevisibility/(:any)'] = 'AdminPageVisibility/$1';
$route['adminpost'] = 'AdminPost/index';
$route['adminpost/(:any)'] = 'AdminPost/$1';
$route['adminreports'] = 'AdminReports/index';
$route['adminreports/(:any)'] = 'AdminReports/$1';
$route['adminsupport'] = 'AdminSupport/index';
$route['adminsupport/(:any)'] = 'AdminSupport/$1';
$route['employerprofile'] = 'EmployerProfile/index';
$route['employerprofile/(:any)'] = 'EmployerProfile/$1';
$route['employmentcontroller'] = 'EmploymentController/index';
$route['employmentcontroller/(:any)'] = 'EmploymentController/$1';
$route['eventsprevious'] = 'EventsPrevious/index';
$route['eventsprevious/(:any)'] = 'EventsPrevious/$1';
$route['forumaitest'] = 'ForumAiTest/index';
$route['forumaitest/(:any)'] = 'ForumAiTest/$1';
$route['ratelimitertest'] = 'RateLimiterTest/index';
$route['ratelimitertest/(:any)'] = 'RateLimiterTest/$1';
$route['rbac_controller_example'] = 'RBAC_Controller_Example/index';
$route['rbac_controller_example/(:any)'] = 'RBAC_Controller_Example/$1';

$route['tracer'] = 'Tracer/index';
$route['tracer/submit'] = 'Tracer/submit';

// Employer Profile Routes
$route['employer_profile'] = 'EmployerProfile/index';
$route['employer_profile/(:any)'] = 'EmployerProfile/$1';