<?php
/**
 * static handled Class for session handling,
 * this is at the moment just da dummy, we have a look how would our user model look like...
 * 
 * @author Raphael Wintrich
 */
class S
{
	public static function init()
	{
		fSession::setPath('../tmp/session');
		fSession::setLength('60 minutes', '1 week');
		fSession::enablePersistence();
		
		fAuthorization::setAuthLevels(
			array(
				'admin' => 100,
				'user'  => 60,
				'user_noauth'  => 50,
				'guest' => 25
			)
		);
		
		fSession::open();
	}
	
	public static function initMessages()
	{
		$msg = fSession::get('g_message',array());
		foreach ($msg as $type => $list)
		{
			foreach ($list as $l)
			{
				$t = '';
				if($l['title'] !== null)
				{
					$t = ",'".$l['title']."'";
				}
				addJs($type.'(\''.T::jsSafe($l['msg']).'\''.$t.');');
			}
		}
		S::set('g_message', array());
	}
	
	public static function setAuthLevel($role)
	{
		fAuthorization::setLoginPage('/user/login');
		fAuthorization::setUserAuthLevel($role);
		fAuthorization::setUserACLs(
			array(
				'posts'  => array('*'),
				'users'  => array('add', 'edit', 'delete'),
				'groups' => array('add'),
				'*'      => array('list')
			)
		);
	}
	
	public static function logout()
	{
		S::set('user', false);
		fAuthorization::destroyUserInfo();
		S::setAuthLevel('guest');
	}
	
	public static function login($user)
	{
		if(isset($user['id']) && !empty($user['id']) && isset($user['role']))
		{
			fAuthorization::setUserToken($user['id']);
			S::setAuthLevel($user['role']);
			
			if(isset($user['location_coords']) && (int)$user['location_coords'][0] != 0 && (int)$user['location_coords'][1] != 0)
			{
				S::set('g_location', $user['location_coords']);
				S::set('g_location_city', $user['location_city']);
				S::set('g_location_zip', $user['location_zip']);
			}
			
			S::set('user', array(
				'name' => $user['name']
			));
			
			return true;
		}
		return false;
	}
	
	public static function user($index)
	{
		$user = S::get('user');
		return $user[$index];
	}
	
	public static function id()
	{
		return fAuthorization::getUserToken();
	}
	
	public static function may($role = 'user')
	{
		if (fAuthorization::checkAuthLevel($role)) {
			return true;
		}
		return false;
	}
	
	public static function getLocation()
	{
		return fSession::get('g_location',false);
	}
	
	public static function set($key,$value)
	{
		fSession::set($key, $value);
	}
	
	public static function get($var)
	{
		return fSession::get($var,false);
	}
	
	public static function addMsg($message,$type,$title = null)
	{
		$msg = fSession::get('g_message',array());
		
		if(!isset($msg[$type]))
		{
			$msg[$type] = array();
		}
		
		if(!$title)
		{
			$title = ' '.s($type);
		}
		else
		{
			$title = ' ';
		}
		
		$msg[$type][] = array('msg'=>$message,'title'=>$title);
		fSession::set('g_message', $msg);
	}
}