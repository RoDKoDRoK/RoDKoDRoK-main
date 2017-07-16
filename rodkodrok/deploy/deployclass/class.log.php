<?php

class Log
{

	var $logselected=null;
	
	
	function __construct($conf,$db=null)
	{
		//select moteur tpl
		$moteurlowercase="";
		if(isset($conf['moteurlog']))
			$moteurlowercase=strtolower($conf['moteurlog']);
		$moteurclass=ucfirst($moteurlowercase);
		if(file_exists("deploy/deployclass/class.log.".$moteurlowercase.".php"))
		{
			//include_once "integrate/driver/class.log.".$moteurlowercase.".php";
			eval("\$this->logselected=new Log".$moteurclass."(\$conf,\$db);");
		}
		else
		{
			//include_once "integrate/driver/class.log.nolog.php";
			$this->logselected=new LogNolog($conf,$db);
			$this->logselected->pushtolog("Echec du chargement du driver template. Verifier la configuration ou votre driver.");
		}
	}

	
	
	
}



?>