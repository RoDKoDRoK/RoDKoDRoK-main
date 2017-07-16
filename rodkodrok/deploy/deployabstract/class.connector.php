<?php


class Connector extends ClassIniter
{
	var $instance;
	
	var $chemintpl=""; //uniquement cas include de subtpl pour toprint
	

	function __construct($initer=array())
	{
		parent::__construct($initer);
	}


	function initInstance()
	{
		return null;
	}
	
	function initVar()
	{
		return null;
	}

	function preexec()
	{
		return null;
	}

	function postexec()
	{
		return null;
	}

	function end()
	{
		return null;
	}
	
	
	
	
	function setInstance($instance)
	{
		$this->instance=$instance;
	}

	function getInstance()
	{
		return $this->instance;
	}

}



?>
