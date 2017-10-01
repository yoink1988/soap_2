<?php
include_once '/lib/config.php';
include_once '/lib/functions.php';

//ini_set('soap.wsdl_cache_ebabled','0');
$serv = new SoapServer('CarShop.wsdl');
$serv->setClass('CarShopServer');
$serv->handle();
?>
