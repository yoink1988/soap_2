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
//			return $res;
			$result = new \ArrayObject();
			foreach($res as $item)
			{
				$obj = new stdClass();
				$obj->id = $item['id'];
				$obj->brand = $item['brand'];
				$obj->model = $item['model'];
				$car = new \SoapVar($obj, SOAP_ENC_OBJECT, null, null, 'CarList');
				$result->append($car);
			}
			return $result;

		}
		return $res;
	}

	public function getCarDetails($id)
	{
		$res = [];
		$id = $this->db->clearString($id);
		$res = $this->db->select()->setTable('cars')->setColumns('model, year, motor, color, speed, price')->setWhere("id = $id")->exec();
//		'id, brand, model, year, motor, speed, color, price'
		if($res)
		{
//			return $res;
			$result = new \ArrayObject();
			foreach($res as $item)
			{
				$obj = new stdClass();
				$obj->model = $item['model'];
				$obj->year = $item['year'];
				$obj->motor = $item['motor'];
				$obj->color = $item['color'];
				$obj->speed = $item['speed'];
				$obj->price = $item['price'];
				$car = new \SoapVar($obj, SOAP_ENC_OBJECT, null, null, 'Details');
				$result->append($car);
			}
			return $result;
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
//			return $res;
			
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
