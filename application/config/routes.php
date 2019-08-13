<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['login'] = 'login/index';
$route['home'] = 'home/index';
$route['inventory'] = 'inventory/index';
$route['admin'] = 'admin/index';
$route['activity'] = 'activity/index';
$route['about'] = 'about/index';
$route['register'] = 'register/index';
$route['forgot'] = 'forgot/index';
$route['users'] = 'users/index';
$route['api/login']['post'] = 'user/login';
$route['api/register']['post'] = 'user/register';

$route['api/users']['get'] = 'user';
$route['api/users/(:any)']['get'] = 'user/detail/$1';
$route['api/users']['post'] = 'user/create';
$route['api/users/(:any)']['put'] = 'user/update/$1';
$route['api/users/(:any)']['delete'] = 'user/delete/$1';
$route['api/users/zone/(:any)']['get'] = 'user/getUsersByZone/$1';
$route['api/users/userstatus']['post'] = 'user/updateuserstatus';
$route['api/users/userstatus/(:num)']['get'] = 'user/userByStatus/$1';
$route['api/users/userstatus/name/(:any)']['get'] = 'user/userByStatusByName/$1';
$route['api/users/verifyotp'] = "user/verifyOtp";
$route['api/users/setpass']["post"] = "user/setPassword";
$route['api/users/forgotpass/(:any)']['get'] = "user/forgotpass/$1";

$route['api/zones']['get'] = 'user/zones';
$route['api/zones/(:any)']['get'] = 'user/zoneDetail/$1';
$route['api/zones/countries']['get'] = 'user/zones';
$route['api/zones/countries/(:any)']['get'] = 'user/zoneByCountry/$1';
$route['api/zones/volunteer/recdon']['get'] = 'user/getAllRecdonZones';
$route['api/zones/volunteer/getdon']['get'] = 'user/getAllGetdonZones';
$route['api/zones/volunteer/recdon/(:any)']['get'] = 'user/getRecdonZones/$1';
$route['api/zones/volunteer/getdon/(:any)']['get'] = 'user/getGetdonZones/$1';


$route['api/inventory']['get'] = 'inventory/all';
$route['api/inventory/addnewitem']['post'] = 'inventory/addItemToInventory';
$route['api/inventory/(:any)']['get'] = 'inventory/index/$1';

$route['api/medicine/getmedicine']['get'] = 'medicine/getAllMedicine';
$route['api/medicine/getmedicine/(:any)']['get'] = 'medicine/getMedicine/$1';
$route['api/medicine/addmedicine']= 'medicine/addNewMedicine';

$route['api/donor/getdonordetails']['get'] = 'donor/getAllDonorDetails';
$route['api/donor/getdonordetails/(:any)']['get'] = 'donor/getDonorDetails/$1';
$route['api/donor/adddonordetails']['post'] = 'donor/addDonorDetails';

$route['api/makeabox/addbox']['post'] = 'box/addBox';
$route['api/makeabox/addboxcontent']['post'] = 'box/addBoxContent';
$route['api/makeabox/getboxbyzone/(:any)']['get'] = 'box/getAllBoxesByZone/$1';
$route['api/makeabox/getactiveboxbyzone/(:any)']['get'] = 'box/getAllActiveBoxesByZone/$1';

$route['api/makeabox/removeboxcontent']['post'] = 'box/removeBoxContent';
$route['api/makeabox/removeboxcontents']['post'] = 'box/removeBoxContents';
$route['api/makeabox/removebox']['post'] = 'box/removeBox';
$route['api/makeabox/editbox']['post'] = 'box/editBox';


$route['api/getdoninventory/(:any)']['get'] = 'inventory/getdonIndex/$1';
$route['api/orders']["post"] = 'orders/placeOrder';
$route['api/box']['post'] = 'shipment/placeShipmentOrder';
$route['api/box/shipments']['post'] = "shipment/getZoneShipments";
$route['api/box/shipments/medicine']['post'] = "shipment/getBoxContent";
$route['api/getdoninventory']['post'] = 'getdonInventory/addNewItemToInventory';
$route['api/orders']['get'] = 'recdon/allPatients';
$route['api/orders/(:any)']['get'] = 'recdon/patientDetails/$1';
$route['api/requests/getrequestbyzone/(:any)']['get'] = 'recdon/getRequestsfromZone/$1';
$route['api/requests/requestsbyaccepteduser/(:any)']['get'] = 'request/getAcceptedRequestAcceptedByUser/$1';
$route['api/requests/acceptrequest']['post'] = 'request/acceptRequest';
$route['api/requests/rejectrequest']['post'] = 'request/rejectRequest';
$route['api/requests/changerequeststatus']['post'] = 'request/changeRequestStatus';
$route['api/requests/getrequestbyid/(:any)']['get'] = 'request/getRequestById/$1';


$route['default_controller'] = 'login/index';
$route['(:any)']='pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;