<?php

class Instanciator
{	
	
	function __construct()
	{
		//parent::__construct();
		
	}
	
	
	
	function newInstance($classname="",$initer=array())
	{
		//check data
		if($classname=="")
		{
			//putolog... test if log exists before !!!
			return null;
		}
			
		//prepare data
		//$classname=strtolower($classname);
		$classname=ucfirst($classname);
		
		//check data
		if(!class_exists($classname))
		{
			//putolog... test if log exists before !!!
			return null;
		}
		
		//new instance
		eval("\$instance=new ".$classname."(\$initer);");
		
		//check new instance ok with initer parameters
		if($this->checkIniterPrerequis($instance))
			return $instance;
		
		//cas prerequis manquant
		//putolog... test if log exists before !!!
		return null;
	}
	
	
	
	
	function checkIniterPrerequis($instance)
	{
		$tabiniterprerequis=$instance->getIniterPrerequis();
		
		//cas pas de prerequis
		if($tabiniterprerequis=="")
			return true;
		
		if(is_array($tabiniterprerequis) && count($tabiniterprerequis)<=0)
			return true;
		
		//check prerequis
		foreach($tabiniterprerequis as $initerprerequiscour)
		{
			if(!isset($instance->{$initerprerequiscour}) || $instance->{$initerprerequiscour}==null)
				return false;
		}
		
		return true;
	}
	
	
}



?>