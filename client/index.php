<?php
	ini_set('soap.wsdl_cache_ebabled','0');
$client = new SoapClient('http://localhost/public_html/MYPHP/soap2/server/CarShop.wsdl');

var_dump($client->__getFunctions());

echo '<pre>';


	$params = array(
//		'brand' => 'bmw',
//		'model' => 'x4',
		'year' => '2010',
//		'motor' => '3.2',
//		'speed' => '260',
//		'color' => 'black',
//		'price' => '22363.3'
	);


//$res = $client->getCarList();
//$res = $client->getCarDetails('1');
$res = $client->getCarsByParameters($params);
var_dump($res);

