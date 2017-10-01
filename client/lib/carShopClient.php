<?php

/**
 * Description of carShopClient
 *
 * @author yoink
 */
class carShopClient
{
	public $client;

	public function __construct()
	{
		$this->client = new SoapClient(CARSHOP_WSDL);
	}

	public function getCarList()
	{
		$res = $this->client->__soapCall('getCarList', array());
		return $this->makeJsonCarlist($res->cars);
	}

	public function getCarDetails($id)
	{
		$res = $this->client->__soapCall('getCarDetails', array($id));
		return $this->makeJsonDetails($res);
	}

	public function getCarsByParameters($arr)
	{
		$res = $this->client->__soapCall('getCarsByParameters', $arr);
		return $this->makeJsonCarlist($res->cars);
	}

	public function addOrder($arr)
	{
		if($this->client->__soapCall('addOrder', $arr))
		{
			return true;
		}
		return false;
	}

	private function makeJsonCarlist(array $cars)
	{
		foreach($cars as $car)
		{
			$arr[] = (array)$car;
		}
		return json_encode($arr);
	}

	private function makeJsonDetails(stdClass $res)
	{
		foreach ($res->DetailsResponse->Struct as $k => $prop)
		{
			$arr[$k] = $prop;
		}
		return json_encode($arr);
	}
}