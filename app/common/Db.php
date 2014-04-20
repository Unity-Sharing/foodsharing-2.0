<?php
/**
 * Db is the base Class for all Models and Database Classes
 * here you find the direct communication between php and the MongoDB Server
 * We will have the base methods in here (get data, save data, list objects etc.)
 * 
 * @author Raphael Wintrich
 *
 */
class Db
{
	public $db;
	
	/**
	 * The constructor has to be called on time to initiate the connection to the MongoDb Server
	 */
	public function __construct()
	{
		$this->db = DbConnect::$db;
	}

	public function q($collection,$query,$fields = array())
	{
		try
		{
			if($cursor = $this->db->$collection->find($query,$fields))
			{
				if(count($cursor) > 0)
				{
					$out = array();
					foreach ($cursor as $doc)
					{
						$out[$doc['_id']->{'$id'}] = $doc;
						$out[$doc['_id']->{'$id'}]['id'] = $doc['_id']->{'$id'};
					}
					return $out;
				}
			}
		}
		catch (Exception $e)
		{
			return false;
		}
		return false;
	}

	public function qOne($collection,$query,$field)
	{
		try {
			if($doc = $this->db->$collection->findOne($query,array($field)))
			{
				return $doc[$field];
			}
	
		}
		catch (Exception $e)
		{
			return false;
		}
		return false;
	}
	
	public function qCol($collection,$query,$field)
	{
		if( $cursor = $this->db->$collection->find($query,array($field)) )
		{
			$out = array();
			foreach ($cursor as $doc)
			{
				if(isset($doc[$field]))
				{
					$out[] = $doc[$field];
				}
			}
				
			if(count($out) > 0)
			{
				return $out;
			}
		}
		return false;
	}
	
	public function qUri($collection,$uri,$fields = array())
	{
		try {
			if($doc = $this->db->$collection->findOne(array('uri' => $uri),$fields))
			{
				$doc['id'] = $doc['_id']->{'$id'};
				return $doc;
			}
		}
		catch (Exception $e)
		{
			T::debug($e);
			return false;
		}
		return false;
	}
	
	public function freeUri($collection,$value,$prefix = false, $field = 'uri')
	{
		$uriname = T::cleanUriName($value);
		
		if($prefix !== false && !empty($prefix))
		{
			$uriname = T::cleanUriName($prefix).'/'.$uriname;
		}
		
		$tmp = $uriname;
		$i=0;
		$safe = 1000;
		
		while ($this->exists($collection, $field, $tmp))
		{
			$safe--;
			$i++;
			$tmp = $uriname.'-'.$i;
			if($safe <= 0)
			{
				return false;
				break;
			}
		}
		
		if(!empty($tmp))
		{
			return $tmp;
		}
		return false;
	}
	
	public function exists($collection,$field,$value)
	{
		$check = false;
		try
		{
			$col = $this->db->$collection->find(array($field=>$value));
			foreach ($col as $c)
			{
				$check = true;
			}

			return $check;
		}
		catch (Exception $e)
		{
			return false;
		}
		return false;
	}
	
	public function docExists($collection,$id)
	{
		try {
			if($doc = $this->db->$collection->findOne(array('_id' => new MongoId($id)),array('_id')))
			{
				return true;
			}
		}
		catch (Exception $e)
		{
			T::debug($e);
			return false;
		}
		return false;
	}
	
	public function update($collection,$id,$doc)
	{	
		try 
		{
			$this->db->$collection->update(
				array('_id' => new MongoId($id)),
				array('$set' => $doc)
			);
			return true;
		}
		catch (Exception $e)
		{
			T::debug($e);
			return false;
		}
		
	}
	
	public function insert($collection,$data,$safe = true)
	{
		try {
			$this->db->$collection->insert($data,array('safe' => $safe));
			return $data['_id'];
		}
		catch (Exception $e)
		{
			T::debug($e);
		}
		return false;
	}
	
	public function delete($collection,$id)
	{
		try {
			return $this->db->$collection->remove(array('_id' => new MongoId($id)), array('justOne' => true));
		}
		catch(Exception $e)
		{
			T::debug($e);
		}
		return false;
	}
}
