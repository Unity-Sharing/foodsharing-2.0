<?php
/**
 * First very simple Script to install our Application
 */

// needed folders
$folders = array(
	'../tmp' => array // all the temporary stuff
	(
		'permissions' => '775'
	), 
	'../tmp/imagemagick' => array // imagemagick processing cache
	(
		'permissions' => '775'
	), 
	'../tmp/session' => array // session files
	(
		'permissions' => '775'
	), 
	'./img' => array // puplic uploaded images
	(
		'permissions' => '775'
	) 
);

/*
 * Try to create all the folders if they dont exists
 */
foreach ($folders as $folder => $option)
{
	$option = array_merge(array(
		'permissions' => '775'
	),$option);
	
	@mkdir($folder);
	@chmod($folder, $option['permissions']);
	
	if(!is_dir($folder))
	{
		error('cant create '.$folder);
	}
}



function error($msg)
{
	echo $msg.'<br>'; 
}
