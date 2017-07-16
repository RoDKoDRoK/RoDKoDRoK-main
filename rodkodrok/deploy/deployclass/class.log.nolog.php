<?php

class LogNolog
{
	var $db;
	var $conf;
	
	
	function __construct($conf,$db=null)
	{
		//parent::__construct();
		$this->db=$db;
		$this->conf=$conf;
		
	}
	
	
	
	function pushtolog($line,$srcerror="RODError",$destname="")
	{
		
		
	}
	
	
	
}



?>