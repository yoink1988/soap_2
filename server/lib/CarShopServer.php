<?php
/**
 * Description of CarShopServer
 *
 * @author yoink
 */
class CarShopServer
{
	public $db;

	public function __construct()
	{
		$this->db = new Db();
	}

	public function getCarList()
	{

		$res = [];
		$res = $this->db->select()->setTable('cars')->setColumns('id, brand, model')->exec();
		if($res)
		{
			return $res;// returnim uje json
//			return $this->convertToJson($res);// returnim uje json
		}
		return $res;
	}

	public function getCarDetails($id)
	{
//		$id = $this->parseJson($id);
		$res = [];
		$id = $this->db->clearString($id);
		$res = $this->db->select()->setTable('cars')->setColumns('id, brand, model, year, motor, speed, color, price')->setWhere("id = $id")->exec();
		if($res)
		{
			return $res; //returnim uje json
		}
		return $res;
	}

	public function getCarsByParameters($arr)
	{
		//to do
		//proverka na prisutstvie goda v massive
		$res = [];
		$where = $this->makeWhereString($arr);
		$res = $this->db->select()->setTable('cars')->setColumns('id, brand, model, year, motor, speed, color, price')->setWhere($where)->exec();
		if($res)
		{
			return $res; //returnim uje json
		}
		return $res;
	}

	public function addOrder($arr)
	{
		$params = $this->clearArr($arr);
		if($this->db->insert()->setTable('orders')->setColumns('id_car, uname, ulastname, payment')->setParams($params)->exec())
		{
			return true; // msg success
		}
		return false; // msg unfortunately
	}

//	private function convertToJson(array $arr)
//	{
//		return json_encode($arr, JSON_NUMERIC_CHECK);
//	}
//
//	private function parseJson($string)
//	{
//		return json_decode($string, true);
//	}

	private function makeWhereString($arr)
	{
		$where = "year = {$this->db->clearString($arr['year'])}";


		if(!empty($arr['color']))
		{
			$where .= " and color = {$this->db->clearString($arr['color'])}";
		}
		if(!empty($arr['brand']))
		{
			$where .= " and brand = {$this->db->clearString($arr['brand'])}";
		}
		if(!empty($arr['model']))
		{
			$where .= " and model = {$this->db->clearString($arr['model'])}";
		}
		if(!empty($arr['motor']))
		{
			$where .= " and motor = {$this->db->clearString($arr['motor'])}";
		}
		if(!empty($arr['speed']))
		{
			$where .= " and speed = {$this->db->clearString($arr['speed'])}";
		}
		if(!empty($arr['price']))
		{
			$where .= " and price = {$this->db->clearString($arr['price'])}";
		}
		return $where;
	}

	private function clearArr($arr)
	{
		$cleared = [];
		foreach ($arr as $k => $param)
		{
			$cleared[$k] = $this->db->clearString($param);
		}
		return $cleared;
	}
}
