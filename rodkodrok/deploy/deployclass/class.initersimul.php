<?php

class PratikInitersimul extends ClassIniter
{
	var $prepareiniter=true;
	
	function __construct($initer=array(),$prepareiniter=true)
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
		//load ark
		$tab_chemin_ark=array("deploy/deployark","core/src/ark");
		foreach($tab_chemin_ark as $chemin_ark)
		{
			if(!file_exists($chemin_ark."/arkchain.php"))
				continue;
			
			include $chemin_ark."/arkchain.php";
			for($i=1;$i<=20;$i++)
				if(file_exists($chemin_ark."/arkchain.".$i.".php"))
					include $chemin_ark."/arkchain.".$i.".php";
			if(isset($arkchain) && count($arkchain)>0)
				foreach($arkchain as $arkcour)
				{
					//prepare data
					if(isset($arkcour['file']))
						$arkcour['file']=strtolower($arkcour['file']);
					else
						continue;
					
					if(isset($arkcour['class']))
						$arkcour['class']=strtolower($arkcour['class']);
					else
						$arkcour['class']=strtolower($arkcour['file']);
					$arkcour['class']=ucfirst($arkcour['class']);
					
					if(!isset($arkcour['makevar']))
						$arkcour['makevar']=false;
					
					if(isset($arkcour['var']))
						$arkcour['var']=strtolower($arkcour['var']);
					else
						$arkcour['var']=strtolower($arkcour['file']);
					
					
					//load an ark
					if(file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
					{
						//include_once $chemin_ark."/class.".$arkcour['file'].".php";
						if($arkcour['makevar'])
							eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
					}
				}
		}
		
		
		//get chain connector
		$chainconnector="none";

		//load chain connector
		if(file_exists($arkitect->get("chain")."/connector.chain.default.php"))
		{
			include $arkitect->get("chain")."/connector.chain.default.php";
			if(isset($firstchain) && file_exists($arkitect->get("chain")."/connector.chain.".$firstchain.".php"))
			{
				include $arkitect->get("chain")."/connector.chain.".$firstchain.".php";
				$chainconnector=$firstchain;
				//echo $firstchain;
			}
			else
				$chainconnector="default";
		}
		
		
		//charge chains dans tab
		$chemin_chain=$arkitect->get("chain");
		$chaintab=$loader->charg_chain_dans_tab($chemin_chain);
		//print_r($chaintab);


		//init initer
		$initer['simul']="on";
		$initer['chainconnector']=$chainconnector;
		$initer['chaintab']=$chaintab;
		
		//init initer with ark
		if(isset($arkchain) && count($arkchain)>0)
			foreach($arkchain as $arkcour)
			{
				if(isset($arkcour['var']))
					$arkcour['var']=strtolower($arkcour['var']);
				else
					$arkcour['var']=strtolower($arkcour['file']);
				
				if(!isset($arkcour['makevar']))
					$arkcour['makevar']=false;
				
				if($arkcour['makevar'])
					$initer[$arkcour['var']]=${$arkcour['var']};
			}
		
		//test chain ok
		if($chainconnector=="default" || $chainconnector=="none" || !isset($tabconnector))
			return $initer;
		
		//start connector	
		foreach($tabconnector as $connectorcour)
		{
			$connectorlowercase=strtolower($connectorcour['name']);
			$connectorclass=ucfirst($connectorlowercase);

			if(!file_exists($arkitect->get("connector")."/connector.".$connectorlowercase.".php"))
				continue;
			
			include_once $arkitect->get("connector")."/connector.".$connectorlowercase.".php";
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