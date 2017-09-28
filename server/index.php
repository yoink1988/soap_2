<?php
	include_once '/lib/config.php';
	include_once '/lib/functions.php';
	$h = new CarShopServer();

//	 brand, model, year, motor, speed, color, price'

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

	$order = array(
		'id_car' => '2',
		'uname' => 'Valerka',
		'ulastname' => 'Pupkin',
		'payment' => 'cash',
	);
	$order2 = ['2', 'Valera', 'Pupin', 'cash'];

	$h->addOrder($order);
//	$res = $h->getCarsByParameters($params);
//	dump($res);

	$id = '3';
	$res = $h->getCarDetails($encoded);
	dump($res);

?>
