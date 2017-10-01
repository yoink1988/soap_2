<?php
include_once '/lib/config.php';
include_once '/lib/carShopClient.php';

//ini_set('soap.wsdl_cache_ebabled','0');

try
{
	if(isset($_POST['getAllCars']))
	{
		$cs = new carShopClient();
		$res = $cs->getCarList();
		echo $res;
	}
	if(isset($_POST['getDetails']))
	{
		$cs = new carShopClient();
		$res = $cs->getCarDetails($_POST['getDetails']);
		echo $res;
	}
	if(isset($_POST['order']))
	{
		$orderData = json_decode($_POST['order'], true);
		$cs = new carShopClient();
		if($cs->addOrder($orderData))
		{
			echo 'Order added';
		}
		else
		{
			echo 'Order not Added';
		}
	}
	if(isset($_POST['searchParams']))
	{
		$paramsData = json_decode($_POST['searchParams'], true);
		$cs = new carShopClient();
		$res = $cs->getCarsByParameters(array('searchParams' => $paramsData));
		echo $res;
	}
}
catch (\Exception $ex)
{
	echo "EXCEPTION: {$ex->getMessage()}";
}