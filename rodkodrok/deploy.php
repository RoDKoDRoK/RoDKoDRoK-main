<?php

session_start();

//to kill en mode prod
ini_set('display_errors', 1);
//error_reporting(e_all);

	

//include classes abstract
$chemin_abstract_classes="abstract";
include $chemin_abstract_classes."/class.load.php";
$loader=new Load();
$tab_class=$loader->charg_dossier_dans_tab($chemin_abstract_classes);
sort($tab_class);
//print_r($tab_class);
foreach($tab_class as $class_to_load)
{
	if(!strstr($class_to_load,"class.load.php"))
		include $class_to_load;
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
