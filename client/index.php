<?php
	ini_set('soap.wsdl_cache_ebabled','0');
$client = new SoapClient('http://localhost/public_html/MYPHP/soap2/server/CarShop.wsdl');

var_dump($client->__getFunctions());

echo '<pre>';
$res = $client->getCarList();
var_dump($res);

