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
		$res = $this->db->select()->setTable('cars')->setColumns('id, brand, model')->exec();
		if(!empty($res))
		{
			$result = new \stdClass();
			foreach($res as $item)
			{
				$car = new \SoapVar((object)$item, SOAP_ENC_OBJECT, null, null, 'CarList');
				$result->cars[] = $car;
			}
		}
		else
		{
			throw new SoapFault('Server','Sorry, try again later');
		}
		return $result;
	}

	public function getCarDetails($id)
	{
		$id = $this->db->clearString($id);
		$res = $this->db->select()->setTable('cars')->setColumns('id, model, year, motor, color, speed, price')->setWhere("id = $id")->exec();
		if($res)
		{
			$result = new \stdClass();
			foreach($res as $item)
			{
				$propery = new \SoapVar((object)$item, SOAP_ENC_OBJECT, null, null);
				$result->DetailsResponse[] = $propery;
			}
		}
		else
		{
			throw new SoapFault('Server','Car not found');
		}
		return $result;
	}

	public function getCarsByParameters(stdClass $arr)
	{
		$where = $this->makeWhereString((array)$arr);
		$res = $this->db->select()->setTable('cars')->setColumns('id, brand, model, year, motor, speed, color, price')->setWhere($where)->exec();
		if($res)
		{
			$result = new \StdClass();
			foreach($res as $item)
			{
				$car = new \SoapVar((object)$item, SOAP_ENC_OBJECT, null, null, 'car');
				$result->cars[] = $car;
			}
		}
		else
		{
			throw new SoapFault('Server', 'No cars found with this parametres');
		}
		return $result;
	}

	public function addOrder($arr)
	{
		if(($arr->payment != 'cash') && ($arr->payment != 'creditCard'))
		{
			throw new SoapFault('Server', 'Payment type should be "cash" or "creditCard".');
		}
		$params = $this->clearArr((array)$arr);
		if($this->db->insert()->setTable('orders')->setColumns('id_car, uname, ulastname, payment')->setParams($params)->exec())
		{
			return true; 
		}
		return false; 
	}

	private function makeWhereString($arr)
	{
		$where = "year = {$this->db->clearString($arr['year'])}";
		if(!empty($arr['color']))
		{
			$where .= " and color = {$this->db->clearString($arr['color'])}";
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
