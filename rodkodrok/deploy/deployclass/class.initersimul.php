<?php

class PratikInitersimul extends ClassIniter
{
	var $prepareiniter=true;
	
	function __construct($initer,$prepareiniter=true)
	{
		parent::__construct($initer);
		
		$this->prepareiniter=$prepareiniter;
		
	}
	
	
	function initerConstruct($initercreated=array())
	{
		//simulation d'un initer avec les paramètres get
		$initer=$initercreated;
		
		//clean old initer
		if($this->prepareiniter)
		{
			//SET INITER FIRST VAR
			$initer['conf']=array();
			$initer['db']=null;
			$initer['log']=null;
		}
		
		//CREATE INITER
		//get chain connector
		$chainconnector="none";

		//load chain connector
		if(file_exists("chain/connector.chain.default.php"))
		{
			include "chain/connector.chain.default.php";
			if(isset($firstchain) && file_exists("chain/connector.chain.".$firstchain.".php"))
			{
				include "chain/connector.chain.".$firstchain.".php";
				$chainconnector=$firstchain;
				//echo $firstchain;
			}
			else
				$chainconnector="default";
		}


		//charge chains dans tab
		$chemin_chain="chain";
		$loader=new Load();
		$chaintab=$loader->charg_chain_dans_tab($chemin_chain);
		//print_r($chaintab);


		//init initer
		$initer['chainconnector']=$chainconnector;
		$initer['loader']=$loader;
		$initer['chaintab']=$chaintab;

		//test chain ok
		if($chainconnector=="default" || $chainconnector=="none" || !isset($tabconnector))
			return $initer;
		
		//start connector	
		foreach($tabconnector as $connectorcour)
		{
			$connectorlowercase=strtolower($connectorcour['name']);
			$connectorclass=ucfirst($connectorlowercase);

			if(!file_exists("connector/connector.".$connectorlowercase.".php"))
				continue;
			
			include_once "connector/connector.".$connectorlowercase.".php";
			eval("\$instanceConnector=new Connector".$connectorclass."(\$initer);");
			
			eval("\$instanceConnector".$connectorclass."=\$instanceConnector;");
			
			
			//initinstance
			eval("\$instance".$connectorclass."=\$instanceConnector->initInstance();");
			
			//get modif du initer
			$initer=$instanceConnector->initer;
			
			//cas passage de class dans initer
			if(isset($connectorcour['classtoiniter']) && $connectorcour['classtoiniter'])
				eval("\$initer['instance".$connectorclass."']=\$instance".$connectorclass.";");
			
			$instanceConnector->reloadIniter($initer);
			
			
			//initvar
			${$connectorlowercase}=$instanceConnector->initVar();
			
			//get modif du initer
			$initer=$instanceConnector->initer;
			
			//cas passage de var dans initer
			if(isset($connectorcour['vartoiniter']) && $connectorcour['vartoiniter'])
				eval("\$initer['".$connectorlowercase."']=\$".$connectorlowercase.";");
			
			
			//cas set variable ou classe spéciale (conf, db, tpl, ...)
			if(isset($connectorcour['aliasiniter']) && $connectorcour['aliasiniter']!="none")
			{
				//class spéciale
				if(isset($connectorcour['classtoiniter']) && $connectorcour['classtoiniter'] && (!isset($connectorcour['vartoiniter']) || !$connectorcour['vartoiniter']))
				{
					eval("\$".$connectorcour['aliasiniter']."=\$instance".$connectorclass.";");
					eval("\$initer['".$connectorcour['aliasiniter']."']=\$instance".$connectorclass.";");
				}
				//variable spéciale (prioritaire pour variable, écrase la classe si var et class sont utilisés)
				if(isset($connectorcour['vartoiniter']) && $connectorcour['vartoiniter'])
				{
					eval("\$".$connectorcour['aliasiniter']."=\$".$connectorlowercase.";");
					eval("\$initer['".$connectorcour['aliasiniter']."']=\$".$connectorlowercase.";");
				}
			}
			//echo "</pre>";print_r($initer['instanceDroit']);echo "</pre>";
			
			//pre exec
			$instanceConnector->reloadIniter($initer);
			$instanceConnector->preexec();
			$initer=$instanceConnector->initer;
		}


		//post exec connector
		/*		
		foreach($tabconnector as $connectorcour)
		{
			$connectorlowercase=strtolower($connectorcour['name']);
			$connectorclass=ucfirst($connectorlowercase);
			
			if(!file_exists("connector/connector.".$connectorlowercase.".php"))
				continue;
			
			eval("\$instanceConnector=\$instanceConnector".$connectorclass.";");
			//$instanceConnector->initer=$initer;
			$instanceConnector->reloadIniter($initer);
			$instanceConnector->postexec();
			$initer=$instanceConnector->initer;
			
		}
		*/
		//...CREATE INITER
		
		$initercreated=$initer;
		
		return $initercreated;
	}


	
}


?>