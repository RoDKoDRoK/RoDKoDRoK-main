<?php

class Deploy
{
	var $conflictresolution="force";
	var $tabpackagetodeploy=array();
	
	var $log;
	
	function __construct($tabpackagetodeploy=array(),$conflictresolution="force")
	{
		$this->tabpackagetodeploy=$tabpackagetodeploy;
		$this->conflictresolution=$conflictresolution;
		
	}
	
	
	function getDeployContent($deploypage="")
	{
		$returned="";
		switch($deploypage)
		{
			case "startdeploy" : $returned.=$this->deployPageStartDeploy(); break;
			case "downloadstep" : $returned.=$this->deployPageDownloadStep(); break;
			case "deployment" : $returned.=$this->deployPageDeployment(); break;
		
			default:
					$returned.=$this->deployPageDescripter($deploypage);
				break;
		}
	
		return $returned;
	}
	
	
	
	
	function getDeployForm($deploypage="")
	{
		$returned="";
		switch($deploypage)
		{
			case "startdeploy" : $returned.="downloadstep"; break;
			case "downloadstep" : $returned.=$this->tabpackagetodeploy[0]['name']; break;
			case "deployment" : $this->setSession(); $returned.=""; break;
		
			default:
					$this->setSession();
					$returned=$this->form_loader($deploypage);
				break;
		}
	
		return $returned;
	}
	
	
	
	function setSession()
	{
		if(isset($_POST['confform']))
		{
			if(isset($_SESSION['confform']))
				$_SESSION['confform']=array_merge($_SESSION['confform'],$_POST['confform']);
			else
				$_SESSION['confform']=$_POST['confform'];
		}
	}
	
	
	
	function form_loader($deploypage)
	{
		$form="";
		
		$packagecodename=$deploypage;
		
		//prepare form with pratikpackage
		//$this->includer->include_pratikclass("Package");
		$instancePackage=new PratikPackage();
		$preform=$instancePackage->preparePackageConfForm($packagecodename);
		
		//construct form
		//$this->includer->include_pratikclass("Form");
		$initer['log']=$this->log;
		$instanceForm=new PratikForm($initer);
		$tabparam['codename']=$packagecodename;
		$form=$instanceForm->formconverter($preform,$tabparam);
		
	
		return $form;
	}
	
	
	
	
	
	function deployPageStartDeploy()
	{
		$returned="";
	
		$returned.="Start RoDKoDRoK...";
		$returned.="<br /><br />";
	
		return $returned;
	}
	
	function deployPageDownloadStep()
	{
		$returned="";
	
		$returned.="Donwloading all needed packages from RoDKoDRoK...";
		$returned.="<br /><br />";
		$returned.="<div id='loadingbar'><div id='loadedbar'></div></div>";
		$returned.="<br />";
		$returned.="<div id='ajaxresults'></div>";
		$returned.="<br />";
		$returned.="<div id='ajaxerrors'></div>";
		
		$returned.="<script>disableButtonToContinue();</script>";
		
		foreach($this->tabpackagetodeploy as $packagetodeploy)
			$returned.="<script>nbPackagesToLoad++;</script>";
			
		foreach($this->tabpackagetodeploy as $packagetodeploy)
			$returned.="<script>downloadPackage('".$packagetodeploy['name']."');</script>";
	
		return $returned;
	}
	
	function deployPageDescripter($deploypage)
	{
		$returned="";
		
		if(file_exists("package/".$deploypage."/package.descripter.php"))
			include_once "package/".$deploypage."/package.descripter.php";
		
		$returned.=$descripter['name'];
		$returned.="<br /><br />";
		$returned.=$descripter['description'];
		$returned.="<br /><br />";
	
		return $returned;
	}
	
	
	function deployPageDeployment()
	{
		//test config déjà existante
		if(file_exists("chain/connector.chain.default.php"))
			return "Already installed site !!!";
		
		//check first folder access
		$tabfoldertocheck=array();
		$tabfoldertocheck[]="chain";
		$tabfoldertocheck[]="connector";
		$tabfoldertocheck[]="core";
		$tabfoldertocheck[]="package";
		foreach($tabfoldertocheck as $foldertocheck)
		{
			if(!file_exists($foldertocheck) && !is_dir($foldertocheck))
				mkdir($foldertocheck,0777,true);
			chmod($foldertocheck, 0777);
		}
		
		//deploy des packages du site
		$content="";
		
		$content.="<div id='loadingbar'><div id='loadedbar'></div></div>";
		$content.="<br />";
		
		$content.="<div id='enddeploymentmessage'>Your site is online. Go to home page : <a href='index.php?page=home'>Home</a></div>";
		$content.="<br />";
		
		$content.="<div id='ajaxerrors'></div>";
		$content.="<br />";
		$content.="<div id='ajaxresults'></div>";
		
		
		$content.="<script>displayNoneEndMessage();</script>";
		
		foreach($this->tabpackagetodeploy as $packagetodeploy)
			$content.="<script>tabPackagesToDeployInOrder[nbPackagesToDeploy]='".$packagetodeploy['name']."';nbPackagesToDeploy++;</script>";
		
		//IMPORT PACKAGES
		$content.="<script>if(isset(tabPackagesToDeployInOrder[0])) deployPackage(tabPackagesToDeployInOrder[0]);</script>";
		
		
		return $content;
	}
	
	
	
	
	function initerConstruct($initercreated=array())
	{
		//simulation d'un initer avec les paramètres get
		$initer=$initercreated;
		
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
			eval("\$instance".$connectorclass."=\$instanceConnector->initInstance();");
			${$connectorlowercase}=$instanceConnector->initVar();
			
			//get modif du initer
			$initer=$instanceConnector->initer;
			
			//cas passage de class dans initer
			if(isset($connectorcour['classtoiniter']) && $connectorcour['classtoiniter'])
				eval("\$initer['instance".$connectorclass."']=\$instance".$connectorclass.";");
			
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