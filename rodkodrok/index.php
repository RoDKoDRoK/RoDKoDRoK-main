<?php

//session
session_start();

//to kill en mode prod
ini_set('display_errors', 1);
//error_reporting(e_all);


//get chain connector
$chainconnector="none";
if(isset($_GET['chainconnector']) && $_GET['chainconnector']!="")
	$chainconnector=$_GET['chainconnector'];

//load chain connector
if(file_exists("chain/connector.chain.".$chainconnector.".php"))
	include_once "chain/connector.chain.".$chainconnector.".php";
else if(!file_exists("chain/connector.chain.default.php"))
{
	//test site to deploy
	echo "<script>document.location.href='deploy.php';</script>";
	exit;
}
else
{
	include_once "chain/connector.chain.default.php";
	if(isset($firstchain) && file_exists("chain/connector.chain.".$firstchain.".php"))
	{
		include_once "chain/connector.chain.".$firstchain.".php";
		$chainconnector=$firstchain;
		//echo $firstchain;
	}
	else
		$chainconnector="default";
}


//include classes abstract
$chemin_classes="abstract";
include $chemin_classes."/class.load.php";
$loader=new Load();
$tab_class=$loader->charg_dossier_dans_tab($chemin_classes);
sort($tab_class);
//print_r($tab_class);
foreach($tab_class as $class_to_load)
{
	if(!strstr($class_to_load,"class.load.php"))
		include $class_to_load;
}

//charge chains dans tab
$chemin_chain="chain";
$chaintab=$loader->charg_chain_dans_tab($chemin_chain);
//print_r($chaintab);



//init initer
$initer=array();
$initer['chainconnector']=$chainconnector;
$initer['loader']=$loader;
$initer['chaintab']=$chaintab;

//cas appel php from console
if(isset($argv))
	$initer['argv']=$argv;


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



//construct tab to print (array with the connector data to print)
$toprint=$loader->construct_tab_toprint($tabconnector,$initer);
//print_r($toprint);
$initer['toprint']=$toprint;



//post exec connector	
foreach($tabconnector as $connectorcour)
{
	$connectorlowercase=strtolower($connectorcour['name']);
	$connectorclass=ucfirst($connectorlowercase);
	
	if(!file_exists("connector/connector.".$connectorlowercase.".php"))
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
	
	if(!file_exists("connector/connector.".$connectorlowercase.".php"))
		continue;
	
	eval("\$instanceConnector=\$instanceConnector".$connectorclass.";");
	//$instanceConnector->initer=$initer;
	$instanceConnector->reloadIniter($initer);
	$instanceConnector->end();
	$initer=$instanceConnector->initer;
	
}



?>
