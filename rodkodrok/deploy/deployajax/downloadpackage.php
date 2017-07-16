<?php

$packagename=$_POST['packagename'];


$initer=array();
$initer['loader']=new Load();

$instancePackage=new PratikPackage($initer);

if($instancePackage->getPackageFromRoDKoDRoKCom($packagename))
	echo "Loading ".$packagename." : done";
else
	echo "Error";

?>