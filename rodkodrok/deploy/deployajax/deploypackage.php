<?php

$packagename=$_POST['packagename'];

$checklist=array();
$tabdeployedfiles=array();
		
//SET INITER
$initer=array();
$initer['conf']=array();
$initer['db']=null;
$initer['log']=null;

//RECONSTRUCT INITER
$initer=$instanceDeploy->initerConstruct($initer);


//INIT PACKAGER
$instancePackage=new PratikPackage($initer);

//SET CONFLICT MODE
$instancePackage->setConflictResolution($instanceDeploy->conflictresolution);

//RELOAD INITER IN INSTANCE PACKAGE
$instancePackage->reloadIniter($initer);


//DEPLOY PACKAGE
$tabdeployedfiles[]=$instancePackage->deploy($packagename);
	
//CHECKLIST RESULT OF DEPLOYMENT OF THE PACKAGE
$checklist[]=$packagename;


$checklisttexte="<br />";
$checklisttexte.="<div>New package deployment :</div>";
$cptchecklist=0;
foreach($checklist as $checkpackage)
{
	$checklisttexte.="<div> - ".$checkpackage."</div>";
	if($tabdeployedfiles[$cptchecklist])
		foreach($tabdeployedfiles[$cptchecklist] as $deployedfile)
			$checklisttexte.="<div> --- ".$deployedfile."</div>";
	$cptchecklist++;
}
$checklisttexte.="<br />";

echo $checklisttexte;

?>