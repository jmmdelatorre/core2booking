<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['ticket/create']['get'] = 'TicketController/index';
$route['ticket/check']['POST'] = 'TicketController/check_schedule';
$route['ticket/check']['GET'] = 'TicketController/check_schedule';
$route['ticket/book/(:any)/(:any)']['get'] = 'TicketController/booking/$1/$2';

$route['ticket/lookup']['GET'] = 'TicketController/lookup';

$route['demographics/searchCity']['get'] = 'DemographicsController/searchCity';

$route['bus']['GET'] = 'backend/BusController/index';
$route['bus/save']['POST'] = 'backend/BusController/saveBus';

$route['terminal']['GET'] = 'backend/TerminalController/index';
$route['terminal/save']['POST'] = 'backend/TerminalController/saveterminal';

$route['schedule']['GET'] = 'backend/ScheduleController/index';
$route['schedule/add']['GET'] = 'backend/ScheduleController/view_schedule';
$route['schedule/save']['POST'] = 'backend/ScheduleController/saveschedule';

$route['login']['POST'] = 'backend/LoginController/user_login';