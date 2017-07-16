<?php

class Tp
{
	var $tpselected=null;
	
	
	function __construct($conf,$log,$zonetpl="")
	{
		//mode backoffice
		$moteur="";
		if(isset($conf['moteurtpl']))
			$moteur=$conf['moteurtpl'];
		if(isset($conf['moteurtpl'.$zonetpl]))
			$moteur=$conf['moteurtpl'.$zonetpl];
	
		//select moteur tpl
		$moteurlowercase=strtolower($moteur);
		$moteurclass=ucfirst($moteurlowercase);
		if(file_exists("deploy/deployclass/class.tp.".$moteurlowercase.".php"))
		{
			//include_once "integrate/driver/class.tp.".$moteurlowercase.".php";
			eval("\$this->tpselected=new Template".$moteurclass."();");
		}
		else
		{
			//include_once "integrate/driver/class.tp.smarty.php";
			$this->tpselected=new TemplateSmarty();
			//$log->pushtolog("Echec du chargement du driver template. Verifier la configuration ou votre driver.");
		}
	}
	
}



?>