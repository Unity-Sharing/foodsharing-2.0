<?php

/**
 * Tiny static helper class for benchmarking
 * 
 * @author Raphael Wintrich
 *
 */
$cur = microtime();

class Benchmark
{
	private static $start_time;
	private static $results;
	private static $duration_complete;
	
	public static function init()
	{
		self::$start_time = microtime();
		
		if(!is_array(self::$results))
		{
			self::$results = array();
			self::$duration_complete = microtime();
		}
	}
	
	public static function out($name)
	{
		self::$results[] = array(
			'name' => $name,
			'result' => (microtime() - self::$start_time)
		);
		self::init();
	}
	
	public static function result()
	{
		self::$duration_complete = microtime()-self::$duration_complete;
		
		echo '<div style="color:#FFF;z-index:5000;position:absolute;top:10px;left:50%;margin-left:-150px;width:300px;background:black;padding:15px;">';
		foreach (self::$results as $r)
		{
			echo '
				<p><strong>'.$r['name'].'</strong></p>
				<p>
					Duration: <strong>'.round($r['result'],4).'</strong> ms ('.round(self::percent($r['result']),2).' %)
				</p>
				<hr />';
		}
		
		echo '<hr />Duration Complete: '.self::$duration_complete;
		
		echo '</div>';
	}
	
	private static function percent($time)
	{
		return 100 / (self::$duration_complete / $time);
	}
}