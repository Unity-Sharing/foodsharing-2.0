<?php
/**
 * seperate Class only for the connection to MongoDB Server
 * it will be static to use the same connection everywhere
 * 
 * @author Raphael Wintrich
 *
 */
class DbConnect
{
	public static $client;
	public static $db;
	
	public static function connect()
	{
		try
		{
			self::$client = new MongoClient('mongodb://'.Conf::$DB_HOST, array(
				'db' => Conf::$DB
			));
			
			self::selectDb(Conf::$DB);
		
		}
		catch (Exception $e)
		{
			debug($e->getMessage());
		}
	}
	
	public static function selectDb($db)
	{
		self::$db = self::$client->$db;
	}
	
	public static function close()
	{
		@self::$client->close();
	}
}