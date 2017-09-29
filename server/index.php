<?php
	include_once '/lib/config.php';
	include_once '/lib/functions.php';

//$h = new CarShopServer();

//	$res = $h->getCarList();
//	$res = $h->getCarDetails('2');
	$params = array(
//		'brand' => 'bmw',
//		'model' => 'x4',
		'year' => '2010',
//		'motor' => '3.2',
//		'speed' => '260',
//		'color' => 'black',
//		'price' => '22363.3'
	);

//	dump($res);
	$order = array(
		'id_car' => '2',
		'uname' => 'Valerka',
		'ulastname' => 'Pupkin',
		'payment' => 'cash',
	);
	$order2 = ['2', 'Valera', 'Pupin', 'cash'];

	ini_set('soap.wsdl_cache_ebabled','0');


$serv = new SoapServer('CarShop.wsdl');
$serv->setClass('CarShopServer');
$serv->handle();



?>
