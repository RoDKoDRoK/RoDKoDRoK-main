<?php

//session
session_start();

//check if config php ok
ini_set('memory_limit', '128M');
ini_set('post_max_size', '128M');
ini_set('upload_max_filesize', '128M');


//to kill en mode prod
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(e_all);


//get chain connector
$chainconnector="none";
if(isset($_GET['chainconnector']) && $_GET['chainconnector']!="")
	$chainconnector=$_GET['chainconnector'];


//load ark
$chemin_ark="core/src/ark";
if(file_exists($chemin_ark."/arkchain.php"))
	include $chemin_ark."/arkchain.php";
for($i=1;$i<=20;$i++)
	if(file_exists($chemin_ark."/arkchain.".$i.".php"))
		include $chemin_ark."/arkchain.".$i.".php";
if(isset($arkchain) && count($arkchain)>0)
{
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
		
		if(!isset($arkcour['loadafterabstract']))
			$arkcour['loadafterabstract']=false;
		
		if(!isset($arkcour['makevar']))
			$arkcour['makevar']=false;
		
		if(isset($arkcour['var']))
			$arkcour['var']=strtolower($arkcour['var']);
		else
			$arkcour['var']=strtolower($arkcour['file']);
		
		
		//load an ark
		if(file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
		{
			if(!$arkcour['loadafterabstract'])
			{			
				include_once $chemin_ark."/class.".$arkcour['file'].".php";
				if($arkcour['makevar'])
					eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
			}
		}
		else
		{
			//test site to deploy
			echo "<script>document.location.href='deploy.php';</script>";
			exit;
		}
	}
}
else
{
	//test site to deploy
	echo "<script>document.location.href='deploy.php';</script>";
	exit;
}


//load chain connector
if(file_exists($arkitect->get("chain")."/connector.chain.".$chainconnector.".php"))
	include_once $arkitect->get("chain")."/connector.chain.".$chainconnector.".php";
else if(!file_exists($arkitect->get("chain")."/connector.chain.default.php"))
{
	//test site to deploy
	echo "<script>document.location.href='deploy.php';</script>";
	exit;
}
else
{
	include_once $arkitect->get("chain")."/connector.chain.default.php";
	if(isset($firstchain) && file_exists($arkitect->get("chain")."/connector.chain.".$firstchain.".php"))
	{
		include_once $arkitect->get("chain")."/connector.chain.".$firstchain.".php";
		$chainconnector=$firstchain;
		//echo $firstchain;
	}
	else
		$chainconnector="default";
}


//include classes abstract
$chemin_classes=$arkitect->get("abstract");
$tab_class=$loader->charg_dossier_dans_tab($chemin_classes);
sort($tab_class);
//print_r($tab_class);
foreach($tab_class as $class_to_load)
{
	include $class_to_load;
}


//load ark suite after abstract
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
		
		if(!isset($arkcour['loadafterabstract']))
			$arkcour['loadafterabstract']=false;
			
		if(!isset($arkcour['makevar']))
			$arkcour['makevar']=false;
		
		if(isset($arkcour['var']))
			$arkcour['var']=strtolower($arkcour['var']);
		else
			$arkcour['var']=strtolower($arkcour['file']);
		
		
		//load an ark
		if($arkcour['loadafterabstract'] && file_exists($chemin_ark."/class.".$arkcour['file'].".php"))
		{
			include_once $chemin_ark."/class.".$arkcour['file'].".php";
			if($arkcour['makevar'])
				eval("\$".$arkcour['var']."=new ".$arkcour['class']."();");
		}
	}


//charge chains dans tab
$chemin_chain=$arkitect->get("chain");
$chaintab=$loader->charg_chain_dans_tab($chemin_chain);
//print_r($chaintab);



//init initer
$initer=array();
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


//cas appel php from console
if(isset($argv))
	$initer['argv']=$argv;


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



//construct tab to print (array with the connector data to print)
$toprint=$loader->construct_tab_toprint($tabconnector,$initer);
//print_r($toprint);
$initer['toprint']=$toprint;



//post exec connector	
foreach($tabconnector as $connectorcour)
{
	$connectorlowercase=strtolower($connectorcour['name']);
	$connectorclass=ucfirst($connectorlowercase);
	
	if(!file_exists($arkitect->get("connector")."/connector.".$connectorlowercase.".php"))
		continue;
	
	eval("\$instanceConnector=\$instanceConnector".$connectorclass.";");
	
	$instanceConnector->reloadIniter($initer);
	$instanceConnector->postexec();
	$initer=$instanceConnector->initer;
	
}


//reconstruct tab to print (array with the connector data to print)
$toprint=$loader->construct_tab_toprint($tabconnector,$initer);
//print_r($toprint);
$initer['toprint']=$toprint;


//end connector
$reversetabconnector=array_reverse($tabconnector);
foreach($reversetabconnector as $connectorcour)
{
	$connectorlowercase=strtolower($connectorcour['name']);
	$connectorclass=ucfirst($connectorlowercase);
	
	if(!file_exists($arkitect->get("connector")."/connector.".$connectorlowercase.".php"))
		continue;
	
	eval("\$instanceConnector=\$instanceConnector".$connectorclass.";");
	//$instanceConnector->initer=$initer;
	$instanceConnector->reloadIniter($initer);
	$instanceConnector->end();
	$initer=$instanceConnector->initer;
	
}



?>
