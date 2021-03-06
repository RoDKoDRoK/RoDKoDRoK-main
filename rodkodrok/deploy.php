<?php

session_start();

//to kill en mode prod
ini_set('display_errors', 1);
//error_reporting(e_all);

	

//include ark (from deploy)
$chemin_ark="deploy/deployark";
include $chemin_ark."/arkchain.php";
for($i=1;$i<=20;$i++)
	if(file_exists($chemin_ark."/arkchain.".$i.".php"))
		include $chemin_ark."/arkchain.".$i.".php";
$tabnottoloadagain=array();
if(isset($arkchain) && count($arkchain)>0)
	foreach($arkchain as $arkcour)
	{
		//prepare data
		if(isset($arkcour['file']))
			$arkcour['file']=strtolower($arkcour['file']);
		else
			continue;
		
		if(!isset($arkcour['loadafterabstract']))
			$arkcour['loadafterabstract']=false;
		
		
		//load an ark
		if(file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
		{
			if(!$arkcour['loadafterabstract'])
			{
				$tabnottoloadagain[]="class.".$arkcour['file'].".php";
				include_once $chemin_ark."/class.".$arkcour['file'].".php";
				//eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
			}
		}
	}

//include ark (from core with new ark class deployed with this deployer)
$chemin_ark="rkrsystem/src/ark";
if(file_exists($chemin_ark."/arkchain.php"))
{
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
			
			if(!isset($arkcour['loadafterabstract']))
				$arkcour['loadafterabstract']=false;
			
			
			//load an ark
			if(file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
			{
				if(!$arkcour['loadafterabstract'])
				{
					//check if ark class is already in deployer
					$noload=false;
					foreach($tabnottoloadagain as $nottoload)
						if("class.".$arkcour['file'].".php"==$nottoload)
							$noload=true;
					
					if($noload)
						continue;
					
					include_once $chemin_ark."/class.".$arkcour['file'].".php";
					//eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
				}
			}
		}
}


//include classes abstract (from deploy)
$loader=new Load();
$chemin_abstract_classes="deploy/deployabstract";
$tab_class=$loader->charg_dossier_dans_tab($chemin_abstract_classes);
sort($tab_class);
//print_r($tab_class);
$tabnottoloadagain=array();
foreach($tab_class as $class_to_load)
{
	$tabnottoloadagain[]=substr($class_to_load,strlen($chemin_abstract_classes)+1);
	include_once $class_to_load;
}

//include classes abstract (from core with new abstract class deployed with this deployer)
$chemin_abstract_classes="rkrsystem/src/abstract";
$tab_class=$loader->charg_dossier_dans_tab($chemin_abstract_classes);
if($tab_class!=null)
{
	sort($tab_class);
	//print_r($tab_class);
	foreach($tab_class as $class_to_load)
	{
		$noload=false;
		foreach($tabnottoloadagain as $nottoload)
			if(strstr($class_to_load,$nottoload))
				$noload=true;
		
		if($noload)
			continue;
		
		include_once $class_to_load;
	}
}


//include ark after abstract (from deploy)
$chemin_ark="deploy/deployark";
include $chemin_ark."/arkchain.php";
for($i=1;$i<=20;$i++)
	if(file_exists($chemin_ark."/arkchain.".$i.".php"))
		include $chemin_ark."/arkchain.".$i.".php";
$tabnottoloadagain=array();
if(isset($arkchain) && count($arkchain)>0)
	foreach($arkchain as $arkcour)
	{
		//prepare data
		if(isset($arkcour['file']))
			$arkcour['file']=strtolower($arkcour['file']);
		else
			continue;
		
		if(!isset($arkcour['loadafterabstract']))
			$arkcour['loadafterabstract']=false;
		
		
		//load an ark
		if($arkcour['loadafterabstract'] && file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
		{
			$tabnottoloadagain[]="class.".$arkcour['file'].".php";
			include_once $chemin_ark."/class.".$arkcour['file'].".php";
			//eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
		}
	}

//include ark after abstract (from core with new ark class deployed with this deployer)
$chemin_ark="rkrsystem/src/ark";
if(file_exists($chemin_ark."/arkchain.php"))
{
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
			
			if(!isset($arkcour['loadafterabstract']))
				$arkcour['loadafterabstract']=false;
			
			
			//load an ark
			if($arkcour['loadafterabstract'] && file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
			{
				//check if ark class is already in deployer
				$noload=false;
				foreach($tabnottoloadagain as $nottoload)
					if("class.".$arkcour['file'].".php"==$nottoload)
						$noload=true;
				
				if($noload)
					continue;
				
				include_once $chemin_ark."/class.".$arkcour['file'].".php";
				//eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
			}
		}
}



//include classes deploy
$chemin_deploy_classes="deploy/deployclass";
$tab_class=$loader->charg_dossier_dans_tab($chemin_deploy_classes);
//print_r($tab_class);
foreach($tab_class as $class_to_load)
	include $class_to_load;


//include lib (tpl smarty in deploy)
include "deploy/deploylib/ext/Smarty-3.1.21/libs/Smarty.class.php";


//include conf deploy
$conf=array();
if(file_exists("deploy/conf.deploy.php"))
	include "deploy/conf.deploy.php";


//include package chain deploy
if(file_exists("deploy/package.chain.deploy.php"))
	include "deploy/package.chain.deploy.php";



//log (not used)
$instanceLog=new Log($conf);
$log=$instanceLog->logselected;


//init deploy class
$instanceDeploy=new Deploy($tabpackagetodeploy,$conflictresolution);
$instanceDeploy->log=$log; //log init for deploy



//ajax gestion pour deploy
if(isset($_GET['ajax']) && $_GET['ajax']!="")
{
	include "deploy/deployajax/".$_GET['ajax'].".php";
	exit;
}



//steps allowed in $_POST
$tabstep=array();
$tabstep[]="downloadstep";

//init deploypage
$deploypage="startdeploy";
$deploypagetpl=$deploypage;
//get deploypage
$cptpackagecour=0;
if(isset($_POST['codename']) && $_POST['codename']!="" && array_search($_POST['codename'],$tabstep)===false)
{
	$deploypage=$_POST['codename'];
	while(isset($tabpackagetodeploy[$cptpackagecour]['name']) && $tabpackagetodeploy[$cptpackagecour]['name']!=$deploypage)
		$cptpackagecour++;
	if(isset($tabpackagetodeploy[++$cptpackagecour]['name']))
		$deploypage=$tabpackagetodeploy[$cptpackagecour]['name'];
	while(!file_exists("package/".$deploypage."/conf.form.xml") && isset($tabpackagetodeploy[++$cptpackagecour]['name']))
		$deploypage=$tabpackagetodeploy[$cptpackagecour]['name'];
	$deploypagetpl="conf.form";
}
if(isset($_POST['codename']) && array_search($_POST['codename'],$tabstep)!==false)
{
	$deploypage=$_POST['codename'];
	$deploypagetpl=$deploypage;
}
if($cptpackagecour>=count($tabpackagetodeploy))
{
	$deploypage="deployment";
	$deploypagetpl=$deploypage;
}



//tp
$tpl=new TemplateSmarty();

//get tpl page
$tpl->remplir_template("deploypage",$deploypagetpl);

//title
$tpl->remplir_template("maintitle","RoDKoDRoK System");

//subtitle
if($deploypage=="startdeploy")
	$tpl->remplir_template("mainsubtitle","Start deployment");
else if($deploypage=="deployment")
	$tpl->remplir_template("mainsubtitle","End deployment");
else if($deploypage=="downloadstep")
	$tpl->remplir_template("mainsubtitle","Download all packages from RoDKoDRoK.com");
else
	$tpl->remplir_template("mainsubtitle","Package ".$deploypage);


//get content
$content=$instanceDeploy->getDeployContent($deploypage);
$tpl->remplir_template("content",$content);

$form=$instanceDeploy->getDeployForm($deploypage);
$tpl->remplir_template("form",$form);


//charg contenu page
$tpl->affich_template($maintemplate);



?>
