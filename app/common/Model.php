<?php
/**
 * The Base Model, each Model will extend this Class
 * 
 * @author Raphael Wintrich
 *
 */
class Model extends Db
{
	public $id;
	
	/**
	 * At The Moment the constructor do nothing..
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * save() will save an Model to a scecific Collection
	 * this is only the first simple and stupid try ;) we have to increase the usability to store inner documents etc...
	 * 
	 * @param String $collection
	 */
	public function save($collection)
	{
		$this->insert($collection, $this->toMongo());
	}
}