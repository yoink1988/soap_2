<?php
class Db extends Sql
{
    public $pdo;
    public function __construct()
    {
    $pdoOpts = MYSQL_HOST;
    $user = MYSQL_USER;
    $pass = MYSQL_PASS;
    $this->pdo = new PDO($pdoOpts,$user,$pass);
    }
	
	public function clearString($string)
	{
		return $this->pdo->quote($string);
	}

	public function exec()
	{
		parent::exec();
		dump($this->query);
//			exit();
		switch ($this->queryType)
		{
			case 'insert':
				if($this->pdo->exec($this->query))
				{
					return true;
				}
				return false;

			case 'update':
				if($this->pdo->exec($this->query))
				{
					return true;
				}
				return talse;
            case 'select':
                $result = array();
				$stmt = $this->pdo->query($this->query);
				while($res = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$result[]=$res;
				}
				return $result;

			case 'delete':
				if($this->pdo->exec($this->query))
				{
					return true;
				}
				else
				{
					return false;
				}
		}
    }
}
