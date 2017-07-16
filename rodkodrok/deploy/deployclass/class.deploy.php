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
		
		$descripter['name']="";
		$descripter['description']="";
		
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
			//chmod($foldertocheck, 0777);
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
		$instanceIniterSimul=new PratikInitersimul();
		
		$initersimuled=$instanceIniterSimul->initerConstruct($initercreated);
		
		return $initersimuled;
	}

	
	
	
	
	
	
	

}


?>